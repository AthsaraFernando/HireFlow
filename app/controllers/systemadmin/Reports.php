<?php

class Reports extends Controller
{
    public function index()
    {

        Auth::requireRole(1);


        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $jobPost = new JobPost();
        $user = new User();
        $application = new Application();
        $stats = new SystemStats();
        $accessLogs = new AccessLog();
        $interviews = new Interview();


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
        $data['application_status_counts'] = $application->applicationStatusCounts();


        if ($_POST) {
            $data['success'] = 'Report generated successfully!';
        }

        $data['view'] = 'reports';
        $this->view('systemadmin', $data);
    }
}
