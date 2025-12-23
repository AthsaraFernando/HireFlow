<?php

class ApplicantDatabase extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Applicants & Applications Management';
        
        // Get the active tab (applicants or applications)
        $data['active_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'applicants';
        
        // Sample applicants data
        $data['applicants'] = [
            [
                'id' => 1,
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1 (555) 123-4567',
                'experience' => '5 years',
                'skills' => ['JavaScript', 'Python', 'React'],
                'location' => 'New York, NY',
                'last_application' => '2024-01-15',
                'status' => 'Active',
                'rating' => 4.5
            ],
            [
                'id' => 2,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'phone' => '+1 (555) 234-5678',
                'experience' => '3 years',
                'skills' => ['UI/UX', 'Figma', 'Adobe Creative'],
                'location' => 'San Francisco, CA',
                'last_application' => '2024-01-14',
                'status' => 'Active',
                'rating' => 4.2
            ],
            [
                'id' => 3,
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@email.com',
                'phone' => '+1 (555) 345-6789',
                'experience' => '7 years',
                'skills' => ['Project Management', 'Agile', 'Scrum'],
                'location' => 'Remote',
                'last_application' => '2024-01-13',
                'status' => 'Active',
                'rating' => 4.8
            ]
        ];

        // Sample applications data
        $data['applications'] = [
            [
                'id' => 1,
                'applicant_name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1 (555) 123-4567',
                'position' => 'Senior Software Developer',
                'status' => 'pending',
                'applied_date' => '2024-01-15',
                'experience' => '5 years',
                'location' => 'New York, NY',
                'source' => 'website',
                'rating' => 4,
                'education' => 'Bachelor\'s in Computer Science - MIT',
                'skills' => ['JavaScript', 'Python', 'React', 'Node.js', 'AWS'],
                'resume_url' => '/uploads/resumes/john_smith_resume.pdf'
            ],
            [
                'id' => 2,
                'applicant_name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'phone' => '+1 (555) 234-5678',
                'position' => 'UI/UX Designer',
                'status' => 'shortlisted',
                'applied_date' => '2024-01-14',
                'experience' => '3 years',
                'location' => 'San Francisco, CA',
                'source' => 'linkedin',
                'rating' => 5,
                'education' => 'Master\'s in Design - Stanford',
                'skills' => ['UI/UX', 'Figma', 'Adobe Creative', 'Sketch'],
                'resume_url' => '/uploads/resumes/sarah_johnson_resume.pdf'
            ],
            [
                'id' => 3,
                'applicant_name' => 'Mike Wilson',
                'email' => 'mike.wilson@email.com',
                'phone' => '+1 (555) 345-6789',
                'position' => 'Marketing Manager',
                'status' => 'interviewed',
                'applied_date' => '2024-01-13',
                'experience' => '7 years',
                'location' => 'Remote',
                'source' => 'indeed',
                'rating' => 4,
                'education' => 'MBA - Wharton',
                'skills' => ['Project Management', 'Agile', 'Scrum', 'Digital Marketing'],
                'resume_url' => '/uploads/resumes/mike_wilson_resume.pdf'
            ]
        ];

        // Statistics
        $data['total_candidates'] = count($data['applicants']);
        $data['active_candidates'] = 423;
        $data['hired_candidates'] = 89;
        $data['top_skills'] = 156;
        
        $data['total_applications'] = count($data['applications']);
        $data['pending_review'] = 34;
        $data['shortlisted'] = 28;
        $data['interviewed'] = 15;
        
        $this->view('hradmin/applicant-database', $data);
    }

    public function viewApplication($id = null)
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $data['page_title'] = 'Application Details';
        $data['application_id'] = $id;
        
        // Sample application data
        $data['application'] = [
            'id' => $id,
            'applicant_name' => 'John Smith',
            'email' => 'john.smith@email.com',
            'phone' => '+1 (555) 123-4567',
            'position' => 'Senior Software Developer',
            'status' => 'Under Review',
            'applied_date' => '2024-01-15',
            'experience' => '5 years',
            'location' => 'New York, NY',
            'education' => 'Bachelor\'s in Computer Science - MIT',
            'skills' => ['JavaScript', 'Python', 'React', 'Node.js', 'AWS'],
            'cover_letter' => 'I am excited to apply for the Senior Software Developer position...',
            'resume_url' => '/uploads/resumes/john_smith_resume.pdf'
        ];
        
        $this->view('hradmin/view-application', $data);
    }
}
