<?php

class Reports extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);

        // Sample data - in real implementation this would come from database queries
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $jobPost = new JobPost();
        $user = new User();
        $application = new Application();
        $stats = new SystemStats();
        $accessLogs = new AccessLog();
        $interviews = new Interview();

        // Fetch the required data using models into the controllers and pass to the frontend view
        $data['system_stats'] = [
            'total_users' => $user->getUserCount(),
            'total_jobs' => $jobPost->getJobCount(),
            'total_interviews' => $interviews->getTotalInterviews(),
            'total_applications' => $application->getApplicationCount(),
            'database_size' => $stats->formatBytes($stats->getDatabaseSize(DB_NAME)),
        ];

        $data['user_activity'] = $accessLogs->getUserTrendStats();
        $data['jobpost_stats'] = $jobPost->getJobPostStats();
        $data['interview_stats'] = $interviews->getInterviewStats();
        $data['user_status'] = $user->getUserStatus();
        $data['job_demand'] = $application->jobDemandStat();


        if ($_POST) {
            // Handle report generation
            // Send data to the frontend based on the parameters sent in the fetch request
            $data['success'] = 'Report generated successfully!';
        }

        $data['view'] = 'reports';
        $this->view('systemadmin', $data);
    }
}
