<?php

class Signout extends Controller
{
    public function index()
    {
        // Logout user using Auth class
        Auth::logout();
        
        // Redirect to signin with logout message
        redirect('signin?logout=1');
    }
}
