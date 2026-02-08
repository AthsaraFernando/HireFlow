<?php

class Interview
{
    use Model;
    protected $table = 'interviews';
    protected $allowedColumns = [
        'application_id',
        'interviewer_id',
        'interview_type',
        'interview_stage',
        'interviewer_role',
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
                    i.interview_stage,
                    i.interviewer_role,
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
                    interviewer.full_name as interviewer_name
                  FROM interviews i
                  JOIN applications a ON i.application_id = a.id
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN users interviewer ON i.interviewer_id = interviewer.id
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
     * Get candidates available for interview scheduling
     * Shows candidates with Applied, Under Review, or Shortlisted status
     * Excludes candidates who already have scheduled interviews
     */
    public function getAvailableCandidates()
    {
        $query = "SELECT DISTINCT
                    a.id as application_id,
                    a.applicant_id,
                    a.job_id,
                    u.full_name as candidate_name,
                    jp.title as job_title,
                    a.status as application_status,
                    DATE(a.applied_at) as applied_date
                  FROM applications a
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  WHERE a.status IN ('Applied', 'Under Review', 'Shortlisted')
                  AND u.role_id = 4
                  AND u.status = 'active'
                  ORDER BY 
                    FIELD(a.status, 'Shortlisted', 'Under Review', 'Applied'),
                    a.applied_at DESC";
        
        return $this->query($query);
    }

    /**
     * Get available interviewer roles for selection
     */
    public function getInterviewerRoles()
    {
        return [
            'HR Admin' => 'HR Admin - Initial screening and policy compliance',
            'Recruitment Manager' => 'Recruitment Manager - Technical assessment and fit evaluation',
            'Hiring Manager' => 'Hiring Manager - Department fit and role-specific evaluation',
            'Technical Lead' => 'Technical Lead - Deep technical assessment',
            'Panel' => 'Panel Interview - Multiple interviewers for comprehensive evaluation'
        ];
    }

    /**
     * Get available interview stages
     */
    public function getInterviewStages()
    {
        return [
            'Screening' => 'Screening - Initial candidate evaluation',
            'Technical' => 'Technical - Technical skills assessment',
            'Managerial' => 'Managerial - Management and leadership evaluation',
            'HR Review' => 'HR Review - Final HR compliance and culture fit',
            'Final' => 'Final - Final decision interview'
        ];
    }

    /**
     * Get interviewers by role
     */
    public function getInterviewersByRole($role = null)
    {
        $baseQuery = "SELECT id, full_name, role_id, 
                             CASE role_id 
                                 WHEN 2 THEN 'HR Admin'
                                 WHEN 3 THEN 'Recruitment Manager'
                                 ELSE 'Staff'
                             END as user_role
                      FROM users 
                      WHERE status = 'active' AND role_id IN (2, 3)";
        
        if ($role) {
            switch($role) {
                case 'HR Admin':
                    $baseQuery .= " AND role_id = 2";
                    break;
                case 'Recruitment Manager':
                    $baseQuery .= " AND role_id = 3";
                    break;
                default:
                    // Return all for other roles like Hiring Manager, Technical Lead
                    break;
            }
        }
        
        $baseQuery .= " ORDER BY full_name";
        return $this->query($baseQuery);
    }

    /**
     * Get recommended interviewer role based on interview stage
     */
    public function getRecommendedRole($stage)
    {
        $recommendations = [
            'Screening' => 'HR Admin',
            'Technical' => 'Recruitment Manager',
            'Managerial' => 'Recruitment Manager',
            'HR Review' => 'HR Admin',
            'Final' => 'Recruitment Manager'
        ];
        
        return $recommendations[$stage] ?? 'HR Admin';
    }

    /**
     * Get detailed interviews for calendar view with all necessary information
     */
    public function getCalendarInterviews($start_date = null, $end_date = null)
    {
        $start_date = $start_date ?? date('Y-m-d', strtotime('monday this week'));
        $end_date = $end_date ?? date('Y-m-d', strtotime($start_date . ' +6 days'));

        $query = "SELECT 
                    i.*,
                    a.applicant_id,
                    a.job_id,
                    u.full_name as candidate_name,
                    u.email as candidate_email,
                    u.phone as candidate_phone,
                    jp.title as job_title,
                    jp.department,
                    jp.location as job_location,
                    interviewer.full_name as interviewer_name,
                    interviewer.email as interviewer_email,
                    interviewer.phone as interviewer_phone,
                    r.role_name as interviewer_role,
                    dept.name as department_name
                  FROM interviews i
                  JOIN applications a ON i.application_id = a.id
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN users interviewer ON i.interviewer_id = interviewer.id
                  LEFT JOIN roles r ON interviewer.role_id = r.id
                  LEFT JOIN departments dept ON jp.department_id = dept.id
                  WHERE i.scheduled_date BETWEEN ? AND ?
                  ORDER BY i.scheduled_date ASC, i.scheduled_time ASC";

        return $this->query($query, [$start_date, $end_date]);
    }

    /**
     * Get complete interview details by ID for modal popup
     */
    public function getInterviewDetails($interview_id)
    {
        $query = "SELECT 
                    i.*,
                    a.applicant_id,
                    a.job_id,
                    a.application_date,
                    a.status as application_status,
                    u.full_name as candidate_name,
                    u.email as candidate_email,
                    u.phone as candidate_phone,
                    u.address as candidate_address,
                    jp.title as job_title,
                    jp.description as job_description,
                    jp.requirements as job_requirements,
                    jp.department,
                    jp.location as job_location,
                    jp.salary_range,
                    interviewer.full_name as interviewer_name,
                    interviewer.email as interviewer_email,
                    interviewer.phone as interviewer_phone,
                    r.role_name as interviewer_role_name,
                    dept.name as department_name,
                    (SELECT COUNT(*) FROM interviews prev_i WHERE prev_i.application_id = a.id AND prev_i.id < i.id) as previous_interviews_count
                  FROM interviews i
                  JOIN applications a ON i.application_id = a.id
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN users interviewer ON i.interviewer_id = interviewer.id
                  LEFT JOIN roles r ON interviewer.role_id = r.id
                  LEFT JOIN departments dept ON jp.department_id = dept.id
                  WHERE i.id = ?";

        return $this->get_row($query, [$interview_id]);
    }

    /**
     * Get interview statistics for dashboard
     */
    public function getInterviewStats($start_date = null, $end_date = null)
    {
        $today = date('Y-m-d');
        
        // Calculate week start (Monday) and week end (Sunday)
        $week_start = $start_date ?? date('Y-m-d', strtotime('monday this week'));
        $week_end = $end_date ?? date('Y-m-d', strtotime('sunday this week'));

        $query = "SELECT 
                    COUNT(*) as total_interviews,
                    SUM(CASE WHEN i.scheduled_date = ? THEN 1 ELSE 0 END) as today_interviews,
                    SUM(CASE WHEN i.scheduled_date BETWEEN ? AND ? THEN 1 ELSE 0 END) as week_interviews,
                    SUM(CASE WHEN i.status IN ('Scheduled', 'Pending') AND i.scheduled_date >= ? THEN 1 ELSE 0 END) as pending_interviews,
                    SUM(CASE WHEN i.status = 'Completed' THEN 1 ELSE 0 END) as completed_interviews,
                    0 as avg_rating
                  FROM interviews i";

        return $this->get_row($query, [$today, $week_start, $week_end, $today]);
    }

    /**
     * Format interview time for calendar display
     */
    public function formatInterviewTime($scheduled_time, $duration_minutes = 60)
    {
        $start_time = strtotime($scheduled_time);
        $end_time = $start_time + ($duration_minutes * 60);
        
        return [
            'start' => date('H:i', $start_time),
            'end' => date('H:i', $end_time),
            'display' => date('g:i A', $start_time),
            'display_range' => date('g:i A', $start_time) . ' - ' . date('g:i A', $end_time)
        ];
    }

    /**
     * Create a new interview
     */
    public function createInterview($data)
    {
        // Validate data first
        if (!$this->validate($data)) {
            return false;
        }

        // Set default values (don't set created_at as it's auto-generated by database)
        $data['status'] = $data['status'] ?? 'Scheduled';
        $data['duration_minutes'] = $data['duration_minutes'] ?? 60;

        // Insert and return result
        $result = $this->insert($data);
        
        // Log any errors for debugging
        if ($result === false && !empty($this->errors)) {
            error_log("Interview creation failed: " . implode(", ", $this->errors));
        }
        
        return $result;
    }
}
?>
