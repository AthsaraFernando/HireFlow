<?php

require_once __DIR__ . '/Profile.php';

/**
 * Legacy route compatibility controller.
 * Supports /applicant/profileEdit
 */
class ProfileEdit extends Controller
{
    public function index()
    {
        $profile = new Profile();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $profile->update();
        }

        return $profile->index();
    }

    public function update()
    {
        $profile = new Profile();
        return $profile->update();
    }
}
