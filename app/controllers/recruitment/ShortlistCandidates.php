<?php

class ShortlistCandidates extends Controller
{
    public function index()
    {
        // TODO: Add authentication check when role-based login is implemented
        // if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Recruitment Manager') {
        //     redirect('signin');
        //     return;
        // }

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Shortlisted Candidates';
        
        $data['shortlisted_candidates'] = [
            [
                'id' => 1,
                'name' => 'Alice Chen',
                'email' => 'alice.chen@email.com',
                'job_title' => 'Senior Software Developer',
                'job_id' => 1,
                'experience' => 7,
                'match_score' => 94,
                'shortlisted_date' => '2025-08-28',
                'status' => 'interview_scheduled',
                'interview_date' => '2025-09-02 10:00',
                'skills' => ['React', 'Node.js', 'TypeScript', 'AWS'],
                'current_company' => 'Microsoft',
                'location' => 'Seattle, WA'
            ],
            [
                'id' => 2,
                'name' => 'Robert Kim',
                'email' => 'robert.kim@email.com',
                'job_title' => 'Data Analyst',
                'job_id' => 2,
                'experience' => 5,
                'match_score' => 89,
                'shortlisted_date' => '2025-08-27',
                'status' => 'pending_interview',
                'interview_date' => null,
                'skills' => ['Python', 'SQL', 'Tableau', 'Machine Learning'],
                'current_company' => 'Analytics Pro',
                'location' => 'New York, NY'
            ]
        ];

        $this->view('recruitment/shortlist-candidates', $data);
    }
}
