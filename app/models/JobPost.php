<?php

class JobPost
{
    use Model;

    protected $table = 'job_posts';

    protected $allowedColumns = [
        'title',
        'department_id',
        // ❌ removed 'department' (denormalized, don’t store)
        'description',
        'requirements',
        'responsibilities', // ✅ keep (was removed in PR incorrectly)
        'salary_range',
        'location',
        'employment_type',
        'experience_level', // ✅ keep (was removed in PR incorrectly)
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

        return empty($this->errors);
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

        // ✅ FIX: use department_id instead of department string
        if (!empty($filters['department_id'])) {
            $conditions[] = "department_id = ?";
            $params[] = $filters['department_id'];
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

        if (!empty($params)) {
            $baseQuery = "SELECT * FROM job_posts WHERE {$whereClause} ORDER BY created_at DESC";
            $results = $this->query($baseQuery, $params);

            if ($results && is_array($results)) {
                return array_slice($results, $offset, $limit);
            }
            return [];
        } else {
            $query = "SELECT * FROM job_posts WHERE {$whereClause} ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
            return $this->query($query);
        }
    }

    // ✅ KEEP original count method (used elsewhere likely)
    public function getFilteredJobCount($filters = [])
    {
        $conditions = ["status = 'Open'"];
        $params = [];

        if (!empty($filters['title'])) {
            $conditions[] = "title LIKE ?";
            $params[] = '%' . $filters['title'] . '%';
        }

        if (!empty($filters['department_id'])) {
            $conditions[] = "department_id = ?";
            $params[] = $filters['department_id'];
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

    // ✅ KEEP original signature (don’t break callers)
    public function getJobCount($status = null)
    {
        if ($status === null) {
            $query = "SELECT COUNT(*) as total FROM job_posts";
            $result = $this->get_row($query);
        } else {
            $query = "SELECT COUNT(*) as total FROM job_posts WHERE status = ?";
            $result = $this->get_row($query, [$status]);
        }

        return $result ? (int)$result['total'] : 0;
    }

    // ✅ NEW feature from PR (good addition)
    public function getJobPostStats()
    {
        $query = "SELECT
                    d.id AS department_id,
                    d.name AS department_name,
                    COUNT(jp.id) as job_count
                  FROM departments d 
                  LEFT JOIN job_posts jp
                    ON jp.department_id = d.id
                  GROUP BY d.id
                  ORDER BY d.id ASC";

        $result = $this->query($query);
        return $result ?: [];
    }
}