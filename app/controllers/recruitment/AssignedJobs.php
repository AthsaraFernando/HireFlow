<?php

class AssignedJobs extends Controller
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
        $data['page_title'] = 'My Assigned Jobs';
        
        // Sample assigned jobs data
        $data['assigned_jobs'] = [
            [
                'id' => 1,
                'title' => 'Senior Software Developer',
                'department' => 'Engineering',
                'location' => 'San Francisco, CA',
                'employment_type' => 'Full-time',
                'applications_count' => 23,
                'pending_reviews' => 8,
                'shortlisted_count' => 5,
                'interviewed_count' => 3,
                'status' => 'active',
                'assigned_date' => '2025-08-15',
                'deadline' => '2025-09-15',
                'priority' => 'high'
            ],
            [
                'id' => 2,
                'title' => 'Data Analyst',
                'department' => 'Analytics',
                'location' => 'New York, NY',
                'employment_type' => 'Full-time',
                'applications_count' => 15,
                'pending_reviews' => 5,
                'shortlisted_count' => 3,
                'interviewed_count' => 2,
                'status' => 'active',
                'assigned_date' => '2025-08-20',
                'deadline' => '2025-09-20',
                'priority' => 'medium'
            ],
            [
                'id' => 3,
                'title' => 'UX Designer',
                'department' => 'Design',
                'location' => 'Remote',
                'employment_type' => 'Contract',
                'applications_count' => 12,
                'pending_reviews' => 3,
                'shortlisted_count' => 4,
                'interviewed_count' => 2,
                'status' => 'active',
                'assigned_date' => '2025-08-25',
                'deadline' => '2025-09-25',
                'priority' => 'low'
            ],
            [
                'id' => 4,
                'title' => 'Marketing Manager',
                'department' => 'Marketing',
                'location' => 'Los Angeles, CA',
                'employment_type' => 'Full-time',
                'applications_count' => 8,
                'pending_reviews' => 2,
                'shortlisted_count' => 2,
                'interviewed_count' => 1,
                'status' => 'paused',
                'assigned_date' => '2025-08-10',
                'deadline' => '2025-09-10',
                'priority' => 'medium'
            ]
        ];
        
        // Filter options
        $data['departments'] = ['All', 'Engineering', 'Analytics', 'Design', 'Marketing', 'Sales'];
        $data['statuses'] = ['All', 'Active', 'Paused', 'Completed'];
        $data['priorities'] = ['All', 'High', 'Medium', 'Low'];

        $this->view('recruitment/assigned-jobs', $data);
    }
}
