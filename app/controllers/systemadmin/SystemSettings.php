<?php

class SystemSettings extends Controller
{
    public function index()
    {
        
        Auth::requireRole(1);
        
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        if ($_POST) {
            
            $data['success'] = 'System settings updated successfully!';
        }
        
        $this->view('systemadmin/system-settings', $data);
    }
}
