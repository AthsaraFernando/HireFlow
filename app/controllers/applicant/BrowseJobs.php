<?php

require_once __DIR__ . '/Jobs.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/browseJobs
 */
class BrowseJobs extends Controller
{
    public function index()
    {
        $jobs = new Jobs();
        return $jobs->index();
    }
}
