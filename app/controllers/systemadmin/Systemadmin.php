<?php

class Systemadmin extends Controller
{
    public function index()
    {

        Auth::requireRole(1);
        
        if (!empty($URL)) {
            extract($URL);
        }
        redirect('systemadmin/dashboard');
        exit();
    }
}
