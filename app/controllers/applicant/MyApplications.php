<?php

class MyApplications extends Controller
{
    use ApplicantBaseTrait;

    public function index()
    {
        Auth::requireRole(4);

        $data = [];
        $applicationModel = new Application();
        $user_id = Auth::user_id();

        $data['user'] = $this->getUserData($user_id);

        $applications = $applicationModel->getUserApplications($user_id);

        $data['applications'] = [];
        if ($applications && is_array($applications)) {
            foreach ($applications as $app) {
                $data['applications'][] = [
                    'id' => $app['id'],
                    'job_title' => $app['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'status' => strtolower($app['status']),
                    'status_display' => $app['status'],
                    'applied_date' => date('Y-m-d', strtotime($app['applied_at'])),
                    'last_update' => date('Y-m-d', strtotime($app['applied_at'])),
                    'salary' => $app['salary_range'] ?? 'Not specified',
                    'location' => $app['location'] ?? 'Not specified',
                    'job_id' => $app['job_id'],
                    'department' => $app['department'] ?? 'General',
                    'employment_type' => $app['employment_type'] ?? 'Full-time'
                ];
            }
        }

        $stats = $applicationModel->getApplicationStats($user_id);
        if (!$stats) {
            $stats = [
                'total_applications' => 0,
                'pending_applications' => 0,
                'under_review_applications' => 0,
                'shortlisted_applications' => 0,
                'interview_scheduled' => 0,
                'rejected_applications' => 0,
                'offered_applications' => 0
            ];
        }

        $data['stats'] = [
            'total' => (int)$stats['total_applications'],
            'pending' => (int)$stats['pending_applications'],
            'under_review' => (int)$stats['under_review_applications'],
            'shortlisted' => (int)$stats['shortlisted_applications'],
            'interview_scheduled' => (int)$stats['interview_scheduled'],
            'rejected' => (int)$stats['rejected_applications'],
            'offered' => (int)$stats['offered_applications']
        ];

        $this->view('applicant/applications', $data);
    }
}
