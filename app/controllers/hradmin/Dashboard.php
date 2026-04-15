<?php

class Dashboard extends Controller
{
    public function index()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'HR Dashboard';

        $dashboardModel = new HrDashboard();
        $dashboardData = $dashboardModel->getDashboardData();

        $summary = $dashboardData['summary'] ?? [];
        $data['total_jobs'] = (int)($summary['total_jobs'] ?? 0);
        $data['active_jobs'] = (int)($summary['active_jobs'] ?? 0);
        $data['total_applications'] = (int)($summary['total_applications'] ?? 0);
        $data['pending_applications'] = (int)($summary['pending_applications'] ?? 0);
        $data['scheduled_interviews'] = (int)($summary['scheduled_interviews'] ?? 0);
        $data['new_applicants'] = (int)($summary['new_applicants'] ?? 0);

        $data['recent_applications'] = $dashboardData['recent_applications'] ?? [];
        $data['active_job_posts'] = $dashboardData['active_job_posts'] ?? [];
        $data['upcoming_interviews'] = $dashboardData['upcoming_interviews'] ?? [];
        $data['quick_stats'] = $dashboardData['quick_stats'] ?? [];
        
        $this->view('hradmin/dashboard', $data);
    }

    public function liveData()
    {
        Auth::requireRole(2);

        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

        try {
            $dashboardModel = new HrDashboard();
            $payload = $dashboardModel->getDashboardData();
            echo json_encode(['success' => true, 'data' => $payload]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Unable to fetch dashboard data']);
        }

        exit;
    }
}
