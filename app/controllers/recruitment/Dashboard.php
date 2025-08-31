<?php

class Dashboard extends Controller
{
    public function index()
    {
        // TODO: Add authentication check when role-based login is implemented
        // if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Recruitment Manager') {
        //     redirect('signin');
        //     return;
        // }

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Recruitment Dashboard';
        
        // Dashboard metrics (sample data - replace with database queries)
        $data['metrics'] = [
            'assigned_jobs' => 8,
            'pending_applications' => 45,
            'scheduled_interviews' => 12,
            'candidates_evaluated' => 32,
            'pending_feedback' => 6,
            'shortlisted_candidates' => 18
        ];
        
        // Recent activities
        $data['recent_activities'] = [
            [
                'type' => 'application_review',
                'description' => 'New application received for Senior Developer position',
                'time' => '2 hours ago',
                'priority' => 'high'
            ],
            [
                'type' => 'interview_scheduled',
                'description' => 'Interview scheduled with Sarah Johnson',
                'time' => '4 hours ago',
                'priority' => 'medium'
            ],
            [
                'type' => 'candidate_shortlisted',
                'description' => 'Mike Wilson shortlisted for Data Analyst role',
                'time' => '1 day ago',
                'priority' => 'low'
            ]
        ];
        
        // Assigned jobs summary
        $data['assigned_jobs'] = [
            [
                'id' => 1,
                'title' => 'Senior Software Developer',
                'department' => 'Engineering',
                'applications_count' => 23,
                'pending_reviews' => 8,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'title' => 'Data Analyst',
                'department' => 'Analytics',
                'applications_count' => 15,
                'pending_reviews' => 5,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'title' => 'UX Designer',
                'department' => 'Design',
                'applications_count' => 12,
                'pending_reviews' => 3,
                'status' => 'active'
            ]
        ];
        
        // Upcoming interviews
        $data['upcoming_interviews'] = [
            [
                'candidate_name' => 'Alice Chen',
                'position' => 'Senior Software Developer',
                'scheduled_time' => '2025-09-01 10:00',
                'type' => 'Technical Interview',
                'status' => 'confirmed'
            ],
            [
                'candidate_name' => 'Robert Kim',
                'position' => 'Data Analyst',
                'scheduled_time' => '2025-09-01 14:30',
                'type' => 'HR Interview',
                'status' => 'pending'
            ],
            [
                'candidate_name' => 'Emily Davis',
                'position' => 'UX Designer',
                'scheduled_time' => '2025-09-02 09:00',
                'type' => 'Portfolio Review',
                'status' => 'confirmed'
            ]
        ];

        $this->view('recruitment/dashboard', $data);
    }
}
