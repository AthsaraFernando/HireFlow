<?php

class Application
{
    use Model;
    protected $table = 'applications';
    protected $allowedColumns = [
        'job_id',
        'applicant_id',
        'cover_letter',
        'resume_path',
        'status',
        'additional_documents'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['job_id'])) {
            $this->errors['job_id'] = "Job ID is required";
        }

        if (empty($data['applicant_id'])) {
            $this->errors['applicant_id'] = "Applicant ID is required";
        }

        if (empty($data['resume_path'])) {
            $this->errors['resume_path'] = "Resume is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getApplicationsWithDetails()
    {
        $query = "SELECT a.*, jp.title as job_title, u.full_name, u.email
                  FROM applications a 
                  LEFT JOIN job_posts jp ON a.job_id = jp.id 
                  LEFT JOIN users u ON a.applicant_id = u.id 
                  ORDER BY a.applied_at DESC";

        return $this->query($query);
    }

    public function getUserApplications($user_id)
    {
        $query = "SELECT a.*, jp.title as job_title, jp.location, jp.employment_type, jp.salary_range, jp.department
                  FROM applications a 
                  LEFT JOIN job_posts jp ON a.job_id = jp.id 
                  WHERE a.applicant_id = ?
                  ORDER BY a.applied_at DESC";

        return $this->query($query, [$user_id]);
    }

    public function getApplicationStats($user_id)
    {
        $query = "SELECT 
                    COUNT(*) as total_applications,
                    SUM(CASE WHEN status = 'Applied' THEN 1 ELSE 0 END) as pending_applications,
                    SUM(CASE WHEN status = 'Under Review' THEN 1 ELSE 0 END) as under_review_applications,
                    SUM(CASE WHEN status = 'Shortlisted' THEN 1 ELSE 0 END) as shortlisted_applications,
                    SUM(CASE WHEN status = 'Interview Scheduled' THEN 1 ELSE 0 END) as interview_scheduled,
                    SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected_applications,
                    SUM(CASE WHEN status = 'Offered' THEN 1 ELSE 0 END) as offered_applications
                  FROM applications 
                  WHERE applicant_id = ?";

        return $this->get_row($query, [$user_id]);
    }

    public function hasAppliedToJob($user_id, $job_id)
    {
        $query = "SELECT id FROM applications WHERE applicant_id = ? AND job_id = ?";
        $result = $this->get_row($query, [$user_id, $job_id]);
        return $result !== false;
    }

    public function submitApplication($data)
    {
        // Check if user already applied
        if ($this->hasAppliedToJob($data['applicant_id'], $data['job_id'])) {
            $this->errors['duplicate'] = "You have already applied to this job";
            return false;
        }

        if ($this->validate($data)) {
            $data['applied_at'] = date('Y-m-d H:i:s');
            AccessLog::log('application_submit', 'Apllication submission jobId: ' . $data['job_id'], Auth::user_id());
            $this->insert($data);
            return true;
        }
        return false;
    }

    /**
     * Update application status
     * Overrides the Model trait's update method to return true on success
     */
    public function updateStatus($id, $status)
    {
        $query = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $this->query($query, ['status' => $status, 'id' => $id]);
        return true;
    }

    /**
     * Override update method to return true on success
     * Cannot use parent:: because Model is a trait, not a parent class
     */
    public function update($id, $data, $id_column = 'id')
    {
        // Removing non-allowed data before preparing the query
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "update $this->table set ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . ", ";
        }

        $query = trim($query, ", ");
        $query .= " where $id_column = :$id_column";

        $data[$id_column] = $id;
        $this->query($query, $data);
        return true; // Override the false return from Model trait
    }

    public function updateApplication($application_id, $data)
    {
        return $this->update($application_id, $data);
    }

    public function deleteApplication($application_id)
    {
        $query = "DELETE FROM applications WHERE id = ?";
        $con = $this->connect();
        $stmt = $con->prepare($query);
        $result = $stmt->execute([$application_id]);
        return $result; // Returns true if delete was successful
    }

    public function getApplicationById($application_id)
    {
        $query = "SELECT a.*, jp.title as job_title, jp.location, jp.employment_type, 
                         jp.salary_range, jp.department, jp.deadline
                  FROM applications a 
                  LEFT JOIN job_posts jp ON a.job_id = jp.id 
                  WHERE a.id = ?";

        return $this->get_row($query, [$application_id]);
    }

    public function getApplicationCount()
    {
        $query = "SELECT COUNT(*) AS total FROM {$this->table}";
        $result = $this->query($query);
        return $result ? (int) $result[0]['total'] : 0;
    }

    public function jobDemandStat()
    {
        $query = "SELECT jp.title, COUNT(*) AS applicationCount
                  FROM applications a
                  JOIN job_posts jp ON a.job_id = jp.id
                  GROUP BY jp.title";
        return $this->query(query: $query) ?: [];
    }
}
