<?php

class Applications extends Controller
{
    public function index()
    {
        $URL['view'] = 'applications';
        
        // Dummy applications data
        $URL['applications'] = [
            [
                'id' => 1,
                'job_title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'applied_date' => '2025-08-20',
                'status' => 'Shortlisted',
                'status_color' => 'success',
                'last_updated' => '2025-08-22',
                'application_id' => 'APP001'
            ],
            [
                'id' => 2,
                'job_title' => 'Frontend Developer',
                'company' => 'Creative Minds Ltd.',
                'applied_date' => '2025-08-18',
                'status' => 'Pending',
                'status_color' => 'warning',
                'last_updated' => '2025-08-18',
                'application_id' => 'APP002'
            ],
            [
                'id' => 3,
                'job_title' => 'Web Developer',
                'company' => 'Digital Dreams',
                'applied_date' => '2025-08-15',
                'status' => 'Rejected',
                'status_color' => 'danger',
                'last_updated' => '2025-08-17',
                'application_id' => 'APP003'
            ],
            [
                'id' => 4,
                'job_title' => 'UI/UX Designer',
                'company' => 'Design Studio Pro',
                'applied_date' => '2025-08-12',
                'status' => 'Interview Scheduled',
                'status_color' => 'info',
                'last_updated' => '2025-08-14',
                'application_id' => 'APP004'
            ],
            [
                'id' => 5,
                'job_title' => 'Data Analyst',
                'company' => 'Analytics Corp',
                'applied_date' => '2025-08-10',
                'status' => 'Under Review',
                'status_color' => 'primary',
                'last_updated' => '2025-08-11',
                'application_id' => 'APP005'
            ]
        ];

        $this->view('applicant', $URL);
    }
    
    public function apply()
    {
        $URL['view'] = 'apply';
        
        // Get job ID from URL (for demo, using job ID 1)
        $job_id = 1;
        
        // Dummy job details for application form
        $URL['job'] = [
            'id' => 1,
            'title' => 'Software Engineer',
            'company' => 'Tech Solutions Inc.',
            'location' => 'Colombo, Sri Lanka',
            'type' => 'Full-time',
            'deadline' => '2025-09-15'
        ];

        $this->view('applicant', $URL);
    }
    
    public function withdraw()
    {
        $URL['view'] = 'withdraw';
        
        // Get application ID from URL (for demo, using application ID 1)
        $application_id = 1;
        
        // Dummy application details
        $URL['application'] = [
            'id' => 1,
            'job_title' => 'Software Engineer',
            'company' => 'Tech Solutions Inc.',
            'applied_date' => '2025-08-20',
            'status' => 'Pending',
            'application_id' => 'APP001'
        ];

        $this->view('applicant', $URL);
    }
}
