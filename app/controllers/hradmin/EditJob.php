<?php

class EditJob extends Controller
{
    public function index($id = null)
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        if (!$id) {
            // Redirect to job posts if no ID provided
            header('Location: /HireFlow/public/hradmin/job-posts');
            exit;
        }
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Edit Job';
        $data['job_id'] = $id;
        
        // Sample job data - in real implementation this would come from database
        $data['job'] = [
            'id' => $id,
            'title' => 'Senior Software Developer',
            'department' => 'Engineering',
            'location' => 'New York, NY',
            'type' => 'Full-time',
            'status' => 'Active',
            'experience_level' => 'Senior Level',
            'description' => 'We are looking for a Senior Software Developer to join our growing team...',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field...',
            'benefits' => 'Health insurance, 401k, flexible working hours...',
            'salary_min' => 80000,
            'salary_max' => 120000,
            'deadline' => '2024-02-10'
        ];
        
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
        
        $data['status_options'] = [
            'Active',
            'Inactive',
            'Draft'
        ];
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $required_fields = ['job_title', 'department', 'location', 'job_type', 'description'];
            
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $data['errors'][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                }
            }
            
            if (empty($data['errors'])) {
                // In real implementation, update database
                $data['success'] = 'Job updated successfully!';
                // Update the job data with form data
                $data['job'] = array_merge($data['job'], $_POST);
            }
            
            // Keep form data for display
            $data['form_data'] = $_POST;
        }
        
        $this->view('hradmin/edit-job', $data);
    }
}
