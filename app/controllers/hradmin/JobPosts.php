<?php

class JobPosts extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Job Posts Management';

        $filters = [
            'q' => trim((string)($_GET['q'] ?? '')),
            'status' => trim((string)($_GET['status'] ?? '')),
            'department' => trim((string)($_GET['department'] ?? '')),
            'type' => trim((string)($_GET['type'] ?? '')),
        ];
        
        // Check for success message from redirect
        if (!empty($_SESSION['success_message'])) {
            $data['success'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }
        
        // Fetch real job posts from database
        $jobPost = new JobPost();
        $jobs = $jobPost->getAllJobs();
        
        // Get job statistics for hero section
        $data['total_jobs'] = $jobPost->getJobCount();
        $data['active_jobs'] = $jobPost->getJobCount('Open');
        $data['draft_jobs'] = $jobPost->getJobCount('Draft');
        
        // Get department model for lookups
        $departmentModel = new Department();
        $departments = $departmentModel->findAll();
        $deptMap = [];
        $departmentOptions = [];
        foreach ($departments as $dept) {
            $deptMap[$dept['id']] = $dept['name'];
            $departmentOptions[] = $dept['name'];
        }
        
        // Format data for the view
        $data['job_posts'] = [];
        $typeOptions = [];
        if ($jobs) {
            foreach ($jobs as $job) {
                // Get department name from map if department_id exists
                $deptName = 'N/A';
                if (!empty($job['department_id']) && isset($deptMap[$job['department_id']])) {
                    $deptName = $deptMap[$job['department_id']];
                } elseif (!empty($job['department'])) {
                    $deptName = $job['department'];
                }
                
                $formattedJob = [
                    'id' => $job['id'],
                    'title' => $job['title'],
                    'department' => $deptName,
                    'location' => $job['location'],
                    'type' => $job['employment_type'],
                    'status' => $job['status'],
                    'applications' => $job['applications_count'] ?? 0,
                    'created_date' => date('Y-m-d', strtotime($job['created_at'])),
                    'deadline' => $job['deadline']
                ];

                if (!empty($formattedJob['type'])) {
                    $typeOptions[] = $formattedJob['type'];
                }

                $searchText = strtolower(implode(' ', [
                    (string)($formattedJob['title'] ?? ''),
                    (string)($formattedJob['department'] ?? ''),
                    (string)($formattedJob['location'] ?? ''),
                    (string)($formattedJob['type'] ?? ''),
                ]));

                if ($filters['q'] !== '' && strpos($searchText, strtolower($filters['q'])) === false) {
                    continue;
                }

                if ($filters['status'] !== '' && strtolower((string)$formattedJob['status']) !== strtolower($filters['status'])) {
                    continue;
                }

                if ($filters['department'] !== '' && strtolower((string)$formattedJob['department']) !== strtolower($filters['department'])) {
                    continue;
                }

                if ($filters['type'] !== '' && strtolower((string)$formattedJob['type']) !== strtolower($filters['type'])) {
                    continue;
                }

                $data['job_posts'][] = $formattedJob;
            }
        }

        $data['filters'] = $filters;
        $data['department_options'] = array_values(array_unique(array_filter($departmentOptions)));
        $data['type_options'] = array_values(array_unique(array_filter($typeOptions)));
        
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
        Auth::requireRole(2);
        
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Edit Job Post';
        $data['job_id'] = $id;
        
        $jobPost = new JobPost();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
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
                $updateData = [
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
                    'deadline' => !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null
                ];
                
                $result = $jobPost->update($id, $updateData);
                
                if ($result !== false) {
                    AccessLog::log(
                        'job_post_updated',
                        'Updated job post ID ' . (int)$id . ': ' . ($updateData['title'] ?? 'Untitled')
                    );
                    $_SESSION['success_message'] = 'Job post updated successfully!';
                    redirect('hradmin/job-posts');
                } else {
                    $data['errors'][] = 'Failed to update job post. Please try again.';
                }
            }
            
            // Keep form data for display
            $data['job'] = $_POST;
        } else {
            // Fetch job data from database
            $job = $jobPost->first(['id' => $id], []);
            
            if (!$job) {
                $_SESSION['error_message'] = 'Job post not found.';
                redirect('hradmin/job-posts');
                return;
            }
            
            $data['job'] = $job;
        }
        
        $this->view('hradmin/edit-job', $data);
    }
    
    public function viewJob($id = null)
    {
        Auth::requireRole(2);
        
        $data = [];
        $data['page_title'] = 'Job Details';
        $data['job_id'] = $id;
        
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $id], []);
        
        if (!$job) {
            $_SESSION['error_message'] = 'Job post not found.';
            redirect('hradmin/job-posts');
            return;
        }
        
        $data['job'] = $job;
        
        $this->view('hradmin/view-job', $data);
    }
    
    public function delete($id = null)
    {
        Auth::requireRole(2);
        
        if (!$id) {
            $_SESSION['error_message'] = 'Invalid job post ID.';
            redirect('hradmin/job-posts');
            return;
        }
        
        $jobPost = new JobPost();
        
        // Check if job exists
        $job = $jobPost->first(['id' => $id], []);
        if (!$job) {
            $_SESSION['error_message'] = 'Job post not found.';
            redirect('hradmin/job-posts');
            return;
        }
        
        // Delete the job post
        $result = $jobPost->delete($id);
        
        if ($result !== false) {
            AccessLog::log(
                'job_post_deleted',
                'Deleted job post ID ' . (int)$id . ': ' . ($job['title'] ?? 'Untitled')
            );
            $_SESSION['success_message'] = 'Job post deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete job post. Please try again.';
        }
        
        redirect('hradmin/job-posts');
    }
}
