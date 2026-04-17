<?php

class CreateJob extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        // Prevent caching of this page
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Create New Job';
        
        // Fetch departments (use model abstraction, not raw SQL)
        $departmentModel = new Department();
        $data['departments'] = $departmentModel->findAll();

        // Fetch active job categories/roles for title dropdown
        $jobCategoryModel = new JobCategory();
        $data['job_categories'] = $jobCategoryModel->query(
            "SELECT id, name FROM job_categories WHERE status = 'active' ORDER BY name ASC"
        );
        
        // Fetch recruitment managers (role_id = 3)
        $userModel = new User();
        $data['hiring_managers'] = $userModel->query(
            "SELECT id, full_name FROM users 
             WHERE role_id = 3 AND status = 'active' 
             ORDER BY full_name ASC"
        );
        
        // Handle form submission
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

                // Ensure selected title exists in active categories
                $selectedTitle = trim($_POST['job_title'] ?? '');
                $validCategory = $jobCategoryModel->query(
                    "SELECT id FROM job_categories WHERE name = ? AND status = 'active' LIMIT 1",
                    [$selectedTitle]
                );

                if (empty($validCategory)) {
                    $data['errors'][] = 'Please select a valid job title from categories.';
                }

                $applicationDeadline = trim($_POST['application_deadline'] ?? '');
                if ($applicationDeadline !== '') {
                    $deadlineDate = DateTime::createFromFormat('Y-m-d', $applicationDeadline);
                    $isValidDate = $deadlineDate && $deadlineDate->format('Y-m-d') === $applicationDeadline;

                    if (!$isValidDate) {
                        $data['errors'][] = 'Application deadline must be a valid date.';
                    } else {
                        $today = new DateTime('today');
                        if ($deadlineDate < $today) {
                            $data['errors'][] = 'Application deadline cannot be a past date.';
                        }
                    }
                }
            }

            if (empty($data['errors'])) {

                $jobPost = new JobPost();
                
                // Hiring manager override (new feature, keep it)
                $hr_id = !empty($_POST['hiring_manager']) 
                    ? $_POST['hiring_manager'] 
                    : Auth::user_id();

                $jobData = [
                    'title' => $_POST['job_title'] ?? '',
                    'department_id' => $_POST['department_id'] ?? null,
                    'description' => $_POST['summary'] ?? '',
                    'requirements' => $_POST['requirements'] ?? '',
                    'benefits' => $_POST['benefits'] ?? '',
                    'responsibilities' => $_POST['responsibilities'] ?? '',
                    'salary_range' => $_POST['salary_range'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'employment_type' => $_POST['employment_type'] ?? '',
                    'experience_level' => $_POST['experience_level'] ?? '',
                    'status' => $_POST['status'] ?? 'Draft',
                    'posted_by' => Auth::user_id(),
                    'hr_id' => $hr_id,
                    'deadline' => !empty($_POST['application_deadline']) 
                        ? $_POST['application_deadline'] 
                        : null
                ];
                
                // Debug logging (keep for now, remove later)
                error_log("Job Post Data: " . print_r($jobData, true));
                
                $insertId = $jobPost->insert($jobData);
                
                if ($insertId) {
                    AccessLog::log(
                        'job_post_created',
                        'Created job post ID ' . (int)$insertId . ': ' . ($jobData['title'] ?? 'Untitled')
                    );
                    $_SESSION['success_message'] = 'Job posted successfully!';
                    redirect('hradmin/job-posts');
                } else {
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
                $data['form_data'] = $_POST;
            }
        }
        
        $this->view('hradmin/create-job', $data);
    }
}