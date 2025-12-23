<?php

class EditJob extends Controller
{
    public function index($id = null)
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        if (!$id) {
            // Redirect to job posts if no ID provided
            redirect('hradmin/job-posts');
            exit;
        }
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Edit Job';
        $data['job_id'] = $id;
        
        // Fetch job from database
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $id], []);
        
        if (!$job) {
            $_SESSION['error_message'] = 'Job post not found.';
            redirect('hradmin/job-posts');
            exit;
        }
        
        $data['job'] = $job;
        
        // Fetch departments from database
        $departmentModel = new Department();
        $data['departments'] = $departmentModel->findAll();
        
        // Sample data for dropdowns (commented out)
        // $data['departments'] = [
        //     'Engineering',
        //     'Marketing', 
        //     'Sales',
        //     'HR',
        //     'Finance',
        //     'Operations'
        // ];
        
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
            $required_fields = ['job_title', 'department_id', 'location', 'employment_type', 'summary'];
            
            $field_labels = [
                'job_title' => 'Job title',
                'department_id' => 'Department',
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
                // Update job in database
                $updateData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department_id' => $_POST['department_id'] ?? '',
                    'description' => $_POST['summary'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'responsibilities' => $_POST['responsibilities'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'experience_level' => $_POST['experience_level'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'deadline' => !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null
                ];
                
                if ($jobPost->update($id, $updateData)) {
                    $_SESSION['success_message'] = 'Job updated successfully!';
                    redirect('hradmin/view-job/' . $id);
                } else {
                    $data['errors'][] = 'Failed to update job post. Please try again.';
                }
            }
            
            // Keep form data for display on error
            if (!empty($data['errors'])) {
                $data['form_data'] = $_POST;
            }
        }
        
        $this->view('hradmin/edit-job', $data);
    }
}
