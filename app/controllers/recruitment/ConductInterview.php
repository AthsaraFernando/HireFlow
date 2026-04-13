<?php

class ConductInterview extends Controller
{
    public function index($interview_id = null)
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        if (!$interview_id) {
            redirect('recruitment/interview-schedule');
            return;
        }

        $data = [];
        $data['page_title'] = 'Conduct Interview';
        
        // Sample interview data
        $data['interview'] = [
            'id' => $interview_id,
            'candidate_name' => 'Alice Chen',
            'job_title' => 'Senior Software Developer',
            'date' => '2025-09-02',
            'time' => '10:00',
            'duration' => 60,
            'type' => 'Technical Interview',
            'candidate_email' => 'alice.chen@email.com',
            'resume_url' => '/resumes/alice_chen.pdf'
        ];
        
        $data['evaluation_criteria'] = [
            'Technical Skills',
            'Problem Solving',
            'Communication',
            'Cultural Fit',
            'Experience Relevance'
        ];

        $this->view('recruitment/conduct-interview', $data);
    }
}
