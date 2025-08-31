<?php

class CreateJob extends Controller
{
    public function index()
    {
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
            $required_fields = ['job_title', 'department', 'location', 'job_type', 'description'];
            
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $data['errors'][] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                }
            }
            
            if (empty($data['errors'])) {
                // In real implementation, save to database
                $data['success'] = 'Job posted successfully!';
                // Redirect would happen here
            }
            
            // Keep form data for display
            $data['form_data'] = $_POST;
        }
        
        $this->view('hradmin/create-job', $data);
    }
}
