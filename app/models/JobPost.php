<?php

class JobPost
{
    use Model;
    protected $table = 'job_posts';
    protected $allowedColumns = [
        'title',
        'department_id',
        'department',
        'description',
        'requirements',
        'responsibilities',
        'salary_range',
        'location',
        'employment_type',
        'experience_level',
        'status',
        'posted_by',
        'hr_id',
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

    public function getAllJobs()
    {
        $query = "SELECT jp.*, u.full_name as posted_by_name,
                  (SELECT COUNT(*) FROM applications WHERE job_id = jp.id) as applications_count
                  FROM job_posts jp 
                  LEFT JOIN users u ON jp.hr_id = u.id 
                  ORDER BY jp.created_at DESC";
        
        return $this->query($query);
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

    public function getActiveJobs($limit = 20, $offset = 0)
    {
        $query = "SELECT * FROM job_posts 
                  WHERE status = 'Open' 
                  AND (deadline IS NULL OR deadline >= CURDATE())
                  ORDER BY created_at DESC 
                  LIMIT $limit OFFSET $offset";
        
        return $this->query($query);
    }
    
    public function getJobById($id)
    {
        $query = "SELECT * FROM job_posts WHERE id = ? AND status = 'Open'";
        return $this->get_row($query, [$id]);
    }
    
    public function searchJobs($filters = [], $limit = 20, $offset = 0)
    {
        $conditions = ["status = 'Open'"];
        $params = [];
        
        if (!empty($filters['title'])) {
            $conditions[] = "title LIKE ?";
            $params[] = '%' . $filters['title'] . '%';
        }
        
        if (!empty($filters['department'])) {
            $conditions[] = "department LIKE ?";
            $params[] = '%' . $filters['department'] . '%';
        }
        
        if (!empty($filters['location'])) {
            $conditions[] = "location LIKE ?";
            $params[] = '%' . $filters['location'] . '%';
        }
        
        if (!empty($filters['employment_type'])) {
            $conditions[] = "employment_type = ?";
            $params[] = $filters['employment_type'];
        }
        
        $whereClause = implode(' AND ', $conditions);
        
        // Execute the query with parameters first to get filtered results
        if (!empty($params)) {
            $baseQuery = "SELECT * FROM job_posts WHERE {$whereClause} ORDER BY created_at DESC";
            $results = $this->query($baseQuery, $params);
            
            // Apply pagination manually to avoid PDO parameter binding issues with LIMIT/OFFSET
            if ($results && is_array($results)) {
                return array_slice($results, $offset, $limit);
            }
            return [];
        } else {
            $query = "SELECT * FROM job_posts WHERE {$whereClause} ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
            return $this->query($query);
        }
    }
    
    public function getJobCount($filters = [])
    {
        $conditions = ["status = 'Open'"];
        $params = [];
        
        if (!empty($filters['title'])) {
            $conditions[] = "title LIKE ?";
            $params[] = '%' . $filters['title'] . '%';
        }
        
        if (!empty($filters['department'])) {
            $conditions[] = "department LIKE ?";
            $params[] = '%' . $filters['department'] . '%';
        }
        
        if (!empty($filters['location'])) {
            $conditions[] = "location LIKE ?";
            $params[] = '%' . $filters['location'] . '%';
        }
        
        if (!empty($filters['employment_type'])) {
            $conditions[] = "employment_type = ?";
            $params[] = $filters['employment_type'];
        }
        
        $whereClause = implode(' AND ', $conditions);
        $query = "SELECT COUNT(*) as total FROM job_posts WHERE {$whereClause}";
        
        $result = $this->get_row($query, $params);
        return $result ? $result['total'] : 0;
    }
}
