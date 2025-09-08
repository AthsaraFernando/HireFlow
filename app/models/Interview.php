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
}
?>
