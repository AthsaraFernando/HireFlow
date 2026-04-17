<?php

class Reports extends Controller
{
    public function index()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'HR Analytics & Reports';

        $filters = $this->getReportFiltersFromRequest();
        $data['filters'] = $filters;

        $departmentModel = new Department();
        $data['department_options'] = $departmentModel->findAll() ?: [];

        $livePayload = $this->buildReportPayload($filters);
        $data = array_merge($data, $livePayload);
        
        $this->view('hradmin/reports', $data);
    }

    public function liveData()
    {
        Auth::requireRole(2);

        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

        try {
            $filters = $this->getReportFiltersFromRequest();
            $payload = $this->buildReportPayload($filters);
            echo json_encode(['success' => true, 'data' => $payload]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Unable to fetch report data']);
        }

        exit;
    }

    private function buildReportPayload($filters = [])
    {
        $reportModel = new Report();

        $funnelStats = $reportModel->getRecruitmentFunnelStats($filters) ?: [];
        $dashboardMetrics = $reportModel->getDashboardKpiMetrics($filters) ?: [];
        $conversionRates = $reportModel->getConversionRates($filters) ?: [];
        $applicationsOverTime = $reportModel->getApplicationsOverTime(12, $filters) ?: [];
        $monthlyTrends = $reportModel->getMonthlyApplicationTrends(6, $filters) ?: [];
        $departmentStats = $reportModel->getDepartmentStats($filters) ?: [];
        $interviewStats = $reportModel->getInterviewStats($filters) ?: [];
        $statusDistribution = $reportModel->getStatusDistribution($filters) ?: [];
        $topPerformingJobs = $reportModel->getTopPerformingJobPosts(5, $filters) ?: [];
        $interviewerPerformance = $reportModel->getInterviewerPerformance(5, $filters) ?: [];

        $successRate = $reportModel->getSuccessRate($filters);
        $applicationSources = $reportModel->getApplicationSourceStats($filters) ?: [];

        return [
            'filters' => $filters,
            'funnel_stats' => $funnelStats,
            'dashboard_metrics' => $dashboardMetrics,
            'conversion_rates' => $conversionRates,
            'applications_timeline' => $applicationsOverTime,
            'monthly_trends' => $monthlyTrends,
            'department_stats' => $departmentStats,
            'interview_stats' => $interviewStats,
            'status_distribution' => $statusDistribution,
            'top_performing_jobs' => $topPerformingJobs,
            'interviewer_performance' => $interviewerPerformance,
            'application_sources' => $applicationSources,
            'total_hires' => (int)($funnelStats['successful_hires'] ?? 0),
            'avg_time_to_hire' => (int)($dashboardMetrics['avg_time_to_hire'] ?? 0),
            'success_rate' => $successRate,
            'hiring_metrics' => [
                'total_applications' => (int)($funnelStats['total_applications'] ?? 0),
                'screening_passed' => (int)($funnelStats['screening_passed'] ?? 0),
                'interviews_scheduled' => (int)($funnelStats['interviews_scheduled'] ?? 0),
                'offers_extended' => (int)($funnelStats['offers_extended'] ?? 0),
                'successful_hires' => (int)($funnelStats['successful_hires'] ?? 0),
                'average_time_to_hire' => (int)($dashboardMetrics['avg_time_to_hire'] ?? 0),
                'success_rate' => $successRate,
            ],
        ];
    }

    private function getReportFiltersFromRequest()
    {
        $dateRange = strtolower(trim((string)($_GET['date_range'] ?? '30d')));
        $allowedDateRanges = ['7d', '30d', '90d', '1y', 'custom'];
        if (!in_array($dateRange, $allowedDateRanges, true)) {
            $dateRange = '30d';
        }

        $departmentId = (int)($_GET['department_id'] ?? 0);
        if ($departmentId < 0) {
            $departmentId = 0;
        }

        $level = strtolower(trim((string)($_GET['level'] ?? '')));
        $allowedLevels = ['entry', 'mid', 'senior', 'lead', 'executive'];
        if (!in_array($level, $allowedLevels, true)) {
            $level = '';
        }

        $reportType = strtolower(trim((string)($_GET['report_type'] ?? 'overview')));
        $allowedReportTypes = ['overview', 'recruitment', 'performance', 'diversity', 'cost'];
        if (!in_array($reportType, $allowedReportTypes, true)) {
            $reportType = 'overview';
        }

        $startDate = null;
        $endDate = date('Y-m-d');

        switch ($dateRange) {
            case '7d':
                $startDate = date('Y-m-d', strtotime('-7 days'));
                break;
            case '30d':
                $startDate = date('Y-m-d', strtotime('-30 days'));
                break;
            case '90d':
                $startDate = date('Y-m-d', strtotime('-90 days'));
                break;
            case '1y':
                $startDate = date('Y-m-d', strtotime('-1 year'));
                break;
            case 'custom':
                $requestedStart = trim((string)($_GET['start_date'] ?? ''));
                $requestedEnd = trim((string)($_GET['end_date'] ?? ''));
                if ($requestedStart !== '' && $requestedEnd !== '' && $requestedStart <= $requestedEnd) {
                    $startDate = $requestedStart;
                    $endDate = $requestedEnd;
                } else {
                    $dateRange = '30d';
                    $startDate = date('Y-m-d', strtotime('-30 days'));
                }
                break;
        }

        return [
            'date_range' => $dateRange,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'department_id' => $departmentId > 0 ? $departmentId : null,
            'level' => $level,
            'report_type' => $reportType,
        ];
    }
}
