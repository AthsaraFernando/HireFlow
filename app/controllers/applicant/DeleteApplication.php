<?php

require_once __DIR__ . '/Applications.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/deleteApplication/{id}
 */
class DeleteApplication extends Controller
{
    public function index($application_id = null)
    {
        $applications = new Applications();
        return $applications->delete($application_id);
    }
}
