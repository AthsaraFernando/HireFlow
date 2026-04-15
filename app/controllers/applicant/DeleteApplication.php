<?php

class DeleteApplication extends Controller
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

        if (!in_array($application['status'], ['Applied', 'Under Review'])) {
            $_SESSION['error'] = "This application cannot be deleted at this stage.";
            redirect('applicant/applications');
            return;
        }

        $this->deleteResumeFile($application['resume_path'] ?? '');

        if ($applicationModel->deleteApplication($application_id)) {
            $_SESSION['success'] = "Application deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete application. Please try again.";
        }

        redirect('applicant/applications');
    }
}
