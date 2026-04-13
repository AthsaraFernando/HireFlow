<?php

class Reports extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Recruitment Reports';
        
        // Sample analytics data
        $data['analytics'] = [
            'total_applications' => 156,
            'applications_reviewed' => 124,
            'candidates_shortlisted' => 32,
            'interviews_conducted' => 18,
            'candidates_hired' => 5,
            'average_time_to_hire' => 21, // days
            'success_rate' => 78.5 // percentage
        ];
        
        $data['monthly_data'] = [
            ['month' => 'June', 'applications' => 45, 'hires' => 2],
            ['month' => 'July', 'applications' => 67, 'hires' => 3],
            ['month' => 'August', 'applications' => 44, 'hires' => 0]
        ];

        $this->view('recruitment/reports', $data);
    }
}
