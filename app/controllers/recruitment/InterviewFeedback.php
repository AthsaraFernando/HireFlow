<?php

class InterviewFeedback extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Interview Feedback';
        
        $data['pending_feedback'] = [
            [
                'interview_id' => 1,
                'candidate_name' => 'Alice Chen',
                'job_title' => 'Senior Software Developer',
                'interview_date' => '2025-09-01',
                'interview_type' => 'Technical Interview',
                'status' => 'pending'
            ],
            [
                'interview_id' => 2,
                'candidate_name' => 'Robert Kim',
                'job_title' => 'Data Analyst',
                'interview_date' => '2025-08-30',
                'interview_type' => 'HR Interview',
                'status' => 'pending'
            ]
        ];

        $this->view('recruitment/interview-feedback', $data);
    }
}
