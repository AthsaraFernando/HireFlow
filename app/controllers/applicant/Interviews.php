<?php

/**
 * Interviews Controller
 * Handles interview scheduling and feedback display
 */
class Interviews extends Controller
{
    use ApplicantBaseTrait;

    private function normalizeAbsoluteUrl($value)
    {
        $value = trim((string)$value);
        if ($value === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $value)) {
            return $value;
        }

        if (preg_match('/^(www\.|[a-z0-9-]+\.)+[a-z]{2,}(\/.*)?$/i', $value)) {
            return 'https://' . $value;
        }

        if (strpos($value, ' ') === false) {
            return 'https://' . $value;
        }

        return '';
    }

    public function index()
    {
        Auth::requireRole(4);
        
        $data = [];
        $interviewModel = new Interview();
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // Get all user's interviews
        $interviews = $interviewModel->getUserInterviews($user_id);
        
        $data['interviews'] = [];
        if ($interviews && is_array($interviews)) {
            foreach ($interviews as $interview) {
                $raw_status = trim((string)($interview['status'] ?? 'Scheduled'));
                $normalized_status = strtolower(str_replace(' ', '-', $raw_status));

                $data['interviews'][] = [
                    'id' => $interview['id'],
                    'application_id' => (int)($interview['application_id'] ?? 0),
                    'job_title' => $interview['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'date' => date('Y-m-d', strtotime($interview['scheduled_date'])),
                    'time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'type' => $interview['interview_type'] ?? 'Interview',
                    'interviewer' => $interview['interviewer_name'] ?? 'TBD',
                    'status' => $normalized_status,
                    'status_display' => $raw_status,
                    'location_meeting_label' => 'Location/Meeting Link',
                    'location_meeting_text' => trim((string)($interview['meeting_link'] ?? $interview['location'] ?? 'TBD')),
                    'location_meeting_href' => $this->normalizeAbsoluteUrl($interview['meeting_link'] ?? '') ?: $this->normalizeAbsoluteUrl($interview['location'] ?? ''),
                    'duration' => ($interview['duration_minutes'] ?? 60) . ' minutes',
                    'department' => $interview['department'] ?? 'General',
                    'notes' => $interview['notes'] ?? ''
                ];
            }
        }
        
        // Separate upcoming and past interviews
        $data['upcoming_interviews'] = [];
        $data['past_interviews'] = [];
        
        foreach ($data['interviews'] as $interview) {
            if (strtotime($interview['date']) >= strtotime('today') && $interview['status'] !== 'completed') {
                $data['upcoming_interviews'][] = $interview;
            } else {
                $data['past_interviews'][] = $interview;
            }
        }
        
        // Get interview statistics
        $stats = $interviewModel->getInterviewCount($user_id);
        if (!$stats) {
            $stats = [
                'total_interviews' => 0,
                'upcoming_interviews' => 0,
                'completed_interviews' => 0
            ];
        }
        
        $data['stats'] = [
            'total' => (int)$stats['total_interviews'],
            'upcoming' => (int)$stats['upcoming_interviews'], 
            'completed' => (int)$stats['completed_interviews']
        ];

        $this->view('applicant/interviews', $data);
    }

    public function feedback()
    {
        Auth::requireRole(4);
        
        $data = [];
        $user_id = Auth::user_id();
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        $evaluationModel = new InterviewEvaluation();
        $feedbackRows = $evaluationModel->getFeedbackForApplicant($user_id);

        $data['feedbacks'] = [];
        if ($feedbackRows && is_array($feedbackRows)) {
            foreach ($feedbackRows as $row) {
                $data['feedbacks'][] = [
                    'id' => (int)$row['id'],
                    'interview_id' => (int)$row['interview_id'],
                    'application_id' => (int)($row['application_id'] ?? 0),
                    'job_title' => $row['job_title'] ?? 'Unknown Position',
                    'company' => 'HireFlow Company',
                    'interview_date' => $row['scheduled_date'] ?? null,
                    'interview_time' => $row['scheduled_time'] ?? null,
                    'interview_type' => $row['interview_type'] ?? 'Interview',
                    'interview_status' => strtolower((string)($row['interview_status'] ?? 'completed')),
                    'reviewer' => $row['reviewer_name'] ?? 'Recruitment Team',
                    'feedback_date' => $row['updated_at'] ?? $row['created_at'] ?? null,
                    'recommendation' => $row['recommendation'] ?? 'Pending',
                    'technical_skills' => (int)($row['technical_skills'] ?? 0),
                    'problem_solving' => (int)($row['problem_solving'] ?? 0),
                    'communication' => (int)($row['communication'] ?? 0),
                    'cultural_fit' => (int)($row['cultural_fit'] ?? 0),
                    'experience_relevance' => (int)($row['experience_relevance'] ?? 0),
                    'manager_points' => (int)($row['manager_points'] ?? 0),
                    'total_points' => (int)($row['total_points'] ?? 0),
                    'interview_notes' => $row['interview_notes'] ?? ''
                ];
            }
        }

        $data['stats'] = [
            'total_feedbacks' => count($data['feedbacks']),
            'hire_recommendations' => count(array_filter($data['feedbacks'], fn($item) => ($item['recommendation'] ?? '') === 'Hire')),
            'pending_recommendations' => count(array_filter($data['feedbacks'], fn($item) => ($item['recommendation'] ?? '') === 'Pending'))
        ];

        $this->view('applicant/feedback', $data);
    }
}
