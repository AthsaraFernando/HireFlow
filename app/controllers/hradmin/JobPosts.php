<?php

class JobPosts extends Controller
{
    public function index()
    {
        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Job Posts Management';
        
        // Sample job posts data
        $data['job_posts'] = [
            [
                'id' => 1,
                'title' => 'Senior Software Developer',
                'department' => 'Engineering',
                'location' => 'New York, NY',
                'type' => 'Full-time',
                'status' => 'Active',
                'applications' => 23,
                'created_date' => '2024-01-10',
                'deadline' => '2024-02-10'
            ],
            [
                'id' => 2,
                'title' => 'UI/UX Designer',
                'department' => 'Design',
                'location' => 'San Francisco, CA',
                'type' => 'Full-time',
                'status' => 'Active',
                'applications' => 18,
                'created_date' => '2024-01-12',
                'deadline' => '2024-02-12'
            ],
            [
                'id' => 3,
                'title' => 'Project Manager',
                'department' => 'Operations',
                'location' => 'Remote',
                'type' => 'Full-time',
                'status' => 'Draft',
                'applications' => 0,
                'created_date' => '2024-01-15',
                'deadline' => '2024-02-15'
            ]
        ];
        
        $this->view('hradmin/job-posts', $data);
    }
    
    public function create()
    {
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Create Job Post';
        
        if ($_POST) {
            // Handle job creation
            $data['success'] = 'Job post created successfully!';
        }
        
        $this->view('hradmin/create-job', $data);
    }
    
    public function edit($id = null)
    {
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Edit Job Post';
        $data['job_id'] = $id;
        
        if ($_POST) {
            // Handle job update
            $data['success'] = 'Job post updated successfully!';
        }
        
        // Sample job data for editing
        $data['job'] = [
            'id' => $id,
            'title' => 'Senior Software Developer',
            'department' => 'Engineering',
            'location' => 'New York, NY',
            'type' => 'Full-time',
            'description' => 'We are looking for an experienced software developer...',
            'requirements' => 'Bachelor\'s degree in Computer Science...',
            'salary_min' => 80000,
            'salary_max' => 120000
        ];
        
        $this->view('hradmin/edit-job', $data);
    }
    
    public function viewJob($id = null)
    {
        $data = [];
        $data['page_title'] = 'Job Details';
        $data['job_id'] = $id;
        
        // Sample job data
        $data['job'] = [
            'id' => $id,
            'title' => 'Senior Software Developer',
            'department' => 'Engineering',
            'location' => 'New York, NY',
            'type' => 'Full-time',
            'status' => 'Active',
            'description' => 'We are looking for an experienced software developer to join our team...',
            'requirements' => 'Bachelor\'s degree in Computer Science, 5+ years experience...',
            'salary_min' => 80000,
            'salary_max' => 120000,
            'applications' => 23,
            'created_date' => '2024-01-10',
            'deadline' => '2024-02-10'
        ];
        
        $this->view('hradmin/view-job', $data);
    }
}
