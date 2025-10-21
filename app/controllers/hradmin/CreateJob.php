<?php

class CreateJob extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Create New Job';
        
        // Sample data for dropdowns
        $data['departments'] = [
            'Engineering',
            'Marketing', 
            'Sales',
            'HR',
            'Finance',
            'Operations'
        ];
        
        $data['locations'] = [
            'New York, NY',
            'San Francisco, CA',
            'Los Angeles, CA',
            'Chicago, IL',
            'Remote',
            'Hybrid'
        ];
        
        $data['job_types'] = [
            'Full-time',
            'Part-time',
            'Contract',
            'Internship'
        ];
        
        $data['experience_levels'] = [
            'Entry Level',
            'Mid Level',
            'Senior Level',
            'Executive Level'
        ];
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $required_fields = ['job_title', 'department', 'location', 'employment_type', 'summary'];
            
            $field_labels = [
                'job_title' => 'Job title',
                'department' => 'Department',
                'location' => 'Location',
                'employment_type' => 'Employment type',
                'summary' => 'Job summary'
            ];
            
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $label = $field_labels[$field] ?? ucfirst(str_replace('_', ' ', $field));
                    $data['errors'][] = $label . ' is required.';
                }
            }
            
            if (empty($data['errors'])) {
                // Save to database
                $jobPost = new JobPost();
                
                $jobData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department' => $_POST['department'] ?? '',
                    'description' => $_POST['summary'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'responsibilities' => $_POST['responsibilities'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'experience_level' => $_POST['experience_level'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'hr_id' => Auth::user_id(),
                    'deadline' => !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null
                ];
                
                // Use model insert directly (skip validate since we already checked required fields)
                $insertId = $jobPost->insert($jobData);
                
                if ($insertId) {
                    $_SESSION['success_message'] = 'Job posted successfully!';
                    // Redirect to job posts list
                    redirect('hradmin/job-posts');
                } else {
                    $data['errors'][] = 'Failed to save job post. Please try again.';
                    $data['form_data'] = $_POST;
                }
            } else {
                // Keep form data for display
                $data['form_data'] = $_POST;
            }
        }
        
        $this->view('hradmin/create-job', $data);
    }
}
