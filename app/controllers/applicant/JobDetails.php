<?php

require_once __DIR__ . '/Jobs.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/jobDetails/{id}
 */
class JobDetails extends Controller
{
    public function index($id = null)
    {
        $jobs = new Jobs();
        return $jobs->details($id);
    }
}
