<?php

/**
 * Legacy route compatibility controller.
 * Supports /applicant/applicationStatus
 */
class ApplicationStatus extends Controller
{
    public function index()
    {
        Auth::requireRole(4);
        redirect('applicant/applications');
    }
}
