<?php

class Viewdata extends Controller 
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);
        
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        $this->view('systemadmin/viewdata', $data);
    }
}