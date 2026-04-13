<?php

class Applications extends Controller
{
    public function index()
    {
        Auth::requireRole(3);

        $applicationModel = new Application();

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Review Applications';
        $data['selected_job'] = $_GET['job'] ?? 'all';
        $data['selected_status'] = $_GET['status'] ?? 'all';
        $data['search_name'] = trim($_GET['search'] ?? '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $allowedStatuses = ['Shortlisted', 'Rejected', 'Offered'];
            $applicationId = (int)($_POST['application_id'] ?? 0);
            $newStatus = trim($_POST['status'] ?? '');

            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $_SESSION['error'] = 'Invalid request. Please try again.';
                redirect('recruitment/applications');
            }

            if ($applicationId < 1 || !in_array($newStatus, $allowedStatuses, true)) {
                $_SESSION['error'] = 'Invalid application or status.';
                redirect('recruitment/applications');
            }

            $updated = $applicationModel->query(
                "UPDATE applications SET status = :status WHERE id = :id",
                ['status' => $newStatus, 'id' => $applicationId]
            );

            if ($updated !== false) {
                $_SESSION['success'] = 'Application status updated successfully.';
            } else {
                $_SESSION['error'] = 'Failed to update application status.';
            }

            redirect('recruitment/applications');
        }

        $jobsQuery = "SELECT DISTINCT jp.id, jp.title
                      FROM applications a
                      INNER JOIN job_posts jp ON jp.id = a.job_id
                      ORDER BY jp.title ASC";
        $data['jobs'] = $applicationModel->query($jobsQuery) ?: [];

        $statusQuery = "SELECT DISTINCT status FROM applications ORDER BY status ASC";
        $statusRows = $applicationModel->query($statusQuery) ?: [];
        $data['status_filters'] = array_map(function ($row) {
            return $row['status'];
        }, $statusRows);

        $params = [];
        $conditions = [];

        if ($data['selected_job'] !== 'all') {
            $conditions[] = 'a.job_id = :job_id';
            $params['job_id'] = (int)$data['selected_job'];
        }

        if ($data['selected_status'] !== 'all') {
            $conditions[] = 'a.status = :status_filter';
            $params['status_filter'] = $data['selected_status'];
        }

        if ($data['search_name'] !== '') {
            $conditions[] = 'u.full_name LIKE :search_name';
            $params['search_name'] = '%' . $data['search_name'] . '%';
        }

        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }

        $applicationsQuery = "SELECT
                                a.id,
                                a.job_id,
                                a.status,
                                a.applied_at,
                                a.form_data,
                                u.full_name AS applicant_name,
                                u.email AS applicant_email,
                                u.phone AS applicant_phone,
                                jp.title AS job_title
                              FROM applications a
                              INNER JOIN users u ON u.id = a.applicant_id
                              INNER JOIN job_posts jp ON jp.id = a.job_id
                              {$whereClause}
                              ORDER BY a.applied_at DESC, a.id DESC";
        $data['applications'] = $applicationModel->query($applicationsQuery, $params) ?: [];

        $data['status_update_options'] = ['Shortlisted', 'Rejected', 'Offered'];
        $data['csrf_token'] = Auth::generateCSRFToken();
        $data['success'] = $_SESSION['success'] ?? '';
        $data['error'] = $_SESSION['error'] ?? '';

        unset($_SESSION['success'], $_SESSION['error']);

        $this->view('recruitment/applications', $data);
    }
}
