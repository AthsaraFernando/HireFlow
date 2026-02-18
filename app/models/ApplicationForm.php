<?php

/**
 * ApplicationForm Model
 * 
 * Manages application forms created by recruitment managers for job posts
 * Handles CRUD operations for custom application forms
 */
class ApplicationForm
{
    use Model;
    protected $table = 'application_forms';
    protected $allowedColumns = [
        'job_post_id',
        'created_by',
        'form_title',
        'form_description',
        'status',
        'is_deleted',
        'total_fields',
        'submission_count',
        'published_at'
    ];

    /**
     * Validate application form data
     */
    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['job_post_id'])) {
            $this->errors['job_post_id'] = "Job post ID is required";
        }

        if (empty($data['created_by'])) {
            $this->errors['created_by'] = "Creator ID is required";
        }

        if (empty($data['form_title'])) {
            $this->errors['form_title'] = "Form title is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    /**
     * Get all application forms with job post details
     * Excludes deleted forms by default
     */
    public function getFormsWithJobDetails($manager_id = null, $include_deleted = false)
    {
        $query = "SELECT 
                    af.*,
                    jp.title as job_title,
                    jp.department,
                    jp.location,
                    jp.employment_type,
                    jp.salary_range,
                    jp.deadline,
                    jp.status as job_status,
                    u.full_name as creator_name
                FROM {$this->table} af
                INNER JOIN job_posts jp ON af.job_post_id = jp.id
                INNER JOIN users u ON af.created_by = u.id
                WHERE af.is_deleted = " . ($include_deleted ? "1" : "0");
        
        if ($manager_id) {
            $query .= " AND af.created_by = :manager_id";
            $query .= " ORDER BY af.created_at DESC";
            return $this->query($query, ['manager_id' => $manager_id]);
        }
        
        $query .= " ORDER BY af.created_at DESC";
        return $this->query($query);
    }

    /**
     * Get form by job post ID
     */
    public function getFormByJobPostId($job_post_id)
    {
        $query = "SELECT af.*,
                    jp.title as job_title,
                    jp.department,
                    jp.location,
                    jp.employment_type,
                    jp.salary_range,
                    jp.deadline,
                    jp.description,
                    jp.requirements,
                    jp.responsibilities
                FROM {$this->table} af
                INNER JOIN job_posts jp ON af.job_post_id = jp.id
                WHERE af.job_post_id = :job_post_id
                LIMIT 1";
        
        $result = $this->query($query, ['job_post_id' => $job_post_id]);
        return $result ? $result[0] : null;
    }

    /**
     * Get form with all fields
     */
    public function getFormWithFields($form_id)
    {
        $query = "SELECT af.*,
                    jp.title as job_title,
                    jp.department,
                    jp.location,
                    jp.employment_type,
                    jp.salary_range,
                    jp.deadline,
                    jp.description as job_description,
                    jp.requirements as job_requirements
                FROM {$this->table} af
                INNER JOIN job_posts jp ON af.job_post_id = jp.id
                WHERE af.id = :form_id
                LIMIT 1";
        
        $form = $this->query($query, ['form_id' => $form_id]);
        
        if ($form && isset($form[0])) {
            $form = $form[0];
            
            // Get form fields
            $fieldsQuery = "SELECT * FROM application_form_fields 
                          WHERE form_id = :form_id 
                          AND is_enabled = 1
                          ORDER BY field_category, field_order";
            
            $form['fields'] = $this->query($fieldsQuery, ['form_id' => $form_id]);
            
            return $form;
        }
        
        return null;
    }

    /**
     * Create form from job post
     */
    public function createFormFromJobPost($job_post_id, $manager_id)
    {
        // Get job post details
        $jobPost = $this->query(
            "SELECT * FROM job_posts WHERE id = :id LIMIT 1",
            ['id' => $job_post_id]
        );

        if (!$jobPost) {
            $this->errors['job_post_id'] = "Job post not found";
            return false;
        }

        $jobPost = $jobPost[0];

        // Create form (no need to store job details, will fetch from job_posts table)
        $formData = [
            'job_post_id' => $job_post_id,
            'created_by' => $manager_id,
            'form_title' => "Application Form - " . $jobPost['title'],
            'form_description' => "Please fill out this application form for the position of " . $jobPost['title'],
            'status' => 'draft',
            'is_deleted' => 0
        ];

        if ($this->validate($formData)) {
            return $this->insert($formData);
        }

        return false;
    }

    /**
     * Publish form (make it active)
     */
    public function publishForm($form_id)
    {
        $query = "UPDATE {$this->table} 
                SET status = 'active', 
                    published_at = CURRENT_TIMESTAMP,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :form_id";
        
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Update form status
     */
    public function updateStatus($form_id, $status)
    {
        $query = "UPDATE {$this->table} 
                SET status = :status,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :form_id";
        
        return $this->query($query, [
            'form_id' => $form_id,
            'status' => $status
        ]);
    }

    /**
     * Soft delete - mark form as deleted and set status to inactive
     */
    public function softDelete($form_id)
    {
        $query = "UPDATE {$this->table} 
                  SET is_deleted = 1, status = 'inactive' 
                  WHERE id = :form_id";
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Restore deleted form
     */
    public function restoreForm($form_id)
    {
        $query = "UPDATE {$this->table} 
                  SET is_deleted = 0, status = 'draft' 
                  WHERE id = :form_id";
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Hard delete - permanently remove form (use with caution)
     */
    public function deleteForm($form_id)
    {
        // Cascade delete will handle form_fields, submissions, and submission_data
        $query = "DELETE FROM {$this->table} WHERE id = :form_id";
        return $this->query($query, ['form_id' => $form_id]);
    }

    /**
     * Get statistics for a form
     */
    public function getFormStats($form_id)
    {
        $query = "SELECT 
                    COUNT(DISTINCT a.id) as total_submissions,
                    COUNT(DISTINCT CASE WHEN a.status = 'Applied' THEN a.id END) as new_submissions,
                    COUNT(DISTINCT CASE WHEN a.status = 'Under Review' THEN a.id END) as under_review,
                    COUNT(DISTINCT CASE WHEN a.status = 'Shortlisted' THEN a.id END) as shortlisted,
                    COUNT(DISTINCT CASE WHEN a.status = 'Rejected' THEN a.id END) as rejected
                FROM application_forms af
                LEFT JOIN applications a ON af.job_post_id = a.job_id AND a.form_id = af.id
                WHERE af.id = :form_id
                GROUP BY af.id";
        
        $result = $this->query($query, ['form_id' => $form_id]);
        return $result ? $result[0] : null;
    }

    /**
     * Check if job post already has a form
     */
    public function jobPostHasForm($job_post_id)
    {
        $query = "SELECT id FROM {$this->table} WHERE job_post_id = :job_post_id LIMIT 1";
        $result = $this->query($query, ['job_post_id' => $job_post_id]);
        return !empty($result);
    }

    /**
     * Get all forms by manager
     */
    public function getFormsByManager($manager_id)
    {
        return $this->where(['created_by' => $manager_id]);
    }

    /**
     * Update total fields count
     */
    public function updateFieldsCount($form_id)
    {
        $query = "UPDATE {$this->table} 
                SET total_fields = (
                    SELECT COUNT(*) FROM application_form_fields 
                    WHERE form_id = :form_id AND is_enabled = 1
                )
                WHERE id = :form_id";
        
        return $this->query($query, ['form_id' => $form_id]);
    }
}
