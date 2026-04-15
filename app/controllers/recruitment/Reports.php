<?php

class Reports extends Controller
{
    public function index()
    {
        Auth::requireRole(3);

        $reportModel = new Report();
        $userId = Auth::user_id();

        $activeTab = $_GET['tab'] ?? 'generate';
        $mode = $_GET['mode'] ?? 'create';
        $reportId = isset($_GET['report_id']) ? (int) $_GET['report_id'] : 0;

        $fromDate = $_GET['from_date'] ?? '';
        $toDate = $_GET['to_date'] ?? '';
        $reportType = $_GET['report_type'] ?? 'all';

        $selectedApplicationIds = [];
        $editingReport = null;

        if (($mode === 'edit' || $mode === 'view') && $reportId > 0) {
            $editingReport = $reportModel->getSavedReportById($reportId, $userId);
            if ($editingReport) {
                $fromDate = $editingReport['from_date'];
                $toDate = $editingReport['to_date'];
                $reportType = strtolower(str_replace(' ', '_', $editingReport['report_type']));
                $selectedApplicationIds = $reportModel->getSavedReportApplicationIds($reportId);
                $activeTab = 'generate';
            }
        }

        $previewApplicants = [];
        $summaryCounts = [
            'total_applications' => 0,
            'applied_count' => 0,
            'shortlisted_count' => 0,
            'interview_scheduled_count' => 0,
            'offered_count' => 0,
            'rejected_count' => 0
        ];
        $typeCount = 0;

        if (!empty($fromDate) && !empty($toDate)) {
            $previewApplicants = $reportModel->getApplicantsByDateRangeAndType($fromDate, $toDate, $reportType);
            $summaryCounts = $reportModel->getSummaryCounts($fromDate, $toDate) ?: $summaryCounts;
            $typeCount = $reportModel->getTypeCount($fromDate, $toDate, $reportType);
        }

        $data = [];
        $data['page_title'] = 'Recruitment Reports';
        $data['active_tab'] = $activeTab;
        $data['mode'] = $mode;
        $data['editing_report'] = $editingReport;
        $data['report_filters'] = [
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'report_type' => $reportType
        ];
        $data['summary_counts'] = $summaryCounts;
        $data['type_count'] = $typeCount;
        $data['preview_applicants'] = is_array($previewApplicants) ? $previewApplicants : [];
        $data['selected_application_ids'] = $selectedApplicationIds;
        $data['saved_reports'] = $reportModel->getSavedReports($userId) ?: [];
        $data['status_type_labels'] = [
            'all' => 'All',
            'shortlisted' => 'Shortlisted Applicants',
            'interview_scheduled' => 'Interview Scheduled Applicants',
            'rejected' => 'Rejected Applicants',
            'offered' => 'Offered Applicants'
        ];

        $data['success'] = $_SESSION['success'] ?? '';
        $data['error'] = $_SESSION['error'] ?? '';
        unset($_SESSION['success'], $_SESSION['error']);

        $this->view('recruitment/reports', $data);
    }

    public function create()
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('recruitment/reports');
            return;
        }

        $reportModel = new Report();
        $userId = Auth::user_id();

        $payload = [
            'title' => trim($_POST['title'] ?? ''),
            'from_date' => $_POST['from_date'] ?? '',
            'to_date' => $_POST['to_date'] ?? '',
            'report_type' => $this->normalizeReportType($_POST['report_type'] ?? 'all')
        ];

        $selected = $_POST['selected_applications'] ?? [];
        $selected = array_values(array_unique(array_map('intval', (array) $selected)));

        if (empty($payload['title']) || empty($payload['from_date']) || empty($payload['to_date'])) {
            $_SESSION['error'] = 'Title, date range, and report type are required.';
            redirect('recruitment/reports?tab=generate');
            return;
        }

        if (empty($selected)) {
            $_SESSION['error'] = 'Please select at least one applicant to include in the report.';
            redirect('recruitment/reports?tab=generate&from_date=' . urlencode($payload['from_date']) . '&to_date=' . urlencode($payload['to_date']) . '&report_type=' . urlencode($_POST['report_type'] ?? 'all'));
            return;
        }

        $created = $reportModel->createRecruitmentReport($payload, $selected, $userId);

        if (!$created) {
            $_SESSION['error'] = 'Failed to create report.';
            redirect('recruitment/reports?tab=generate');
            return;
        }

        $_SESSION['success'] = 'Report created successfully.';
        redirect('recruitment/reports?tab=created');
    }

    public function update($id = null)
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('recruitment/reports');
            return;
        }

        $reportModel = new Report();
        $userId = Auth::user_id();
        $existing = $reportModel->getSavedReportById((int) $id, $userId);

        if (!$existing) {
            $_SESSION['error'] = 'Report not found.';
            redirect('recruitment/reports?tab=created');
            return;
        }

        $payload = [
            'title' => trim($_POST['title'] ?? ''),
            'from_date' => $_POST['from_date'] ?? '',
            'to_date' => $_POST['to_date'] ?? '',
            'report_type' => $this->normalizeReportType($_POST['report_type'] ?? 'all')
        ];

        $selected = $_POST['selected_applications'] ?? [];
        $selected = array_values(array_unique(array_map('intval', (array) $selected)));

        if (empty($payload['title']) || empty($payload['from_date']) || empty($payload['to_date'])) {
            $_SESSION['error'] = 'Title, date range, and report type are required.';
            redirect('recruitment/reports?tab=generate&mode=edit&report_id=' . (int) $id);
            return;
        }

        if (empty($selected)) {
            $_SESSION['error'] = 'Please keep at least one selected applicant in the report.';
            redirect('recruitment/reports?tab=generate&mode=edit&report_id=' . (int) $id);
            return;
        }

        $updated = $reportModel->updateRecruitmentReport((int) $id, $payload, $selected, $userId);
        if (!$updated) {
            $_SESSION['error'] = 'Failed to update report.';
            redirect('recruitment/reports?tab=generate&mode=edit&report_id=' . (int) $id);
            return;
        }

        $_SESSION['success'] = 'Report updated successfully.';
        redirect('recruitment/reports?tab=created');
    }

    public function delete($id = null)
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('recruitment/reports?tab=created');
            return;
        }

        $reportModel = new Report();
        $userId = Auth::user_id();

        $existing = $reportModel->getSavedReportById((int) $id, $userId);
        if (!$existing) {
            $_SESSION['error'] = 'Report not found.';
            redirect('recruitment/reports?tab=created');
            return;
        }

        $deleted = $reportModel->softDeleteRecruitmentReport((int) $id, $userId);
        if (!$deleted) {
            $_SESSION['error'] = 'Failed to delete report.';
            redirect('recruitment/reports?tab=created');
            return;
        }

        $_SESSION['success'] = 'Report deleted successfully.';
        redirect('recruitment/reports?tab=created');
    }

    private function normalizeReportType($type)
    {
        $normalized = strtolower(trim((string) $type));

        $map = [
            'all' => 'All',
            'shortlisted' => 'Shortlisted',
            'interview_scheduled' => 'Interview Scheduled',
            'rejected' => 'Rejected',
            'offered' => 'Offered'
        ];

        return $map[$normalized] ?? 'All';
    }
}
