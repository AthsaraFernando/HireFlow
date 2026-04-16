<?php

/**
 * Dashboard Controller
 * Handles applicant dashboard display
 */
class Dashboard extends Controller
{
    use ApplicantBaseTrait;

    public function index()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        $data = [];
        $user_id = Auth::user_id();
        
        // Get current user data
        $userModel = new User();
        $applicationModel = new Application();
        $interviewModel = new Interview();
        $notificationModel = new Notification();
        
        $current_user = Auth::user();
        
        // Get application statistics
        $app_stats = $applicationModel->getApplicationStats($user_id);
        if (!$app_stats) {
            $app_stats = [
                'total_applications' => 0,
                'pending_applications' => 0,
                'under_review_applications' => 0,
                'shortlisted_applications' => 0,
                'interview_scheduled' => 0,
                'rejected_applications' => 0,
                'offered_applications' => 0
            ];
        }
        
        // Get interview statistics
        $interview_stats = $interviewModel->getInterviewCount($user_id);
        if (!$interview_stats) {
            $interview_stats = [
                'total_interviews' => 0,
                'upcoming_interviews' => 0,
                'completed_interviews' => 0
            ];
        }
        
        // Calculate profile completion percentage
        $profile_completion = $this->calculateProfileCompletion($current_user);
        
        // User data for dashboard
        $data['user'] = [
            'name' => $current_user['full_name'] ?? 'User',
            'email' => $current_user['email'] ?? '',
            'profile_completion' => $profile_completion,
            'applications_count' => (int)($app_stats['total_applications'] ?? 0),
            'interviews_count' => (int)($interview_stats['total_interviews'] ?? 0),
            'pending_count' => (int)($app_stats['pending_applications'] ?? 0),
            'shortlisted_count' => (int)($app_stats['shortlisted_applications'] ?? 0),
            'under_review_count' => (int)($app_stats['under_review_applications'] ?? 0),
            'interview_scheduled_count' => (int)($app_stats['interview_scheduled'] ?? 0)
        ];

        // Get recent applications (last 5)
        $recent_apps = $applicationModel->getUserApplications($user_id);
        $data['recent_applications'] = [];
        if ($recent_apps && is_array($recent_apps)) {
            foreach (array_slice($recent_apps, 0, 5) as $app) {
                $data['recent_applications'][] = [
                    'id' => $app['id'],
                    'job_title' => $app['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'status' => strtolower($app['status']),
                    'applied_date' => date('Y-m-d', strtotime($app['applied_at'])),
                    'salary' => $app['salary_range'] ?? 'Not specified'
                ];
            }
        }

        // Get upcoming interviews
        $upcoming_interviews = $interviewModel->getUpcomingInterviews($user_id);
        $data['upcoming_interviews'] = [];
        if ($upcoming_interviews && is_array($upcoming_interviews)) {
            foreach ($upcoming_interviews as $interview) {
                $data['upcoming_interviews'][] = [
                    'id' => $interview['id'],
                    'job_title' => $interview['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'date' => date('Y-m-d', strtotime($interview['scheduled_date'])),
                    'time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'type' => $interview['interview_type'] ?? 'Interview',
                    'interviewer' => $interview['interviewer_name'] ?? 'TBD'
                ];
            }
        }

        // Sync and get unread notifications count from notifications table.
        $notificationModel->syncApplicantNotifications($user_id);
        $data['unread_notifications'] = (int)$notificationModel->getUnreadCount($user_id);

        $this->view('applicant/dashboard', $data);
    }
}
