<?php

class Application
{
    use Model;
    protected $table = 'applications';
    protected $allowedColumns = [
        'job_post_id',
        'applicant_id',
        'cover_letter',
        'resume_path',
        'status'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['job_post_id'])) {
            $this->errors['job_post_id'] = "Job post ID is required";
        }

        if (empty($data['applicant_id'])) {
            $this->errors['applicant_id'] = "Applicant ID is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getApplicationsWithDetails()
    {
        $query = "SELECT a.*, jp.title as job_title, u.first_name, u.last_name, u.email
                  FROM applications a 
                  LEFT JOIN job_posts jp ON a.job_post_id = jp.id 
                  LEFT JOIN users u ON a.applicant_id = u.id 
                  ORDER BY a.applied_at DESC";
        
        return $this->query($query);
    }

    public function getUserApplications($user_id)
    {
        $query = "SELECT a.*, jp.title as job_title, jp.location, jp.employment_type
                  FROM applications a 
                  LEFT JOIN job_posts jp ON a.job_post_id = jp.id 
                  WHERE a.applicant_id = ? 
                  ORDER BY a.applied_at DESC";
        
        return $this->query($query, [$user_id]);
    }
}
