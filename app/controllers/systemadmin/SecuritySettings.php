<?php

class SecuritySettings extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);
        
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        if ($_POST) {
            // Handle security settings updates
            $data['success'] = 'Security settings updated successfully!';
        }
        
        $this->view('systemadmin/security-settings', $data);
    }
}
