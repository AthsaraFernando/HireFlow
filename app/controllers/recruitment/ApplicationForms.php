<?php

// ApplicationForms Controller
 
class ApplicationForms extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Application Forms Management';
        
        // Get current user ID
        $user_id = Auth::user_id();
        
        // Initialize models
        $applicationForm = new ApplicationForm();
        $jobPost = new JobPost();
        
        // Get search and filter parameters
        $search = $_GET['search'] ?? '';
        $status_filter = $_GET['status'] ?? 'all'; // all, active, inactive, draft, deleted
        
        // Get all open, non-deleted job posts (that don't have active forms)
        $availableJobs = $jobPost->query(
            "SELECT jp.* 
            FROM job_posts jp
            LEFT JOIN application_forms af ON jp.id = af.job_post_id AND af.is_deleted = 0
            WHERE jp.status = 'Open' 
            AND jp.is_deleted = 0
            AND af.id IS NULL
            ORDER BY jp.created_at DESC"
        );
        
        // Get forms based on status filter
        if ($status_filter === 'deleted') {
            $createdForms = $applicationForm->getFormsWithJobDetails($user_id, true);
        } else {
            $createdForms = $applicationForm->getFormsWithJobDetails($user_id, false);
        }
        
        // Apply status filter
        if ($status_filter !== 'all' && $status_filter !== 'deleted') {
            $createdForms = array_filter($createdForms, function($form) use ($status_filter) {
                return $form['status'] === $status_filter;
            });
        }
        
        // Apply search filter if provided
        if (!empty($search)) {
            $createdForms = array_filter($createdForms, function($form) use ($search) {
                return stripos($form['form_title'], $search) !== false || 
                       stripos($form['job_title'], $search) !== false;
            });
        }
        
        $data['available_jobs'] = $availableJobs ?? [];
        $data['created_forms'] = $createdForms ?? [];
        $data['search'] = $search;
        $data['status_filter'] = $status_filter;
        
        // Add statistics
        $data['stats'] = [
            'available_jobs' => count($data['available_jobs']),
            'total_forms' => count($data['created_forms']),
            'active_forms' => count(array_filter($data['created_forms'], function($f) {
                return isset($f['status']) && $f['status'] === 'active' && !$f['is_deleted'];
            })),
            'inactive_forms' => count(array_filter($data['created_forms'], function($f) {
                return isset($f['status']) && $f['status'] === 'inactive' && !$f['is_deleted'];
            })),
            'draft_forms' => count(array_filter($data['created_forms'], function($f) {
                return isset($f['status']) && $f['status'] === 'draft';
            }))
        ];

        $this->view('recruitment/application-forms', $data);
    }


    //Show create form page
    public function create($job_post_id = null)
    {
        Auth::requireRole(3);

        if (!$job_post_id) {
            redirect('recruitment/applicationforms');
        }

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Create Application Form';
        
        // Get job post details
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $job_post_id]);
        
        if (!$job) {
            $_SESSION['error'] = "Job post not found";
            redirect('recruitment/applicationforms');
        }

        // Check if form already exists
        $applicationForm = new ApplicationForm();
        if ($applicationForm->jobPostHasForm($job_post_id)) {
            $_SESSION['error'] = "Application form already exists for this job post";
            redirect('recruitment/applicationforms');
        }

        $data['job'] = $job;
        
        // Get available fields
        $data['available_fields'] = ApplicationFormField::getAvailableFields();

        $this->view('recruitment/create-application-form', $data);
    }

    
    //Store new application form
    public function store()
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $applicationForm = new ApplicationForm();
        $applicationFormField = new ApplicationFormField();

        // Get form data
        $job_post_id = $_POST['job_post_id'] ?? null;
        $form_title = $_POST['form_title'] ?? null;
        $form_description = $_POST['form_description'] ?? null;
        $selected_fields = $_POST['fields'] ?? [];

        // Validate
        if (!$job_post_id) {
            $_SESSION['error'] = "Job post ID is required";
            redirect('recruitment/applicationforms');
        }

        if (empty($selected_fields)) {
            $_SESSION['error'] = "Please select at least one field for the form";
            redirect(getenv("HTTP_REFERER") ?? "recruitment/applicationforms");
        }

        // Check if form already exists
        if ($applicationForm->jobPostHasForm($job_post_id)) {
            $_SESSION['error'] = "Application form already exists for this job post";
            redirect('recruitment/applicationforms');
        }

        // Get job post details
        $jobPost = new JobPost();
        $job = $jobPost->first(['id' => $job_post_id]);

        if (!$job) {
            $_SESSION['error'] = "Job post not found";
            redirect('recruitment/applicationforms');
        }

        // Create form 
        $formData = [
            'job_post_id' => $job_post_id,
            'created_by' => $user_id,
            'form_title' => $form_title ?? "Application Form - " . $job->title,
            'form_description' => $form_description ?? "Please fill out this application form for the position of " . $job->title,
            'status' => 'draft',
            'is_deleted' => 0
        ];

        if ($applicationForm->validate($formData)) {
            $form_id = $applicationForm->insert($formData);

            if ($form_id) {
                AccessLog::log(
                    'application_form_created',
                    'Created application form ID ' . $form_id . ' for job post ID ' . $job_post_id
                );

                // Save selected fields
                if ($applicationFormField->saveFormFields($form_id, $selected_fields)) {
                    // Update field count
                    $applicationForm->updateFieldsCount($form_id);
                    
                    $_SESSION['success'] = "Application form created successfully";
                    redirect('recruitment/applicationforms/preview/' . $form_id);
                } else {
                    $_SESSION['error'] = "Form created but failed to save fields";
                    redirect('recruitment/applicationforms/edit/' . $form_id);
                }
            } else {
                $_SESSION['error'] = "Failed to create application form";
                redirect(getenv("HTTP_REFERER") ?? "recruitment/applicationforms");
            }
        } else {
            $_SESSION['error'] = implode(", ", $applicationForm->errors);
            redirect(getenv("HTTP_REFERER") ?? "recruitment/applicationforms");
        }
    }

    
    //Preview form
    public function preview($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            redirect('recruitment/applicationforms');
        }

        $data = [];
        $data['page_title'] = 'Preview Application Form';
        
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->getFormWithFields($form_id);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check if user is the creator
        $user_id = Auth::user_id();
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Group fields by category
        $grouped_fields = [];
        if (!empty($form['fields'])) {
            foreach ($form['fields'] as $field) {
                $category = $field['field_category'];
                if (!isset($grouped_fields[$category])) {
                    $grouped_fields[$category] = [];
                }
                $grouped_fields[$category][] = $field;
            }
        }

        // Order categories in the correct sequence
        $category_order = [
            'personal_info',
            'education',
            'work_experience',
            'skills',
            'documents',
            'availability',
            'declarations'
        ];
        
        $ordered_fields = [];
        foreach ($category_order as $category) {
            if (isset($grouped_fields[$category])) {
                $ordered_fields[$category] = $grouped_fields[$category];
            }
        }

        $data['form'] = $form;
        $data['grouped_fields'] = $ordered_fields;
        $data['category_labels'] = $this->getCategoryLabels();

        $this->view('recruitment/preview-application-form', $data);
    }

    
    //Edit form
    public function edit($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            redirect('recruitment/applicationforms');
        }

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Edit Application Form';
        
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->getFormWithFields($form_id);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check if user is the creator
        $user_id = Auth::user_id();
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        $data['form'] = $form;
        $data['available_fields'] = ApplicationFormField::getAvailableFields();
        
        // Get currently selected fields
        $selected_fields = [];
        if (!empty($form['fields'])) {
            foreach ($form['fields'] as $field) {
                if (!isset($selected_fields[$field['field_category']])) {
                    $selected_fields[$field['field_category']] = [];
                }
                $selected_fields[$field['field_category']][] = $field['field_name'];
            }
        }
        $data['selected_fields'] = $selected_fields;

        $this->view('recruitment/edit-application-form', $data);
    }


    //Update form
    public function update()
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $form_id = $_POST['form_id'] ?? null;
        $form_title = $_POST['form_title'] ?? null;
        $form_description = $_POST['form_description'] ?? null;
        $selected_fields = $_POST['fields'] ?? [];

        if (!$form_id) {
            $_SESSION['error'] = "Form ID is required";
            redirect('recruitment/applicationforms');
        }

        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Update form details
        $updateData = [
            'form_title' => $form_title,
            'form_description' => $form_description
        ];

        $applicationForm->query(
            "UPDATE application_forms SET form_title = :form_title, form_description = :form_description WHERE id = :form_id",
            array_merge($updateData, ['form_id' => $form_id])
        );

        // Update fields
        if (!empty($selected_fields)) {
            $applicationFormField = new ApplicationFormField();
            
            // Delete existing fields
            $applicationFormField->deleteFieldsByFormId($form_id);
            
            // Save new fields
            $applicationFormField->saveFormFields($form_id, $selected_fields);
            
            // Update field count
            $applicationForm->updateFieldsCount($form_id);
        }

        $_SESSION['success'] = "Application form updated successfully";
        redirect('recruitment/applicationforms/preview/' . $form_id);
    }


    //Publish form
    public function publish($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            $_SESSION['error'] = "Form ID is required";
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Publish the form
        if ($applicationForm->publishForm($form_id)) {
            AccessLog::log(
                'application_form_published',
                'Published application form ID ' . $form_id
            );
            $_SESSION['success'] = "Application form published successfully and is now live for applicants";
            redirect('recruitment/applicationforms/preview/' . $form_id);
        } else {
            $_SESSION['error'] = "Failed to publish form";
            redirect('recruitment/applicationforms/preview/' . $form_id);
        }
    }

    
    //Delete form
    public function delete($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            $_SESSION['error'] = "Form ID is required";
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Soft delete: Mark form as deleted and set status to inactive
        if ($applicationForm->softDelete($form_id)) {
            AccessLog::log(
                'application_form_deleted',
                'Soft-deleted application form ID ' . $form_id
            );
            $_SESSION['success'] = "Application form has been deleted successfully";
            redirect('recruitment/applicationforms');
        } else {
            $_SESSION['error'] = "Failed to delete form";
            redirect('recruitment/applicationforms');
        }
    }

    //Change form status
    public function changeStatus()
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $form_id = $_POST['form_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$form_id || !$status) {
            $_SESSION['error'] = "Form ID and status are required";
            redirect('recruitment/applicationforms');
        }

        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Update status
        if ($applicationForm->updateStatus($form_id, $status)) {
            AccessLog::log(
                'application_form_status_updated',
                'Updated application form ID ' . $form_id . ' status to ' . $status
            );
            $_SESSION['success'] = "Form status updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update form status";
        }

        redirect(getenv("HTTP_REFERER") ?? "recruitment/applicationforms");
    }

    
    //Toggle form status between active and inactive
    public function toggleStatus($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            $_SESSION['error'] = "Form ID is required";
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Toggle status
        $newStatus = $form['status'] === 'active' ? 'inactive' : 'active';
        
        if ($applicationForm->updateStatus($form_id, $newStatus)) {
            AccessLog::log(
                'application_form_status_updated',
                'Toggled application form ID ' . $form_id . ' status to ' . $newStatus
            );
            $_SESSION['success'] = "Form status changed to " . $newStatus;
        } else {
            $_SESSION['error'] = "Failed to update form status";
        }

        redirect('recruitment/applicationforms');
    }

    //Restore deleted form
    public function restore($form_id = null)
    {
        Auth::requireRole(3);

        if (!$form_id) {
            $_SESSION['error'] = "Form ID is required";
            redirect('recruitment/applicationforms');
        }

        $user_id = Auth::user_id();
        $applicationForm = new ApplicationForm();
        $form = $applicationForm->first(['id' => $form_id]);

        if (!$form) {
            $_SESSION['error'] = "Form not found";
            redirect('recruitment/applicationforms');
        }

        // Check authorization
        if ($form['created_by'] != $user_id) {
            $_SESSION['error'] = "Unauthorized access";
            redirect('recruitment/applicationforms');
        }

        // Restore form
        if ($applicationForm->restoreForm($form_id)) {
            AccessLog::log(
                'application_form_restored',
                'Restored application form ID ' . $form_id
            );
            $_SESSION['success'] = "Form restored successfully";
        } else {
            $_SESSION['error'] = "Failed to restore form";
        }

        redirect('recruitment/applicationforms?show_deleted=1');
    }

    //Helper function to get category labels
    private function getCategoryLabels()
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

}
