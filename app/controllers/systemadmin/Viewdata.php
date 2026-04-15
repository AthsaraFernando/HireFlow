<?php

class Viewdata extends Controller 
{
    public function index()
    {
        
        Auth::requireRole(1);
        
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        $this->view('systemadmin/viewdata', $data);
    }
}