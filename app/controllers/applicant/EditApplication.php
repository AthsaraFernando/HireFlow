<?php

class EditApplication extends Controller
{
    use ApplicantBaseTrait;

    public function index($application_id = null)
    {
        Auth::requireRole(4);

        if (!$application_id) {
            redirect('applicant/applications');
            return;
        }

        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $user_id = Auth::user_id();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->update($application_id);
        }

        $application = $applicationModel->getApplicationById($application_id);

        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }

        if (!in_array($application['status'], ['Applied', 'Under Review'])) {
            $_SESSION['error'] = "This application cannot be edited at this stage.";
            redirect('applicant/applications');
            return;
        }

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

        $application = $applicationModel->getApplicationById($application_id);

        if (!$application || $application['applicant_id'] != $user_id) {
            $_SESSION['error'] = "Application not found.";
            redirect('applicant/applications');
            return;
        }

        $update_data = [];

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

        if (empty($update_data['cover_letter']) && !empty($_POST['cover_letter'])) {
            $update_data['cover_letter'] = $_POST['cover_letter'];
        }

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
                $this->deleteResumeFile($application['resume_path'] ?? '');
            } else {
                $_SESSION['error'] = $upload_result['error'];
                redirect('applicant/applications/edit/' . $application_id);
                return;
            }
        }

        if (!empty($update_data)) {
            if ($applicationModel->updateApplication($application_id, $update_data)) {
                AccessLog::log(
                    'application_updated',
                    'Applicant updated application ID ' . (int)$application_id . ' for job ID ' . (int)$application['job_id'],
                    $user_id
                );
                $_SESSION['success'] = "Application updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update application. Please try again.";
            }
        } else {
            $_SESSION['error'] = "No changes were made.";
        }

        redirect('applicant/applications');
    }
}
