<?php

class Applications extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        

        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Applications Management';
        
        // Sample applications data
        $data['applications'] = [
            [
                'id' => 1,
                'applicant_name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'position' => 'Senior Software Developer',
                'status' => 'Under Review',
                'applied_date' => '2024-01-15',
                'experience' => '5 years',
                'location' => 'New York, NY'
            ],
            [
                'id' => 2,
                'applicant_name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'position' => 'UI/UX Designer',
                'status' => 'Shortlisted',
                'applied_date' => '2024-01-14',
                'experience' => '3 years',
                'location' => 'San Francisco, CA'
            ],
            [
                'id' => 3,
                'applicant_name' => 'Mike Wilson',
                'email' => 'mike.wilson@email.com',
                'position' => 'Project Manager',
                'status' => 'Interview Scheduled',
                'applied_date' => '2024-01-13',
                'experience' => '7 years',
                'location' => 'Remote'
            ]
        ];
        
        $this->view('hradmin/applications', $data);
    }
    
    public function viewApplication($id = null)
    {
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
