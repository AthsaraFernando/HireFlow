<?php

class Signout extends Controller
{
    public function index()
    {
        if (!empty($_SESSION['USER'])) {
            unset($_SESSION['USER']);
        }
        redirect('home');
    }


}
