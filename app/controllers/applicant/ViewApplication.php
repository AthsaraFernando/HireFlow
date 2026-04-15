<?php

require_once __DIR__ . '/Applications.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/viewApplication/{id}
 */
class ViewApplication extends Controller
{
    public function index($application_id = null)
    {
        $applications = new Applications();
        return $applications->viewApplication($application_id);
    }
}
