<?php

class CandidateEvaluation extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Candidate Evaluation';
        
        $data['evaluated_candidates'] = [
            [
                'id' => 1,
                'name' => 'Alice Chen',
                'job_title' => 'Senior Software Developer',
                'overall_score' => 8.5,
                'technical_score' => 9,
                'communication_score' => 8,
                'cultural_fit_score' => 8,
                'recommendation' => 'hire',
                'evaluation_date' => '2025-09-01'
            ],
            [
                'id' => 2,
                'name' => 'Robert Kim',
                'job_title' => 'Data Analyst',
                'overall_score' => 7.2,
                'technical_score' => 7,
                'communication_score' => 8,
                'cultural_fit_score' => 7,
                'recommendation' => 'consider',
                'evaluation_date' => '2025-08-30'
            ]
        ];

        $this->view('recruitment/candidate-evaluation', $data);
    }
}
