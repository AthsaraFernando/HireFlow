<?php

class Dashboard extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'HR Dashboard';
        
        // Sample metrics for dashboard
        $data['total_jobs'] = 42;
        $data['active_jobs'] = 18;
        $data['total_applications'] = 156;
        $data['pending_applications'] = 34;
        $data['scheduled_interviews'] = 12;
        $data['new_applicants'] = 8;
        
        // Recent activities
        $data['recent_applications'] = [
            ['name' => 'John Smith', 'position' => 'Software Developer', 'time' => '2 hours ago'],
            ['name' => 'Sarah Johnson', 'position' => 'UI/UX Designer', 'time' => '4 hours ago'],
            ['name' => 'Mike Wilson', 'position' => 'Project Manager', 'time' => '6 hours ago']
        ];
        
        $this->view('hradmin/dashboard', $data);
    }
}
