<?php

/**
 * Main Applicant Controller
 * Handles routing for all applicant-related functionalities
 */
class Applicant extends Controller
{
    private function getUserData($user_id)
    {
        $userModel = new User();
        $users = $userModel->where(['id' => $user_id]);
        $current_user = $users[0] ?? null;
        
        return [
            'name' => $current_user['full_name'] ?? 'User',
            'email' => $current_user['email'] ?? ''
        ];
    }

    public function index()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        // Default route redirects to dashboard
        redirect('applicant/dashboard');
    }

    public function dashboard()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        $data = [];
        $user_id = Auth::user_id();
        
        // Get current user data
        $userModel = new User();
        $applicationModel = new Application();
        $interviewModel = new Interview();
        $notificationModel = new Notification();
        
        $current_user = Auth::user();
        
        // Get application statistics
        $app_stats = $applicationModel->getApplicationStats($user_id);
        if (!$app_stats) {
            $app_stats = [
                'total_applications' => 0,
                'pending_applications' => 0,
                'under_review_applications' => 0,
                'shortlisted_applications' => 0,
                'interview_scheduled' => 0,
                'rejected_applications' => 0,
                'offered_applications' => 0
            ];
        }
        
        // Get interview statistics
        $interview_stats = $interviewModel->getInterviewCount($user_id);
        if (!$interview_stats) {
            $interview_stats = [
                'total_interviews' => 0,
                'upcoming_interviews' => 0,
                'completed_interviews' => 0
            ];
        }
        
        // Calculate profile completion percentage
        $profile_completion = $this->calculateProfileCompletion($current_user);
        
        // User data for dashboard
        $data['user'] = [
            'name' => $current_user['full_name'] ?? 'User',
            'email' => $current_user['email'] ?? '',
            'profile_completion' => $profile_completion,
            'applications_count' => (int)($app_stats['total_applications'] ?? 0),
            'interviews_count' => (int)($interview_stats['total_interviews'] ?? 0),
            'pending_count' => (int)($app_stats['pending_applications'] ?? 0),
            'shortlisted_count' => (int)($app_stats['shortlisted_applications'] ?? 0),
            'under_review_count' => (int)($app_stats['under_review_applications'] ?? 0),
            'interview_scheduled_count' => (int)($app_stats['interview_scheduled'] ?? 0)
        ];

        // Get recent applications (last 5)
        $recent_apps = $applicationModel->getUserApplications($user_id);
        $data['recent_applications'] = [];
        if ($recent_apps && is_array($recent_apps)) {
            foreach (array_slice($recent_apps, 0, 5) as $app) {
                $data['recent_applications'][] = [
                    'id' => $app['id'],
                    'job_title' => $app['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company', // Since we don't have company field, using default
                    'status' => strtolower($app['status']),
                    'applied_date' => date('Y-m-d', strtotime($app['applied_at'])),
                    'salary' => $app['salary_range'] ?? 'Not specified'
                ];
            }
        }

        // Get upcoming interviews
        $upcoming_interviews = $interviewModel->getUpcomingInterviews($user_id);
        $data['upcoming_interviews'] = [];
        if ($upcoming_interviews && is_array($upcoming_interviews)) {
            foreach ($upcoming_interviews as $interview) {
                $data['upcoming_interviews'][] = [
                    'id' => $interview['id'],
                    'job_title' => $interview['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'date' => date('Y-m-d', strtotime($interview['scheduled_date'])),
                    'time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'type' => $interview['interview_type'] ?? 'Interview',
                    'interviewer' => $interview['interviewer_name'] ?? 'TBD'
                ];
            }
        }

        // Get unread notifications count
        $data['unread_notifications'] = $notificationModel->getUnreadCount($user_id);

        $this->view('applicant/dashboard', $data);
    }
    
    private function calculateProfileCompletion($user)
    {
        $completion = 0;
        $total_fields = 6;
        
        if (!empty($user['full_name'])) $completion++;
        if (!empty($user['email'])) $completion++;
        if (!empty($user['phone'])) $completion++;
        if (!empty($user['address'])) $completion++;
        if (!empty($user['profile_picture'])) $completion++;
        if (isset($user['created_at'])) $completion++; // Basic setup completion
        
        return round(($completion / $total_fields) * 100);
    }

    public function jobs($action = null, $id = null)
    {
        Auth::requireRole(4);
        
        if ($action === 'details') {
            if (!$id && isset($_GET['id'])) {
                $id = (int)$_GET['id'];
            }
            return $this->jobDetails($id);
        }

        $data = [];
        $jobModel = new JobPost();
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // Get filters from URL parameters
        $filters = [];
        if (isset($_GET['title'])) $filters['title'] = $_GET['title'];
        if (isset($_GET['department'])) $filters['department'] = $_GET['department'];
        if (isset($_GET['location'])) $filters['location'] = $_GET['location'];
        if (isset($_GET['employment_type'])) $filters['employment_type'] = $_GET['employment_type'];
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Jobs per page
        $offset = ($page - 1) * $limit;
        
        // Get jobs based on filters
        if (!empty($filters)) {
            $jobs = $jobModel->searchJobs($filters, $limit, $offset);
            $total_jobs = $jobModel->getJobCount($filters);
        } else {
            $jobs = $jobModel->getActiveJobs($limit, $offset);
            $total_jobs = $jobModel->getJobCount();
        }
        
        // Format jobs data for view
        $data['jobs'] = [];
        if ($jobs && is_array($jobs)) {
            foreach ($jobs as $job) {
                // Check if user has already applied
                $has_applied = $applicationModel->hasAppliedToJob($user_id, $job['id']);
                
                // Check if application form exists for this job
                $applicationFormMeta = $applicationFormModel->getFormByJobPostId($job['id']);
                $form_available = $applicationFormMeta && ($applicationFormMeta['status'] ?? 'inactive') === 'active';
                
                // Parse requirements from text format to array
                $requirements = [];
                if (!empty($job['requirements'])) {
                    $req_lines = explode("\n", $job['requirements']);
                    foreach ($req_lines as $line) {
                        $line = trim($line);
                        if (!empty($line) && $line !== '???') {
                            // Remove bullet points and clean up
                            $line = preg_replace('/^[•???*-]\s*/', '', $line);
                            if (!empty($line)) {
                                $requirements[] = $line;
                            }
                        }
                    }
                }

                $data['jobs'][] = [
                    'id' => $job['id'],
                    'title' => $job['title'],
                    'company' => 'HireFlow Company', // Default company name
                    'location' => $job['location'] ?? 'Not specified',
                    'type' => $job['employment_type'] ?? 'Full-time',
                    'remote' => false, // We don't have remote field in DB
                    'salary' => $job['salary_range'] ?? 'Competitive',
                    'posted_date' => date('Y-m-d', strtotime($job['created_at'])),
                    'deadline' => $job['deadline'] ? date('Y-m-d', strtotime($job['deadline'])) : 'Open',
                    'description' => substr($job['description'], 0, 150) . '...', // Truncated for listing
                    'department' => $job['department'] ?? 'General',
                    'requirements' => $requirements, // Now properly formatted as array
                    'has_applied' => $has_applied,
                    'form_available' => $form_available
                ];
            }
        }
        
        // Pagination data
        $data['pagination'] = [
            'current_page' => $page,
            'total_jobs' => $total_jobs,
            'jobs_per_page' => $limit,
            'total_pages' => ceil($total_jobs / $limit),
            'has_previous' => $page > 1,
            'has_next' => $page < ceil($total_jobs / $limit)
        ];
        
        // Filter options for dropdown
        $data['filters'] = $filters;
        $data['employment_types'] = ['Full-time', 'Part-time', 'Contract', 'Internship'];
        
        // Get unique departments from database
        $all_jobs = $jobModel->findAll();
        $departments = [];
        if ($all_jobs && is_array($all_jobs)) {
            foreach ($all_jobs as $job) {
                if (!empty($job['department']) && !in_array($job['department'], $departments)) {
                    $departments[] = $job['department'];
                }
            }
        }
        $data['departments'] = $departments;

        $this->view('applicant/jobs', $data);
    }

    public function jobDetails($id = null)
    {
        Auth::requireRole(4);
        
        if (!$id) {
            redirect('applicant/jobs');
            return;
        }
        
        $data = [];
        $jobModel = new JobPost();
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();
        
        // Get job details
        $job = $jobModel->getJobById($id);
        
        if (!$job) {
            redirect('applicant/jobs');
            return;
        }
        
        // Check if user has already applied
        $has_applied = $applicationModel->hasAppliedToJob($user_id, $job['id']);
        $user_application = null;
        
        if ($has_applied) {
            $user_apps = $applicationModel->getUserApplications($user_id);
            if ($user_apps && is_array($user_apps)) {
                foreach ($user_apps as $app) {
                    if ($app['job_id'] == $job['id']) {
                        $user_application = $app;
                        break;
                    }
                }
            }
        }
        
        // Check if application form exists for this job
        $applicationFormMeta = $applicationFormModel->getFormByJobPostId($job['id']);
        $form_available = $applicationFormMeta && ($applicationFormMeta['status'] ?? 'inactive') === 'active';
        
        // Parse requirements if they're stored as text
        $requirements = [];
        if (!empty($job['requirements'])) {
            $requirements = array_filter(array_map('trim', explode("\n", $job['requirements'])));
        }
        
        // Format job data for view
        $data['job'] = [
            'id' => $job['id'],
            'title' => $job['title'],
            'company' => 'HireFlow Company',
            'location' => $job['location'] ?? 'Not specified',
            'type' => $job['employment_type'] ?? 'Full-time',
            'experience_level' => $job['experience_level'] ?? 'Not specified',
            'remote' => false, // We don't have this field in DB
            'salary' => $job['salary_range'] ?? 'Competitive salary',
            'posted_date' => date('Y-m-d', strtotime($job['created_at'])),
            'deadline' => $job['deadline'] ? date('Y-m-d', strtotime($job['deadline'])) : null,
            'description' => $job['description'],
            'requirements' => $requirements,
            'department' => $job['department'] ?? 'General',
            'has_applied' => $has_applied,
            'application_status' => $user_application['status'] ?? null,
            'applied_at' => $user_application['applied_at'] ?? null,
            'form_available' => $form_available,
            'benefits' => [
                'Competitive salary package',
                'Health and medical benefits',
                'Professional development opportunities',
                'Flexible working arrangements',
                'Performance-based incentives'
            ]
        ];

        $this->view('applicant/job-details', $data);
    }

    public function applications($action = null)
    {
        Auth::requireRole(4);
        
        if ($action === 'apply') {
            return $this->applyJob();
        }

        $data = [];
        $applicationModel = new Application();
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // Get user's applications
        $applications = $applicationModel->getUserApplications($user_id);
        
        $data['applications'] = [];
        if ($applications && is_array($applications)) {
            foreach ($applications as $app) {
                $data['applications'][] = [
                    'id' => $app['id'],
                    'job_title' => $app['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'status' => strtolower($app['status']),
                    'status_display' => $app['status'],
                    'applied_date' => date('Y-m-d', strtotime($app['applied_at'])),
                    'last_update' => date('Y-m-d', strtotime($app['applied_at'])), // Using applied_at as we don't have updated_at
                    'salary' => $app['salary_range'] ?? 'Not specified',
                    'location' => $app['location'] ?? 'Not specified',
                    'job_id' => $app['job_id'],
                    'department' => $app['department'] ?? 'General',
                    'employment_type' => $app['employment_type'] ?? 'Full-time'
                ];
            }
        }
        
        // Get statistics for display
        $stats = $applicationModel->getApplicationStats($user_id);
        if (!$stats) {
            $stats = [
                'total_applications' => 0,
                'pending_applications' => 0,
                'under_review_applications' => 0,
                'shortlisted_applications' => 0,
                'interview_scheduled' => 0,
                'rejected_applications' => 0,
                'offered_applications' => 0
            ];
        }
        
        $data['stats'] = [
            'total' => (int)$stats['total_applications'],
            'pending' => (int)$stats['pending_applications'],
            'under_review' => (int)$stats['under_review_applications'],
            'shortlisted' => (int)$stats['shortlisted_applications'],
            'interview_scheduled' => (int)$stats['interview_scheduled'],
            'rejected' => (int)$stats['rejected_applications'],
            'offered' => (int)$stats['offered_applications']
        ];

        $this->view('applicant/applications', $data);
    }

    public function applyJob()
    {
        Auth::requireRole(4);
        
        $data = [];
        $job_id = $_GET['job_id'] ?? $_POST['job_id'] ?? null;
        
        if (!$job_id) {
            redirect('applicant/jobs');
            return;
        }
        
        $jobModel = new JobPost();
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();
        
        // Process application submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->processJobApplication();
        }
        
        // Get job details for the application form
        $job = $jobModel->getJobById($job_id);
        
        if (!$job) {
            redirect('applicant/jobs');
            return;
        }
        
        // Check if already applied
        if ($applicationModel->hasAppliedToJob($user_id, $job_id)) {
            $_SESSION['error'] = "You have already applied to this position.";
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        // Get active dynamic form configured by recruitment manager
        $formMeta = $applicationFormModel->getFormByJobPostId($job_id);
        if (!$formMeta || ($formMeta['status'] ?? 'inactive') !== 'active') {
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        $form = $applicationFormModel->getFormWithFields($formMeta['id']);
        if (!$form || empty($form['fields'])) {
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        // Group fields by category in a stable display order
        $grouped_fields = [];
        foreach ($form['fields'] as $field) {
            $category = $field['field_category'];
            if (!isset($grouped_fields[$category])) {
                $grouped_fields[$category] = [];
            }
            $grouped_fields[$category][] = $field;
        }

        $category_order = [
            'personal_info',
            'education',
            'work_experience',
            'skills',
            'documents',
            'availability',
            'declarations',
            'additional_info'
        ];

        $ordered_fields = [];
        foreach ($category_order as $category) {
            if (isset($grouped_fields[$category])) {
                $ordered_fields[$category] = $grouped_fields[$category];
            }
        }
        foreach ($grouped_fields as $category => $fields) {
            if (!isset($ordered_fields[$category])) {
                $ordered_fields[$category] = $fields;
            }
        }

        $current_user = Auth::user();
        $prefill = [
            'first_name' => '',
            'last_name' => '',
            'email' => $current_user['email'] ?? '',
            'phone' => $current_user['phone'] ?? '',
            'city' => '',
            'province' => '',
            'nationality' => '',
            'date_of_birth' => '',
            'gender' => '',
            'linkedin_url' => '',
            'portfolio_url' => '',
        ];

        if (!empty($current_user['full_name'])) {
            $name_parts = preg_split('/\s+/', trim($current_user['full_name']));
            $prefill['first_name'] = $name_parts[0] ?? '';
            $prefill['last_name'] = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : '';
        }
        
        $data['job'] = [
            'id' => $job['id'],
            'title' => $job['title'],
            'company' => 'HireFlow Company',
            'location' => $job['location'] ?? 'Not specified',
            'salary' => $job['salary_range'] ?? 'Competitive salary',
            'department' => $job['department'] ?? 'General',
            'description' => $job['description'] ?? '',
            'employment_type' => $job['employment_type'] ?? 'Not specified',
            'deadline' => $job['deadline'] ?? null
        ];

        $data['user'] = $this->getUserData($user_id);
        $data['form'] = $form;
        $data['grouped_fields'] = $ordered_fields;
        $data['category_labels'] = $this->getApplicationFormCategoryLabels();
        $data['prefill'] = $prefill;

        $this->view('applicant/apply', $data);
    }
    
    public function processJobApplication()
    {
        Auth::requireRole(4);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('applicant/jobs');
            return;
        }
        
        $applicationModel = new Application();
        $notificationModel = new Notification();
        $jobModel = new JobPost();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();

        $job_id = isset($_POST['job_id']) ? (int)$_POST['job_id'] : 0;
        if ($job_id <= 0) {
            $_SESSION['error'] = "Invalid job selection.";
            redirect('applicant/jobs');
            return;
        }

        $job = $jobModel->getJobById($job_id);
        if (!$job) {
            $_SESSION['error'] = "Job is not available.";
            redirect('applicant/jobs');
            return;
        }

        if ($applicationModel->hasAppliedToJob($user_id, $job_id)) {
            $_SESSION['error'] = "You have already applied to this position.";
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        $formMeta = $applicationFormModel->getFormByJobPostId($job_id);
        if (!$formMeta || ($formMeta['status'] ?? 'inactive') !== 'active') {
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        $form = $applicationFormModel->getFormWithFields($formMeta['id']);
        if (!$form || empty($form['fields'])) {
            redirect('applicant/jobs/details/' . $job_id);
            return;
        }

        $submitted_fields = $_POST['form_fields'] ?? [];
        $responses = [];
        $resume_path = '';
        $validation_errors = [];

        foreach ($form['fields'] as $field) {
            if (!(int)$field['is_enabled']) {
                continue;
            }

            $field_name = $field['field_name'];
            $field_label = $field['field_label'];
            $field_type = $field['field_type'];
            $is_required = (int)$field['is_required'] === 1;

            if ($field_type === 'file') {
                $file = $this->extractFormFile($_FILES['form_files'] ?? null, $field_name);

                if ($file && $file['error'] === UPLOAD_ERR_OK) {
                    $is_resume_field = stripos($field_name, 'resume') !== false;
                    $upload_result = $this->handleDynamicFormFileUpload($file, $user_id, $is_resume_field);

                    if (!$upload_result['success']) {
                        $validation_errors[] = $upload_result['error'];
                        continue;
                    }

                    $responses[$field_name] = $upload_result['path'];
                    if ($is_resume_field) {
                        $resume_path = $upload_result['path'];
                    }
                } elseif ($is_required) {
                    $validation_errors[] = $field_label . " is required.";
                }

                continue;
            }

            $value = $submitted_fields[$field_name] ?? null;
            if (is_string($value)) {
                $value = trim($value);
            }

            if ($field_type === 'checkbox') {
                $checked = !empty($value) ? 'Yes' : 'No';
                if ($is_required && $checked !== 'Yes') {
                    $validation_errors[] = $field_label . " is required.";
                }
                $responses[$field_name] = $checked;
                continue;
            }

            if ($is_required && ($value === null || $value === '')) {
                $validation_errors[] = $field_label . " is required.";
                continue;
            }

            $responses[$field_name] = $value;
        }

        if (empty($resume_path)) {
            $validation_errors[] = "Resume upload is required.";
        }

        if (!empty($validation_errors)) {
            $_SESSION['error'] = implode(' ', array_unique($validation_errors));
            redirect('applicant/applications/apply?job_id=' . $job_id);
            return;
        }

        $cover_letter = $this->buildDynamicApplicationSummary($form, $responses);

        $data = [
            'job_id' => $job_id,
            'applicant_id' => $user_id,
            'cover_letter' => $cover_letter,
            'resume_path' => $resume_path,
            'status' => 'Applied'
        ];
        
        // Submit application
        if ($applicationModel->submitApplication($data)) {
            // Create notification
            $notificationModel->insert([
                'user_id' => $user_id,
                'title' => 'Application Submitted',
                'message' => 'Your job application has been submitted successfully.',
                'type' => 'success'
            ]);
            
            $_SESSION['success'] = "Your application has been submitted successfully!";
            redirect('applicant/applications');
        } else {
            $_SESSION['error'] = "Failed to submit application. Please try again.";
            redirect('applicant/applications/apply?job_id=' . $job_id);
        }
    }

    private function getApplicationFormCategoryLabels()
    {
        return [
            'personal_info' => 'Personal Information',
            'education' => 'Education Details',
            'work_experience' => 'Work Experience',
            'skills' => 'Skills & Competencies',
            'documents' => 'Resume & Documents',
            'availability' => 'Availability & Expectations',
            'declarations' => 'Declarations & Consent',
            'additional_info' => 'Additional Information'
        ];
    }

    private function extractFormFile($formFiles, $fieldName)
    {
        if (!$formFiles || !isset($formFiles['name'][$fieldName])) {
            return null;
        }

        return [
            'name' => $formFiles['name'][$fieldName],
            'type' => $formFiles['type'][$fieldName],
            'tmp_name' => $formFiles['tmp_name'][$fieldName],
            'error' => $formFiles['error'][$fieldName],
            'size' => $formFiles['size'][$fieldName],
        ];
    }

    private function handleDynamicFormFileUpload($file, $user_id, $strict_pdf = false)
    {
        $upload_dir = $this->publicPath('uploads/resumes');

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $max_size = 5242880; // 5MB

        if ($strict_pdf) {
            if ($file_extension !== 'pdf') {
                return ['success' => false, 'error' => 'Resume must be a PDF file.'];
            }
        } else {
            $allowed_extensions = ['pdf', 'doc', 'docx'];
            if (!in_array($file_extension, $allowed_extensions, true)) {
                return ['success' => false, 'error' => 'Uploaded file type is not allowed.'];
            }
        }

        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'File size must be less than 5MB.'];
        }

        $filename = 'resume_' . $user_id . '_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $file_extension;
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => false, 'error' => 'Failed to upload file.'];
        }

        return ['success' => true, 'path' => '/uploads/resumes/' . $filename];
    }

    private function buildDynamicApplicationSummary($form, $responses)
    {
        $lines = [];
        $lines[] = "Submitted via dynamic application form: " . ($form['form_title'] ?? 'Application Form');

        foreach ($form['fields'] as $field) {
            $name = $field['field_name'];
            if (!isset($responses[$name])) {
                continue;
            }

            if ($field['field_type'] === 'file') {
                continue;
            }

            $value = is_scalar($responses[$name]) ? (string)$responses[$name] : '';
            if ($value === '') {
                continue;
            }

            $lines[] = $field['field_label'] . ': ' . $value;
        }

        $summary = implode("\n", $lines);
        return mb_substr($summary, 0, 60000);
    }
    
    private function handleResumeUpload($file, $user_id)
    {
        $upload_dir = $this->publicPath('uploads/resumes');
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Validate file type - Only PDF allowed
        $allowed_types = ['application/pdf'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($file['type'], $allowed_types) || $file_extension !== 'pdf') {
            return ['success' => false, 'error' => 'Only PDF files are allowed.'];
        }
        
        // Validate file size (5MB max)
        if ($file['size'] > 5242880) {
            return ['success' => false, 'error' => 'File size must be less than 5MB.'];
        }
        
        // Generate unique filename
        $filename = 'resume_' . $user_id . '_' . time() . '.pdf';
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => true, 'path' => '/uploads/resumes/' . $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload file.'];
        }
    }

    private function publicPath($relative = '')
    {
        $project_root = dirname(__DIR__, 3);
        $public_root = rtrim($project_root . '/public', '/');

        if ($relative === '' || $relative === null) {
            return $public_root;
        }

        return $public_root . '/' . ltrim($relative, '/');
    }

    private function ensureResumeFileAccessible($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);

        if (file_exists($expected)) {
            return;
        }

        // Legacy fallback for previously uploaded files written to nested path.
        $legacy = $this->publicPath('HireFlow/public/' . $relative);
        if (!file_exists($legacy)) {
            return;
        }

        $target_dir = dirname($expected);
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        @copy($legacy, $expected);
    }

    private function deleteResumeFile($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);
        $legacy = $this->publicPath('HireFlow/public/' . $relative);

        if (file_exists($expected)) {
            @unlink($expected);
        }

        if (file_exists($legacy)) {
            @unlink($legacy);
        }
    }

    private function parseDynamicApplicationSummary($cover_letter)
    {
        $values_by_label = [];
        $lines = preg_split('/\r\n|\r|\n/', (string)$cover_letter);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || stripos($line, 'Submitted via dynamic application form:') === 0) {
                continue;
            }

            $separator_pos = strpos($line, ':');
            if ($separator_pos === false) {
                continue;
            }

            $label = trim(substr($line, 0, $separator_pos));
            $value = trim(substr($line, $separator_pos + 1));

            if ($label !== '') {
                $values_by_label[$label] = $value;
            }
        }

        return $values_by_label;
    }

    private function extractResumeFromDynamicFiles($form_files)
    {
        if (!$form_files || !isset($form_files['name']) || !is_array($form_files['name'])) {
            return null;
        }

        foreach ($form_files['name'] as $field_name => $name) {
            if (stripos((string)$field_name, 'resume') === false) {
                continue;
            }

            $error = $form_files['error'][$field_name] ?? UPLOAD_ERR_NO_FILE;
            if ($error !== UPLOAD_ERR_OK) {
                continue;
            }

            return [
                'name' => $name,
                'type' => $form_files['type'][$field_name] ?? '',
                'tmp_name' => $form_files['tmp_name'][$field_name] ?? '',
                'error' => $error,
                'size' => $form_files['size'][$field_name] ?? 0,
            ];
        }

        return null;
    }

    public function interviews($action = null)
    {
        Auth::requireRole(4);
        
        if ($action === 'feedback') {
            return $this->interviewFeedback();
        }

        $data = [];
        $interviewModel = new Interview();
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // Get all user's interviews
        $interviews = $interviewModel->getUserInterviews($user_id);
        
        $data['interviews'] = [];
        if ($interviews && is_array($interviews)) {
            foreach ($interviews as $interview) {
                $data['interviews'][] = [
                    'id' => $interview['id'],
                    'job_title' => $interview['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'date' => date('Y-m-d', strtotime($interview['scheduled_date'])),
                    'time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'type' => $interview['interview_type'] ?? 'Interview',
                    'interviewer' => $interview['interviewer_name'] ?? 'TBD',
                    'status' => strtolower($interview['status']),
                    'location' => $interview['location'] ?? $interview['meeting_link'] ?? 'TBD',
                    'duration' => ($interview['duration_minutes'] ?? 60) . ' minutes',
                    'department' => $interview['department'] ?? 'General',
                    'notes' => $interview['notes'] ?? ''
                ];
            }
        }
        
        // Separate upcoming and past interviews
        $data['upcoming_interviews'] = [];
        $data['past_interviews'] = [];
        
        foreach ($data['interviews'] as $interview) {
            if (strtotime($interview['date']) >= strtotime('today') && $interview['status'] !== 'completed') {
                $data['upcoming_interviews'][] = $interview;
            } else {
                $data['past_interviews'][] = $interview;
            }
        }
        
        // Get interview statistics
        $stats = $interviewModel->getInterviewCount($user_id);
        if (!$stats) {
            $stats = [
                'total_interviews' => 0,
                'upcoming_interviews' => 0,
                'completed_interviews' => 0
            ];
        }
        
        $data['stats'] = [
            'total' => (int)$stats['total_interviews'],
            'upcoming' => (int)$stats['upcoming_interviews'], 
            'completed' => (int)$stats['completed_interviews']
        ];

        $this->view('applicant/interviews', $data);
    }

    public function interviewFeedback()
    {
        Auth::requireRole(4);
        
        $data = [];
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // For now, since we don't have feedback table implemented in current schema,
        // we'll show a placeholder message
        $data['feedbacks'] = [];
        $data['message'] = "Interview feedback will be available after your interviews are completed.";

        $this->view('applicant/feedback', $data);
    }

    public function profile($action = null)
    {
        Auth::requireRole(4);
        
        if ($action === 'edit') {
            return $this->editProfile();
        }
        
        if ($action === 'update') {
            return $this->updateProfile();
        }

        $data = [];
        $userModel = new User();
        $applicationModel = new Application();
        $interviewModel = new Interview();
        $user_id = Auth::user_id();
        
        // Get current user data
        $current_user = Auth::user();
        $application_stats = $applicationModel->getApplicationStats($user_id) ?: [];
        $interview_stats = $interviewModel->getInterviewCount($user_id) ?: [];
        $profile_picture_url = $this->getProfilePictureUrl($current_user['profile_picture'] ?? '');
        
        $data['user'] = [
            'id' => $current_user['id'],
            'name' => $current_user['full_name'] ?? 'Not provided',
            'email' => $current_user['email'] ?? 'Not provided',
            'phone' => $current_user['phone'] ?? 'Not provided',
            'location' => $current_user['address'] ?? 'Not provided',
            'profile_picture' => $current_user['profile_picture'] ?? '',
            'profile_picture_url' => $profile_picture_url,
            'created_at' => $current_user['created_at'] ?? '',
            'last_login' => $current_user['last_login'] ?? 'Never',
            'status' => $current_user['status'] ?? 'active',
            'role_label' => 'Applicant',
            'member_since' => !empty($current_user['created_at']) ? date('M j, Y', strtotime($current_user['created_at'])) : 'Not available',
            'last_login_display' => !empty($current_user['last_login']) ? date('M j, Y g:i A', strtotime($current_user['last_login'])) : 'Never',
            // Default values for fields not in database
            'bio' => 'Professional seeking new opportunities in the field.',
            'skills' => [], // Could be implemented as separate table later
            'experience' => [], // Could be implemented as separate table later
            'education' => [] // Could be implemented as separate table later
        ];

        $data['form_values'] = [
            'full_name' => $current_user['full_name'] ?? '',
            'email' => $current_user['email'] ?? '',
            'phone' => $current_user['phone'] ?? '',
            'address' => $current_user['address'] ?? ''
        ];

        $data['application_stats'] = [
            'total_applications' => (int)($application_stats['total_applications'] ?? 0),
            'under_review_applications' => (int)($application_stats['under_review_applications'] ?? 0),
            'shortlisted_applications' => (int)($application_stats['shortlisted_applications'] ?? 0),
            'interview_scheduled' => (int)($application_stats['interview_scheduled'] ?? 0)
        ];

        $data['interview_stats'] = [
            'total_interviews' => (int)($interview_stats['total_interviews'] ?? 0),
            'upcoming_interviews' => (int)($interview_stats['upcoming_interviews'] ?? 0),
            'completed_interviews' => (int)($interview_stats['completed_interviews'] ?? 0)
        ];
        
        // Calculate profile completion
        $data['profile_completion'] = $this->calculateProfileCompletion($current_user);

        $this->view('applicant/profile', $data);
    }
    
    public function editProfile()
    {
        Auth::requireRole(4);
        redirect('applicant/profile');
    }
    
    public function updateProfile()
    {
        Auth::requireRole(4);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('applicant/profile');
            return;
        }
        
        $userModel = new User();
        $user_id = Auth::user_id();
        $existing_user = $userModel->first(['id' => $user_id], []);
        $submit_section = $_POST['submit_section'] ?? '';
        $photo_intent = ($_POST['photo_upload_intent'] ?? '') === '1';
        $has_profile_picture_upload = isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK;
        $is_photo_only_request = $has_profile_picture_upload && (
            $submit_section === 'photo' ||
            ($submit_section !== 'personal' && $submit_section !== 'security' && $photo_intent)
        );

        // Photo-only update should not require personal info validation.
        if ($is_photo_only_request) {
            if ($has_profile_picture_upload) {
                $upload_result = $this->handleProfilePictureUpload($_FILES['profile_picture'], $user_id);
                if ($upload_result['success']) {
                    $photo_update = [
                        'profile_picture' => $upload_result['path'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($userModel->update($user_id, $photo_update)) {
                        $_SESSION['USER'] = array_merge($_SESSION['USER'], $photo_update);
                        $_SESSION['success'] = 'Profile picture updated successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to update profile picture. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = $upload_result['error'];
                }
            } else {
                $_SESSION['error'] = 'Please select an image to upload.';
            }

            redirect('applicant/profile');
            return;
        }
        
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => strtolower(trim($_POST['email'] ?? '')),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? '')
        ];

        $password_change_requested = !empty($_POST['new_password']) || !empty($_POST['confirm_password']);

        if ($password_change_requested) {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($current_password)) {
                $_SESSION['error'] = 'Current password is required to change your password.';
                redirect('applicant/profile');
                return;
            }

            if (!$existing_user || !password_verify($current_password, $existing_user['password'])) {
                $_SESSION['error'] = 'Current password is incorrect.';
                redirect('applicant/profile');
                return;
            }

            if (empty($new_password)) {
                $_SESSION['error'] = 'New password is required.';
                redirect('applicant/profile');
                return;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'New passwords do not match.';
                redirect('applicant/profile');
                return;
            }

            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $validation_data = $data;
        if ($password_change_requested) {
            $validation_data['password'] = $_POST['new_password'];
            $validation_data['confirm_password'] = $_POST['confirm_password'];
        }

        if (!$userModel->validateProfileUpdate($validation_data, $user_id)) {
            $_SESSION['error'] = implode(' ', $userModel->errors);
            redirect('applicant/profile');
            return;
        }
        
        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_result = $this->handleProfilePictureUpload($_FILES['profile_picture'], $user_id);
            if ($upload_result['success']) {
                $data['profile_picture'] = $upload_result['path'];
            } else {
                $_SESSION['error'] = $upload_result['error'];
                redirect('applicant/profile');
                return;
            }
        }
        
        // Remove empty values
        $data = array_filter($data, function($value) {
            return $value !== '';
        });
        
        if (!empty($data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            if ($userModel->update($user_id, $data)) {
                // Update session data
                $_SESSION['USER'] = array_merge($_SESSION['USER'], $data);
                $_SESSION['success'] = "Profile updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update profile. Please try again.";
            }
        }
        
        redirect('applicant/profile');
    }

    public function deleteProfile()
    {
        Auth::requireRole(4);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('applicant/profile');
            return;
        }

        $user_id = Auth::user_id();
        $userModel = new User();
        $existing_user = $userModel->first(['id' => $user_id], []);

        if (!$existing_user) {
            Auth::logout();
            redirect('signin');
            return;
        }

        $delete_confirmation = strtoupper(trim($_POST['delete_confirmation'] ?? ''));
        $delete_password = $_POST['delete_current_password'] ?? '';

        if ($delete_confirmation !== 'DELETE') {
            $_SESSION['error'] = 'Type DELETE to confirm profile deletion.';
            redirect('applicant/profile');
            return;
        }

        if (empty($delete_password) || !password_verify($delete_password, $existing_user['password'])) {
            $_SESSION['error'] = 'Current password is required to delete your profile.';
            redirect('applicant/profile');
            return;
        }

        $pdo = null;

        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=8889;dbname=' . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $pdo->beginTransaction();

            $now = date('Y-m-d H:i:s');
            $stamp = date('YmdHis');
            $anonymized_email = 'deleted+' . $user_id . '.' . $stamp . '@deleted.local';
            $replacement_password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

            $update_data = [
                'full_name' => 'Deleted Applicant #' . $user_id,
                'email' => $anonymized_email,
                'password' => $replacement_password,
                'status' => 'inactive',
                'phone' => null,
                'address' => null,
                'profile_picture' => null,
                'last_login' => null,
                'updated_at' => $now,
            ];

            if ($this->columnExists($pdo, 'users', 'password_reset_token')) {
                $update_data['password_reset_token'] = null;
            }

            if ($this->columnExists($pdo, 'users', 'password_reset_expires')) {
                $update_data['password_reset_expires'] = null;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_at')) {
                $update_data['deleted_at'] = $now;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_by')) {
                $update_data['deleted_by'] = $user_id;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_email')) {
                $update_data['deleted_email'] = $existing_user['email'] ?? null;
            }

            if ($this->columnExists($pdo, 'users', 'delete_reason')) {
                $update_data['delete_reason'] = 'Self-service account closure';
            }

            $set_clauses = [];
            $params = ['user_id' => $user_id];

            foreach ($update_data as $column => $value) {
                $set_clauses[] = "$column = :$column";
                $params[$column] = $value;
            }

            $soft_delete_sql = 'UPDATE users SET ' . implode(', ', $set_clauses) . ' WHERE id = :user_id AND role_id = 4';
            $soft_delete_stmt = $pdo->prepare($soft_delete_sql);
            $soft_delete_stmt->execute($params);

            if ($soft_delete_stmt->rowCount() !== 1) {
                throw new RuntimeException('Unable to deactivate applicant profile.');
            }

            $pdo->commit();

            AccessLog::log('account_soft_deleted', 'Applicant self-deactivated account', $user_id);

            Auth::logout();
            redirect('signin?deleted=1');
            return;
        } catch (Throwable $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $_SESSION['error'] = 'Failed to deactivate profile. Please try again or contact support.';
            redirect('applicant/profile');
            return;
        }
    }
    
    private function handleProfilePictureUpload($file, $user_id)
    {
        $upload_dir = $this->publicPath('uploads/profiles');
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            return ['success' => false, 'error' => 'Only JPEG, PNG, and GIF images are allowed.'];
        }
        
        // Validate file size (2MB max)
        if ($file['size'] > 2097152) {
            return ['success' => false, 'error' => 'Image size must be less than 2MB.'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => true, 'path' => '/uploads/profiles/' . $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload image.'];
        }
    }

    private function getProfilePictureUrl($profile_picture)
    {
        $default = ROOT . '/assets/images/profiles/default-avatar.jpg';

        if (empty($profile_picture)) {
            return $default;
        }

        $relative = ltrim($profile_picture, '/');
        $expected = $this->publicPath($relative);
        if (file_exists($expected)) {
            return ROOT . '/' . $relative;
        }

        $legacy = $this->publicPath('HireFlow/public/' . $relative);
        if (file_exists($legacy)) {
            $target_dir = dirname($expected);
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            @copy($legacy, $expected);
            return ROOT . '/' . $relative;
        }

        return $default;
    }

    private function tableExists(PDO $pdo, $table_name)
    {
        $query = 'SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = :schema_name AND TABLE_NAME = :table_name LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'schema_name' => DB_NAME,
            'table_name' => $table_name
        ]);

        return (bool)$stmt->fetchColumn();
    }

    private function columnExists(PDO $pdo, $table_name, $column_name)
    {
        $query = 'SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :schema_name AND TABLE_NAME = :table_name AND COLUMN_NAME = :column_name LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'schema_name' => DB_NAME,
            'table_name' => $table_name,
            'column_name' => $column_name
        ]);

        return (bool)$stmt->fetchColumn();
    }

    private function deleteUploadedAsset($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);
        $legacy = $this->publicPath('HireFlow/public/' . $relative);

        if (file_exists($expected)) {
            @unlink($expected);
        }

        if (file_exists($legacy)) {
            @unlink($legacy);
        }
    }
    
    public function notifications($action = null)
    {
        Auth::requireRole(4);
        
        $notificationModel = new Notification();
        $user_id = Auth::user_id();
        
        if ($action === 'mark-read' && isset($_POST['notification_id'])) {
            $notificationModel->markAsRead($_POST['notification_id']);
            echo json_encode(['success' => true]);
            return;
        }
        
        $data = [];
        $data['notifications'] = $notificationModel->getUserNotifications($user_id, 50);
        $data['unread_count'] = $notificationModel->getUnreadCount($user_id);

        $this->view('applicant/notifications', $data);
    }
    
    // View single application details
    public function viewApplication($application_id = null)
    {
        Auth::requireRole(4);
        
        if (!$application_id) {
            redirect('applicant/applications');
            return;
        }
        
        $applicationModel = new Application();
        $user_id = Auth::user_id();
        
        // Get application details
        $application = $applicationModel->getApplicationById($application_id);
        
        // Verify application belongs to current user
        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }

        $this->ensureResumeFileAccessible($application['resume_path'] ?? '');
        
        $data = [];
        $data['user'] = $this->getUserData($user_id);
        $data['application'] = [
            'id' => $application['id'],
            'job_id' => $application['job_id'],
            'job_title' => $application['job_title'] ?? 'Unknown Position',
            'company' => 'HireFlow Company',
            'location' => $application['location'] ?? 'Not specified',
            'salary' => $application['salary_range'] ?? 'Not specified',
            'department' => $application['department'] ?? 'General',
            'employment_type' => $application['employment_type'] ?? 'Full-time',
            'status' => $application['status'],
            'cover_letter' => $application['cover_letter'],
            'resume_path' => $application['resume_path'],
            'applied_date' => date('M d, Y', strtotime($application['applied_at'])),
            'deadline' => $application['deadline'] ? date('M d, Y', strtotime($application['deadline'])) : 'Open'
        ];
        
        $this->view('applicant/view-application', $data);
    }
    
    // Edit application
    public function editApplication($application_id = null)
    {
        Auth::requireRole(4);
        
        if (!$application_id) {
            redirect('applicant/applications');
            return;
        }
        
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->updateApplication($application_id);
        }
        
        // Get application details
        $application = $applicationModel->getApplicationById($application_id);
        
        // Verify application belongs to current user
        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }
        
        // Check if application can be edited (only "Applied" or "Under Review" status)
        if (!in_array($application['status'], ['Applied', 'Under Review'])) {
            $_SESSION['error'] = "This application cannot be edited at this stage.";
            redirect('applicant/applications');
            return;
        }
        
        // Check deadline
        if ($application['deadline'] && strtotime($application['deadline']) < time()) {
            $_SESSION['error'] = "The deadline for this job has passed. You cannot edit this application.";
            redirect('applicant/applications');
            return;
        }

        $this->ensureResumeFileAccessible($application['resume_path'] ?? '');

        $formMeta = $applicationFormModel->getFormByJobPostId($application['job_id']);
        $form = null;
        $grouped_fields = [];
        $prefill_values = [];

        if ($formMeta) {
            $form = $applicationFormModel->getFormWithFields($formMeta['id']);
        }

        if ($form && !empty($form['fields'])) {
            $saved_values = $this->parseDynamicApplicationSummary($application['cover_letter'] ?? '');

            foreach ($form['fields'] as $field) {
                if (!(int)$field['is_enabled']) {
                    continue;
                }

                $category = $field['field_category'];
                if (!isset($grouped_fields[$category])) {
                    $grouped_fields[$category] = [];
                }
                $grouped_fields[$category][] = $field;

                $prefill_values[$field['field_name']] = $saved_values[$field['field_label']] ?? '';
            }
        }
        
        $data = [];
        $data['user'] = $this->getUserData($user_id);
        $data['application'] = [
            'id' => $application['id'],
            'job_id' => $application['job_id'],
            'job_title' => $application['job_title'] ?? 'Unknown Position',
            'company' => 'HireFlow Company',
            'location' => $application['location'] ?? 'Not specified',
            'salary' => $application['salary_range'] ?? 'Not specified',
            'department' => $application['department'] ?? 'General',
            'employment_type' => $application['employment_type'] ?? 'Not specified',
            'deadline' => $application['deadline'] ?? null,
            'cover_letter' => $application['cover_letter'],
            'resume_path' => $application['resume_path']
        ];
        $data['form'] = $form;
        $data['grouped_fields'] = $grouped_fields;
        $data['prefill_values'] = $prefill_values;
        $data['category_labels'] = $this->getApplicationFormCategoryLabels();
        
        $this->view('applicant/edit-application', $data);
    }
    
    // Update application
    private function updateApplication($application_id)
    {
        Auth::requireRole(4);
        
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();
        
        // Get current application
        $application = $applicationModel->getApplicationById($application_id);
        
        // Verify ownership
        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }
        
        $update_data = [];

        // Support dynamic form edit values as primary source.
        $formMeta = $applicationFormModel->getFormByJobPostId($application['job_id']);
        if ($formMeta) {
            $form = $applicationFormModel->getFormWithFields($formMeta['id']);
            if ($form && !empty($form['fields']) && isset($_POST['form_fields']) && is_array($_POST['form_fields'])) {
                $responses = [];
                foreach ($form['fields'] as $field) {
                    if (!(int)$field['is_enabled']) {
                        continue;
                    }

                    $field_name = $field['field_name'];
                    $field_type = $field['field_type'];

                    if ($field_type === 'file') {
                        continue;
                    }

                    if ($field_type === 'checkbox') {
                        $responses[$field_name] = !empty($_POST['form_fields'][$field_name]) ? 'Yes' : 'No';
                        continue;
                    }

                    $value = $_POST['form_fields'][$field_name] ?? '';
                    $responses[$field_name] = is_string($value) ? trim($value) : $value;
                }

                $update_data['cover_letter'] = $this->buildDynamicApplicationSummary($form, $responses);
            }
        }

        // Backward compatibility for legacy edit screen posts.
        if (empty($update_data['cover_letter']) && !empty($_POST['cover_letter'])) {
            $update_data['cover_letter'] = $_POST['cover_letter'];
        }
        
        // Handle resume upload from legacy input or dynamic form file input.
        $resume_file = null;
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $resume_file = $_FILES['resume'];
        } else {
            $resume_file = $this->extractResumeFromDynamicFiles($_FILES['form_files'] ?? null);
        }

        if ($resume_file) {
            $upload_result = $this->handleDynamicFormFileUpload($resume_file, $user_id, true);
            if ($upload_result['success']) {
                $update_data['resume_path'] = $upload_result['path'];
                
                // Delete old resume file
                $this->deleteResumeFile($application['resume_path'] ?? '');
            } else {
                $_SESSION['error'] = $upload_result['error'];
                redirect('applicant/editApplication/' . $application_id);
                return;
            }
        }
        
        // Update application in database
        if (!empty($update_data)) {
            if ($applicationModel->updateApplication($application_id, $update_data)) {
                $_SESSION['success'] = "Application updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update application. Please try again.";
            }
        } else {
            $_SESSION['error'] = "No changes were made.";
        }
        
        redirect('applicant/applications');
    }
    
    // Delete application
    public function deleteApplication($application_id = null)
    {
        Auth::requireRole(4);
        
        if (!$application_id) {
            redirect('applicant/applications');
            return;
        }
        
        $applicationModel = new Application();
        $user_id = Auth::user_id();
        
        // Get application details
        $application = $applicationModel->getApplicationById($application_id);
        
        // Verify ownership
        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }
        
        // Check if application can be deleted (only "Applied" or "Under Review" status)
        if (!in_array($application['status'], ['Applied', 'Under Review'])) {
            $_SESSION['error'] = "This application cannot be deleted at this stage.";
            redirect('applicant/applications');
            return;
        }
        
        // Delete resume file
        $this->deleteResumeFile($application['resume_path'] ?? '');
        
        // Delete application from database
        if ($applicationModel->deleteApplication($application_id)) {
            $_SESSION['success'] = "Application deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete application. Please try again.";
        }
        
        redirect('applicant/applications');
    }
}
