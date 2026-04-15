<?php

require_once __DIR__ . '/Applications.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/editApplication/{id}
 */
class EditApplication extends Controller
{
    public function index($application_id = null)
    {
        $applications = new Applications();
        return $applications->edit($application_id);
    }
}
