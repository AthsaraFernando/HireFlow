<?php

class EditJob extends Controller
{
    public function index($id = null)
    {
        Auth::requireRole(2);
        
        if (!$id) {
            redirect('hradmin/job-posts');
            exit;
        }
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Edit Job';
        $data['job_id'] = $id;
        
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $id], []);
        
        if (!$job) {
            $_SESSION['error_message'] = 'Job post not found.';
            redirect('hradmin/job-posts');
            exit;
        }
        
        $data['job'] = $job;
        
        // Use model abstraction
        $departmentModel = new Department();
        $data['departments'] = $departmentModel->findAll();
        
        // Hiring managers (new feature, keep)
        $userModel = new User();
        $data['hiring_managers'] = $userModel->query(
            "SELECT id, full_name FROM users 
             WHERE role_id = 3 AND status = 'active' 
             ORDER BY full_name ASC"
        );
        
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
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

                // Validate hiring manager (don’t trust POST)
                $hr_id = $job['hr_id']; // default = existing

                if (!empty($_POST['hiring_manager'])) {
                    $manager = $userModel->first([
                        'id' => $_POST['hiring_manager'],
                        'role_id' => 3,
                        'status' => 'active'
                    ]);

                    if ($manager) {
                        $hr_id = $manager['id'];
                    }
                }

                $updateData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department_id' => $_POST['department_id'] ?? null,
                    'description' => $_POST['summary'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'responsibilities' => $_POST['responsibilities'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'experience_level' => $_POST['experience_level'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'hr_id' => $hr_id,
                    'deadline' => !empty($_POST['application_deadline']) 
                        ? $_POST['application_deadline'] 
                        : null
                ];
                
                if ($jobPost->update($id, $updateData)) {
                    $_SESSION['success_message'] = 'Job updated successfully!';
                    redirect('hradmin/view-job/' . $id);
                } else {
                    $data['errors'][] = 'Failed to update job post. Please try again.';
                }
            }
            
            if (!empty($data['errors'])) {
                $data['form_data'] = $_POST;
            }
        }
        
        $this->view('hradmin/edit-job', $data);
    }
}