<?php

class Hradmin extends Controller
{
    public function index()
    {
        if (!empty($URL)) {
            extract($URL);
        }
        redirect('hradmin/dashboard');
        exit();
    }
}
