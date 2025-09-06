<?php

class Reports extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        

        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'HR Analytics & Reports';
        
        // Sample analytics data
        $data['hiring_metrics'] = [
            'total_positions' => 42,
            'filled_positions' => 28,
            'open_positions' => 14,
            'average_time_to_hire' => 23,
            'total_applications' => 312,
            'interview_completion_rate' => 78,
            'offer_acceptance_rate' => 85,
            'employee_retention_rate' => 92
        ];
        
        // Department wise data
        $data['department_stats'] = [
            ['name' => 'Engineering', 'open_positions' => 8, 'applications' => 156],
            ['name' => 'Design', 'open_positions' => 3, 'applications' => 67],
            ['name' => 'Marketing', 'open_positions' => 2, 'applications' => 45],
            ['name' => 'Sales', 'open_positions' => 1, 'applications' => 44]
        ];
        
        $this->view('hradmin/reports', $data);
    }
}
