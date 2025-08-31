<?php

class InterviewSchedule extends Controller
{
    public function index()
    {
        // TODO: Add authentication check when role-based login is implemented
        // if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Recruitment Manager') {
        //     redirect('signin');
        //     return;
        // }

        $data = [];
        $data['page_title'] = 'Interview Schedule';
        
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
