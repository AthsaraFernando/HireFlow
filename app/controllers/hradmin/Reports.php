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

        $livePayload = $this->buildReportPayload();
        $data = array_merge($data, $livePayload);
        
        $this->view('hradmin/reports', $data);
    }

    public function liveData()
    {
        Auth::requireRole(2);

        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

        try {
            $payload = $this->buildReportPayload();
            echo json_encode(['success' => true, 'data' => $payload]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Unable to fetch report data']);
        }

        exit;
    }

    private function buildReportPayload()
    {
        $reportModel = new Report();

        $funnelStats = $reportModel->getRecruitmentFunnelStats() ?: [];
        $dashboardMetrics = $reportModel->getDashboardKpiMetrics() ?: [];
        $conversionRates = $reportModel->getConversionRates() ?: [];
        $applicationsOverTime = $reportModel->getApplicationsOverTime(6) ?: [];
        $monthlyTrends = $reportModel->getMonthlyApplicationTrends(6) ?: [];
        $departmentStats = $reportModel->getDepartmentStats() ?: [];
        $interviewStats = $reportModel->getInterviewStats() ?: [];
        $statusDistribution = $reportModel->getStatusDistribution() ?: [];
        $topPerformingJobs = $reportModel->getTopPerformingJobPosts(5) ?: [];
        $interviewerPerformance = $reportModel->getInterviewerPerformance(5) ?: [];

        $totalApplications = (int)($dashboardMetrics['total_applications'] ?? 0);
        $successfulHires = (int)($dashboardMetrics['successful_hires'] ?? 0);
        $successRate = $reportModel->getSuccessRate();

        $applicationSources = [[
            'source' => 'Company Website',
            'applications' => $totalApplications,
            'hires' => $successfulHires,
            'success_rate' => $totalApplications > 0 ? round(($successfulHires / $totalApplications) * 100, 1) : 0,
            'percent_total' => $totalApplications > 0 ? 100.0 : 0,
        ]];

        return [
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
}
