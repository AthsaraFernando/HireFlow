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
        $data['page_title'] = 'Applicant Database';
        
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
        
        $this->view('hradmin/applicant-database', $data);
    }
}
