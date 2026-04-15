<?php

/**
 * Applications Controller
 * Handles job applications (browse, apply, manage, edit, delete)
 */
class Applications extends Controller
{
    use ApplicantBaseTrait;

    public function index()
    {
        Auth::requireRole(4);
        
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
                    'last_update' => date('Y-m-d', strtotime($app['applied_at'])),
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

    public function apply()
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
        $resume_upload_failed = false;

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
                        if ($is_resume_field) {
                            $resume_upload_failed = true;
                        }
                        continue;
                    }

                    $responses[$field_name] = $upload_result['path'];
                    if ($is_resume_field) {
                        $resume_path = $upload_result['path'];
                    }
                } elseif ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
                    $validation_errors[] = $this->getUploadErrorMessage($file['error'], $field_label);
                    if (stripos($field_name, 'resume') !== false) {
                        $resume_upload_failed = true;
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

        if (empty($resume_path) && !$resume_upload_failed) {
            $validation_errors[] = "Resume upload is required.";
        }

        if (!empty($validation_errors)) {
            $_SESSION['error'] = implode(' ', array_unique($validation_errors));
            redirect('applicant/applications/apply?job_id=' . $job_id);
            return;
        }

        $cover_letter = $this->buildDynamicApplicationSummary($form, $responses);
        $form_data = [];
        foreach ($responses as $field_name => $value) {
            $form_data[$field_name] = $value;
        }

        $data = [
            'job_id' => $job_id,
            'applicant_id' => $user_id,
            'form_id' => (int)($formMeta['id'] ?? 0),
            'form_data' => $form_data,
            'cover_letter' => $cover_letter,
            'resume_path' => $resume_path,
            'status' => 'Applied'
        ];
        
        // Submit application
        if ($applicationModel->submitApplication($data)) {
            $_SESSION['success'] = "Your application has been submitted successfully!";
            redirect('applicant/applications');
        } else {
            $_SESSION['error'] = "Failed to submit application. Please try again.";
            redirect('applicant/applications/apply?job_id=' . $job_id);
        }
    }

    public function view($name, $data = [])
    {
        // Keep compatibility with applicant/applications/view/{id} route
        // while preserving Controller::view(...) behavior for template rendering.
        if ($name === null || (is_scalar($name) && ctype_digit((string)$name))) {
            return $this->viewApplication($name !== null ? (int)$name : null);
        }

        return parent::view($name, $data);
    }

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
        
        parent::view('applicant/view-application', $data);
    }

    public function edit($application_id = null)
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
            return $this->update($application_id);
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

    public function update($application_id)
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

        // Support dynamic form edit values as primary source
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
                $update_data['form_id'] = (int)$formMeta['id'];
                $update_data['form_data'] = json_encode($responses, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
        }

        // Backward compatibility for legacy edit screen posts
        if (empty($update_data['cover_letter']) && !empty($_POST['cover_letter'])) {
            $update_data['cover_letter'] = $_POST['cover_letter'];
        }
        
        // Handle resume upload from legacy input or dynamic form file input
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
                redirect('applicant/applications/edit/' . $application_id);
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

    public function delete($application_id = null)
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
