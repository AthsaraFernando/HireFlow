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
        
        // Fetch departments from database
        $departmentModel = new Department();
        $data['departments'] = $departmentModel->query("SELECT * FROM departments ORDER BY name ASC");
        
        // Fetch recruitment managers (role_id = 3)
        $userModel = new User();
        $data['hiring_managers'] = $userModel->query("SELECT id, full_name FROM users WHERE role_id = 3 AND status = 'active' ORDER BY full_name ASC");
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            $required_fields = ['job_title', 'department', 'location', 'employment_type', 'description', 'requirements'];
            
            $field_labels = [
                'job_title' => 'Job title',
                'department' => 'Department',
                'location' => 'Location',
                'employment_type' => 'Employment type',
                'description' => 'Description',
                'requirements' => 'Requirements'
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
                
                // Determine hr_id: use hiring_manager if selected, otherwise use current user
                $hr_id = !empty($_POST['hiring_manager']) ? $_POST['hiring_manager'] : Auth::user_id();
                
                // Get department name from department_id
                $departmentModel = new Department();
                $department = $departmentModel->first(['id' => $_POST['department']]);
                $department_name = $department ? $department['name'] : '';
                
                $jobData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department_id' => $_POST['department'] ?? null,
                    'department' => $department_name,
                    'description' => $_POST['description'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'hr_id' => $hr_id,
                    'deadline' => !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null
                ];
                
                // Use model insert directly (skip validate since we already checked required fields)
                $insertId = $jobPost->insert($jobData);
                
                if ($insertId) {
                    $_SESSION['success_message'] = 'Job posted successfully!';
                    // Redirect to job posts list
                    redirect('hradmin/job-posts');
                } else {
                    // Show actual database errors
                    if (!empty($jobPost->errors)) {
                        foreach ($jobPost->errors as $error) {
                            $data['errors'][] = 'Database error: ' . $error;
                        }
                    } else {
                        $data['errors'][] = 'Failed to save job post. Please try again.';
                    }
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
