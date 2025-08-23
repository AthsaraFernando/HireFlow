<?php

class Dashboard extends Controller
{
    public function index()
    {
        $URL['view'] = 'dashboard';
        
        // Dummy data for dashboard overview
        $URL['total_applications'] = 5;
        $URL['shortlisted'] = 2;
        $URL['rejected'] = 1;
        $URL['pending'] = 2;
        $URL['upcoming_interviews'] = 1;
        
        // Recent applications
        $URL['recent_applications'] = [
            [
                'id' => 1,
                'job_title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'applied_date' => '2025-08-20',
                'status' => 'Shortlisted'
            ],
            [
                'id' => 2,
                'job_title' => 'Frontend Developer',
                'company' => 'Creative Minds Ltd.',
                'applied_date' => '2025-08-18',
                'status' => 'Pending'
            ],
            [
                'id' => 3,
                'job_title' => 'Web Developer',
                'company' => 'Digital Dreams',
                'applied_date' => '2025-08-15',
                'status' => 'Rejected'
            ]
        ];
        
        // Upcoming interviews
        $URL['upcoming_interviews_list'] = [
            [
                'id' => 1,
                'job_title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'interview_date' => '2025-08-25',
                'interview_time' => '10:00 AM',
                'interview_type' => 'Virtual'
            ]
        ];

        $this->view('applicant', $URL);
    }
}
