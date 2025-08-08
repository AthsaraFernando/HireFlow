<?php

class Systemadmin extends Controller
{
    public function index()
    {
        if (!empty($URL)) {
            extract($URL);
        }
        redirect('systemadmin/dashboard');
        exit();
    }
}
