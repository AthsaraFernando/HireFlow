<?php

class Applicant extends Controller
{
    public function index()
    {
        if (!empty($URL)) {
            extract($URL);
        }
        redirect('applicant/dashboard');
        exit();
    }
}
