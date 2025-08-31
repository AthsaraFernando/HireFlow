<?php

class Viewdata extends Controller 
{
    public function index()
    {
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        $this->view('systemadmin/viewdata', $data);
    }
}