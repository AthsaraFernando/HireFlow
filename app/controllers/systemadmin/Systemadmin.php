<?php

class Systemadmin extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);
        
        if (!empty($URL)) {
            extract($URL);
        }
        redirect('systemadmin/dashboard');
        exit();
    }
}
