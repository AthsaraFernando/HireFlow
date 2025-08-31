<?php

class JobPost
{
    use Model;
    protected $table = 'job_posts';
    protected $allowedColumns = [
        'title',
        'department_id',
        'description',
        'requirements',
        'salary_range',
        'location',
        'employment_type',
        'status',
        'posted_by',
        'deadline'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['title'])) {
            $this->errors['title'] = "Job title is required";
        }

        if (empty($data['description'])) {
            $this->errors['description'] = "Job description is required";
        }

        if (empty($data['department_id'])) {
            $this->errors['department_id'] = "Department is required";
        }

        if (empty($data['posted_by'])) {
            $this->errors['posted_by'] = "Posted by user ID is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getJobsWithDepartments()
    {
        $query = "SELECT jp.*, d.name as department_name, u.first_name, u.last_name 
                  FROM job_posts jp 
                  LEFT JOIN departments d ON jp.department_id = d.id 
                  LEFT JOIN users u ON jp.posted_by = u.id 
                  ORDER BY jp.created_at DESC";
        
        return $this->query($query);
    }

    public function getActiveJobs()
    {
        $query = "SELECT jp.*, d.name as department_name 
                  FROM job_posts jp 
                  LEFT JOIN departments d ON jp.department_id = d.id 
                  WHERE jp.status = 'active' 
                  ORDER BY jp.posted_at DESC";
        
        return $this->query($query);
    }
}
