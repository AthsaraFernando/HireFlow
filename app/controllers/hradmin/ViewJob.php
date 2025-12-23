<?php

class ViewJob extends Controller
{
    public function index($id = null)
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        if (!$id) {
            // Redirect to job posts if no ID provided
            header('Location: /HireFlow/public/hradmin/job-posts');
            exit;
        }
        
        $data = [];
        $data['page_title'] = 'Job Details';
        $data['job_id'] = $id;
        
        // Fetch job data from database
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $id], []);
        
        if (!$job) {
            $_SESSION['error_message'] = 'Job post not found.';
            redirect('hradmin/job-posts');
            exit;
        }
        
        // Get creator information
        $user = new User();
        $creator = $user->first(['id' => $job['hr_id']], []);
        $job['created_by'] = $creator ? $creator['full_name'] : 'Unknown';
        
        // Get department information if department_id exists
        if (!empty($job['department_id'])) {
            $departmentModel = new Department();
            $department = $departmentModel->first(['id' => $job['department_id']], []);
            if ($department) {
                $job['department'] = $department['name'];
            }
        }
        
        // Get application statistics
        $application = new Application();
        $allApplications = $application->where(['job_id' => $id], []);
        $job['total_applications'] = count($allApplications);
        
        // Count new applications (Applied status)
        $job['new_applications'] = 0;
        $job['interviews_scheduled'] = 0;
        $job['offers_made'] = 0;
        
        foreach ($allApplications as $app) {
            if ($app['status'] === 'Applied' || $app['status'] === 'Under Review') {
                $job['new_applications']++;
            } elseif ($app['status'] === 'Interview Scheduled') {
                $job['interviews_scheduled']++;
            } elseif ($app['status'] === 'Offer Made') {
                $job['offers_made']++;
            }
        }
        
        // Map database fields to view expectations
        $job['summary'] = $job['description'];
        $job['type'] = $job['employment_type'];
        $job['created_date'] = $job['created_at'] ?? date('Y-m-d');
        
        $data['job'] = $job;
        
        $data['job'] = $job;
        
        // Get recent applications for this job
        $recentApps = array_slice($allApplications, 0, 5);
        $data['recent_applications'] = [];
        
        foreach ($recentApps as $app) {
            $applicant = $user->first(['id' => $app['applicant_id']], []);
            if ($applicant) {
                $data['recent_applications'][] = [
                    'id' => $app['id'],
                    'applicant_name' => $applicant['full_name'],
                    'email' => $applicant['email'],
                    'applied_date' => $app['applied_at'] ?? $app['created_at'],
                    'status' => $app['status'],
                    'experience' => $app['years_of_experience'] ?? 'N/A',
                    'score' => $app['score'] ?? 0
                ];
            }
        }
        
        // Analytics data for charts (simplified)
        $data['application_stats'] = [
            'daily_applications' => [],
            'status_breakdown' => []
        ];
        
        // Count status breakdown
        $statusCounts = [];
        foreach ($allApplications as $app) {
            $status = $app['status'];
            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
            $statusCounts[$status]++;
        }
        $data['application_stats']['status_breakdown'] = $statusCounts;
        
        $this->view('hradmin/view-job', $data);
    }
}
