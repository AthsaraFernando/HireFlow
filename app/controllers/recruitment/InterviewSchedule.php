<?php

class InterviewSchedule extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Interview Schedule';
        
        // Fetch shortlisted candidates for interview scheduling
        // Query directly from applications table, only candidates with "Shortlisted" status
        // Exclude records where applicant_name is NULL
        $application = new Application();
        $query = "SELECT 
                    a.id as application_id,
                    a.applicant_id,
                    a.job_id,
                    a.applicant_name as candidate_name,
                    a.job_title,
                    a.resume_path,
                    a.status,
                    a.applied_at
                  FROM applications a
                  WHERE a.status = 'Shortlisted'
                  AND a.applicant_name IS NOT NULL
                  AND a.applicant_name != ''
                  ORDER BY a.applied_at DESC";
        
        $result = $application->query($query);
        $data['shortlisted_candidates'] = is_array($result) ? $result : [];
        
        $data['interviews'] = [
            [
                'id' => 1,
                'candidate_name' => 'Alice Chen',
                'job_title' => 'Senior Software Developer',
                'date' => '2025-09-02',
                'time' => '10:00',
                'duration' => 60,
                'type' => 'Technical Interview',
                'status' => 'confirmed',
                'location' => 'Video Call'
            ],
            [
                'id' => 2,
                'candidate_name' => 'Robert Kim',
                'job_title' => 'Data Analyst',
                'date' => '2025-09-03',
                'time' => '14:00',
                'duration' => 45,
                'type' => 'HR Interview',
                'status' => 'pending',
                'location' => 'Conference Room A'
            ]
        ];

        $this->view('recruitment/interview-schedule', $data);
    }
}
