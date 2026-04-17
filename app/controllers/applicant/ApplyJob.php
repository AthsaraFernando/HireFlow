<?php

class ApplyJob extends Controller
{
    use ApplicantBaseTrait;

    public function index($job_id = null)
    {
        Auth::requireRole(4);

        if ($job_id !== null && !isset($_GET['job_id'])) {
            $_GET['job_id'] = (int)$job_id;
        }

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->processJobApplication();
        }

        $job = $jobModel->getJobById($job_id);
        if (!$job) {
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

        if ($applicationModel->submitApplication($data)) {
            $_SESSION['success'] = "Your application has been submitted successfully!";
            redirect('applicant/applications');
        } else {
            $_SESSION['error'] = "Failed to submit application. Please try again.";
            redirect('applicant/applications/apply?job_id=' . $job_id);
        }
    }
}
