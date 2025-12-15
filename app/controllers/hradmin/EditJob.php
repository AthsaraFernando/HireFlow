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
                // Update job in database
                
                // Get department name from department_id
                $departmentModel = new Department();
                $department = $departmentModel->first(['id' => $_POST['department']]);
                $department_name = $department ? $department['name'] : '';
                
                $updateData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department_id' => $_POST['department'] ?? null,
                    'department' => $department_name,
                    'description' => $_POST['description'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'deadline' => !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null
                ];
                
                // Update hr_id if hiring_manager is provided
                if (!empty($_POST['hiring_manager'])) {
                    $updateData['hr_id'] = $_POST['hiring_manager'];
                }
                
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
