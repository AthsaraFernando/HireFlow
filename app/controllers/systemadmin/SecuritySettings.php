<?php

class SecuritySettings extends Controller
{
    public function index()
    {
        
        Auth::requireRole(1);
        
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        if ($_POST) {

            $data['success'] = 'Security settings updated successfully!';
        }
        
        $this->view('systemadmin/security-settings', $data);
    }
}
