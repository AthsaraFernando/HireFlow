<?php

class JobPost
{
    use Model;

    private $existingColumnsCache = null;

    protected $table = 'job_posts';
    protected $allowedColumns = [
        'title',
        'department_id',
        'department',
        'description',
        'requirements',
        'benefits',
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

    public function insert($data)
    {
        $data = $this->sanitizeDataForSchema($data);

        if (empty($data)) {
            $this->errors[] = 'No valid columns to insert.';
            return false;
        }

        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";

        try {
            $con = $this->connect();
            $stmt = $con->prepare($query);
            $stmt->execute($data);
            return $con->lastInsertId();
        } catch (PDOException $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    public function update($id, $data, $id_column = 'id')
    {
        $data = $this->sanitizeDataForSchema($data);

        if (empty($data)) {
            $this->errors[] = 'No valid columns to update.';
            return false;
        }

        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";

        foreach ($keys as $key) {
            $query .= "$key = :$key, ";
        }

        $query = trim($query, ", ");
        $query .= " WHERE $id_column = :$id_column";

        $data[$id_column] = $id;

        try {
            $this->query($query, $data);
            return true;
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    private function sanitizeDataForSchema($data)
    {
        $existingColumns = $this->getExistingColumns();

        foreach ($data as $key => $value) {
            if (!in_array($key, $this->allowedColumns, true)) {
                unset($data[$key]);
                continue;
            }

            if (!in_array($key, $existingColumns, true)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    private function getExistingColumns()
    {
        if (is_array($this->existingColumnsCache)) {
            return $this->existingColumnsCache;
        }

        $query = "SELECT COLUMN_NAME
                  FROM information_schema.columns
                  WHERE table_schema = DATABASE()
                  AND table_name = ?";

        $result = $this->query($query, [$this->table]);

        if (!is_array($result) || empty($result)) {
            $this->existingColumnsCache = $this->allowedColumns;
            return $this->existingColumnsCache;
        }

        $this->existingColumnsCache = array_map(function ($row) {
            return $row['COLUMN_NAME'];
        }, $result);

        return $this->existingColumnsCache;
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
    
    public function getFilteredJobCount($filters = [])
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
    
    public function getJobCount($status = null)
    {
        if ($status === null) {
            // Count all jobs
            $query = "SELECT COUNT(*) as total FROM job_posts";
            $result = $this->get_row($query);
        } else {
            // Count jobs by status
            $query = "SELECT COUNT(*) as total FROM job_posts WHERE status = ?";
            $result = $this->get_row($query, [$status]);
        }
        
        return $result ? (int)$result['total'] : 0;
    }
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