<?php

/**
 * Applicant Controller (Main Router)  
 * Default controller for applicant section - redirects to dashboard
 */
class Applicant extends Controller
{
    use ApplicantBaseTrait;

    private function applicationsController()
    {
        return new Applications();
    }

    public function index()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        // Default route redirects to dashboard
        redirect('applicant/dashboard');
    }

    // Legacy route compatibility: /applicant/viewApplication/{id}
    public function viewApplication($application_id = null)
    {
        return $this->applicationsController()->viewApplication($application_id);
    }

    // Legacy route compatibility: /applicant/editApplication/{id}
    public function editApplication($application_id = null)
    {
        return $this->applicationsController()->edit($application_id);
    }

    // Legacy route compatibility: /applicant/deleteApplication/{id}
    public function deleteApplication($application_id = null)
    {
        return $this->applicationsController()->delete($application_id);
    }
}