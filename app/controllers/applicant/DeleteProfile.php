<?php

require_once __DIR__ . '/Profile.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/deleteProfile
 */
class DeleteProfile extends Controller
{
    public function index()
    {
        $profile = new Profile();
        return $profile->delete();
    }
}
