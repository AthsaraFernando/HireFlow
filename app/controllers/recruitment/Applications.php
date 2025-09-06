<?php

class Applications extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Review Applications';
        
        // Get job filter from URL
        $data['selected_job'] = $_GET['job'] ?? 'all';
        
        // Sample applications data
        $data['applications'] = [
            [
                'id' => 1,
                'candidate_name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1 555-0123',
                'job_title' => 'Senior Software Developer',
                'job_id' => 1,
                'experience_years' => 8,
                'current_company' => 'Tech Corp',
                'location' => 'San Francisco, CA',
                'application_date' => '2025-08-25',
                'status' => 'pending',
                'match_score' => 92,
                'resume_url' => '/resumes/john_smith.pdf',
                'cover_letter' => 'I am excited to apply for this position...',
                'skills' => ['JavaScript', 'React', 'Node.js', 'Python'],
                'education' => 'MS Computer Science - Stanford University'
            ],
            [
                'id' => 2,
                'candidate_name' => 'Sarah Johnson',
                'email' => 'sarah.j@email.com',
                'phone' => '+1 555-0456',
                'job_title' => 'Senior Software Developer',
                'job_id' => 1,
                'experience_years' => 6,
                'current_company' => 'StartupXYZ',
                'location' => 'New York, NY',
                'application_date' => '2025-08-24',
                'status' => 'under_review',
                'match_score' => 88,
                'resume_url' => '/resumes/sarah_johnson.pdf',
                'cover_letter' => 'With 6 years of experience in full-stack development...',
                'skills' => ['JavaScript', 'Vue.js', 'PHP', 'MySQL'],
                'education' => 'BS Computer Science - MIT'
            ],
            [
                'id' => 3,
                'candidate_name' => 'Mike Wilson',
                'email' => 'mike.wilson@email.com',
                'phone' => '+1 555-0789',
                'job_title' => 'Data Analyst',
                'job_id' => 2,
                'experience_years' => 4,
                'current_company' => 'Analytics Inc',
                'location' => 'Chicago, IL',
                'application_date' => '2025-08-23',
                'status' => 'shortlisted',
                'match_score' => 85,
                'resume_url' => '/resumes/mike_wilson.pdf',
                'cover_letter' => 'As a data professional with extensive experience...',
                'skills' => ['Python', 'SQL', 'Tableau', 'R'],
                'education' => 'MS Data Science - University of Chicago'
            ],
            [
                'id' => 4,
                'candidate_name' => 'Emily Davis',
                'email' => 'emily.davis@email.com',
                'phone' => '+1 555-0321',
                'job_title' => 'UX Designer',
                'job_id' => 3,
                'experience_years' => 5,
                'current_company' => 'Design Studio',
                'location' => 'Los Angeles, CA',
                'application_date' => '2025-08-22',
                'status' => 'rejected',
                'match_score' => 78,
                'resume_url' => '/resumes/emily_davis.pdf',
                'cover_letter' => 'I am passionate about creating user-centered designs...',
                'skills' => ['Figma', 'Sketch', 'Adobe XD', 'Prototyping'],
                'education' => 'BFA Graphic Design - Art Center'
            ]
        ];
        
        // Job options for filtering
        $data['jobs'] = [
            ['id' => 'all', 'title' => 'All Jobs'],
            ['id' => 1, 'title' => 'Senior Software Developer'],
            ['id' => 2, 'title' => 'Data Analyst'],
            ['id' => 3, 'title' => 'UX Designer'],
            ['id' => 4, 'title' => 'Marketing Manager']
        ];
        
        // Filter applications by selected job
        if($data['selected_job'] !== 'all') {
            $data['applications'] = array_filter($data['applications'], function($app) use ($data) {
                return $app['job_id'] == $data['selected_job'];
            });
        }
        
        // Status options
        $data['statuses'] = ['All', 'Pending', 'Under Review', 'Shortlisted', 'Rejected'];

        $this->view('recruitment/applications', $data);
    }
    
    public function viewApplication($id = null)
    {
        if (!$id) {
            redirect('recruitment/applications');
            return;
        }
        
        // Individual application view would go here
        $data = [];
        $data['page_title'] = 'Application Details';
        // Add application details logic here
        
        $this->view('recruitment/application-details', $data);
    }
}
