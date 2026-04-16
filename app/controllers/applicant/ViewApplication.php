<?php

class ViewApplication extends Controller
{
    use ApplicantBaseTrait;

    public function index($application_id = null)
    {
        Auth::requireRole(4);

        if (!$application_id) {
            redirect('applicant/applications');
            return;
        }

        $applicationModel = new Application();
        $user_id = Auth::user_id();

        $application = $applicationModel->getApplicationById($application_id);

        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }

        $this->ensureResumeFileAccessible($application['resume_path'] ?? '');

        $data = [];
        $data['user'] = $this->getUserData($user_id);
        $data['application'] = [
            'id' => $application['id'],
            'job_id' => $application['job_id'],
            'job_title' => $application['job_title'] ?? 'Unknown Position',
            'company' => 'HireFlow Company',
            'location' => $application['location'] ?? 'Not specified',
            'salary' => $application['salary_range'] ?? 'Not specified',
            'department' => $application['department'] ?? 'General',
            'employment_type' => $application['employment_type'] ?? 'Full-time',
            'status' => $application['status'],
            'cover_letter' => $application['cover_letter'],
            'resume_path' => $application['resume_path'],
            'applied_date' => date('M d, Y', strtotime($application['applied_at'])),
            'deadline' => $application['deadline'] ? date('M d, Y', strtotime($application['deadline'])) : 'Open'
        ];

        parent::view('applicant/view-application', $data);
    }
}
