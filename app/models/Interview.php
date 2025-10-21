<?php

class Interview
{
    use Model;
    protected $table = 'interviews';
    protected $allowedColumns = [
        'application_id',
        'interviewer_id',
        'interview_type',
        'scheduled_date',
        'scheduled_time',
        'duration_minutes',
        'location',
        'meeting_link',
        'status',
        'notes'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['application_id'])) {
            $this->errors['application_id'] = "Application ID is required";
        }

        if (empty($data['interviewer_id'])) {
            $this->errors['interviewer_id'] = "Interviewer ID is required";
        }

        if (empty($data['scheduled_date'])) {
            $this->errors['scheduled_date'] = "Interview date is required";
        }

        if (empty($data['scheduled_time'])) {
            $this->errors['scheduled_time'] = "Interview time is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getUserInterviews($user_id)
    {
        $query = "SELECT i.*, 
                         a.job_id,
                         jp.title as job_title, 
                         jp.department,
                         u.full_name as interviewer_name
                  FROM interviews i 
                  JOIN applications a ON i.application_id = a.id
                  JOIN job_posts jp ON a.job_id = jp.id 
                  LEFT JOIN users u ON i.interviewer_id = u.id
                  WHERE a.applicant_id = ?
                  ORDER BY i.scheduled_date ASC, i.scheduled_time ASC";
        
        return $this->query($query, [$user_id]);
    }
    
    public function getUpcomingInterviews($user_id)
    {
        $query = "SELECT i.*, 
                         a.job_id,
                         jp.title as job_title, 
                         jp.department,
                         u.full_name as interviewer_name
                  FROM interviews i 
                  JOIN applications a ON i.application_id = a.id
                  JOIN job_posts jp ON a.job_id = jp.id 
                  LEFT JOIN users u ON i.interviewer_id = u.id
                  WHERE a.applicant_id = ?
                  AND i.scheduled_date >= CURDATE()
                  AND i.status = 'Scheduled'
                  ORDER BY i.scheduled_date ASC, i.scheduled_time ASC
                  LIMIT 5";
        
        return $this->query($query, [$user_id]);
    }
    
    public function getInterviewCount($user_id)
    {
        $query = "SELECT COUNT(*) as total_interviews,
                         SUM(CASE WHEN i.status = 'Scheduled' AND i.scheduled_date >= CURDATE() THEN 1 ELSE 0 END) as upcoming_interviews,
                         SUM(CASE WHEN i.status = 'Completed' THEN 1 ELSE 0 END) as completed_interviews
                  FROM interviews i 
                  JOIN applications a ON i.application_id = a.id
                  WHERE a.applicant_id = ?";
        
        return $this->get_row($query, [$user_id]);
    }

    
    //Get all interviews for recruitment manager with candidate and job details
    
    public function getInterviewsForRecruitment()
    {
        $query = "SELECT 
                    i.id,
                    i.application_id,
                    i.interviewer_id,
                    i.interview_type,
                    i.scheduled_date,
                    i.scheduled_time,
                    i.duration_minutes,
                    i.location,
                    i.meeting_link,
                    i.status,
                    i.notes,
                    a.applicant_id,
                    u.full_name as candidate_name,
                    jp.title as job_title,
                    interviewer.full_name as interviewer_name,
                    r.role_name as interviewer_role
                  FROM interviews i
                  JOIN applications a ON i.application_id = a.id
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN users interviewer ON i.interviewer_id = interviewer.id
                  LEFT JOIN roles r ON interviewer.role_id = r.id
                  ORDER BY i.scheduled_date DESC, i.scheduled_time DESC";
        
        return $this->query($query);
    }

    /**
     * Get a single interview by ID with all details
     */
    public function getInterviewById($id)
    {
        $query = "SELECT 
                    i.*,
                    a.applicant_id,
                    a.job_id,
                    u.full_name as candidate_name,
                    jp.title as job_title,
                    interviewer.full_name as interviewer_name,
                    r.role_name as interviewer_role
                  FROM interviews i
                  JOIN applications a ON i.application_id = a.id
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN users interviewer ON i.interviewer_id = interviewer.id
                  LEFT JOIN roles r ON interviewer.role_id = r.id
                  WHERE i.id = ?
                  LIMIT 1";
        
        return $this->get_row($query, [$id]);
    }

    /**
     * Create a new interview
     * Overrides the Model trait's insert method to return true on success
     */
    public function createInterview($data)
    {
        // Set default status to 'Pending'
        if (!isset($data['status'])) {
            $data['status'] = 'Pending';
        }

        // Set default interview type if not provided
        if (!isset($data['interview_type'])) {
            $data['interview_type'] = 'Video';
        }

        // Call parent insert and explicitly return true if successful
        $this->insert($data);
        return true; // Override the false return from Model trait
    }

    /**
     * Update an existing interview
     * Overrides the Model trait's update method to return true on success
     */
    public function updateInterview($id, $data)
    {
        // Call parent update and explicitly return true if successful
        $this->update($id, $data);
        return true; // Override the false return from Model trait
    }

    /**
     * Delete an interview
     * Overrides the Model trait's delete method with correct implementation
     */
    public function deleteInterview($id)
    {
        // Use direct query instead of the buggy Model trait delete
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $this->query($query, ['id' => $id]);
        return true;
    }

    /**
     * Get shortlisted candidates who don't have pending/scheduled interviews
     * Only returns candidates with role_id = 4 (Applicant)
     */
    public function getAvailableCandidates()
    {
        $query = "SELECT 
                    a.id as application_id,
                    a.applicant_id,
                    a.job_id,
                    u.full_name as candidate_name,
                    jp.title as job_title,
                    a.status
                  FROM applications a
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  WHERE a.status = 'Shortlisted'
                  AND u.role_id = 4
                  AND NOT EXISTS (
                      SELECT 1 FROM interviews i 
                      WHERE i.application_id = a.id 
                      AND i.status IN ('Pending', 'Scheduled')
                  )
                  ORDER BY a.applied_at DESC";
        
        return $this->query($query);
    }
}
?>
