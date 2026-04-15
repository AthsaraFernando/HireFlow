<?php

/**
 * Legacy route compatibility controller.
 * Supports /applicant/uploadDocuments
 */
class UploadDocuments extends Controller
{
    public function index()
    {
        Auth::requireRole(4);
        redirect('applicant/applications');
    }
}
