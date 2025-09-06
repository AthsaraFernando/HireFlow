<?php

class Reports extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);
        
        // Sample data - in real implementation this would come from database queries
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        
        if ($_POST) {
            // Handle report generation
            $data['success'] = 'Report generated successfully!';
        }
        
        $this->view('systemadmin/reports', $data);
    }
}
