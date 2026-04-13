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

        $evaluationModel = new InterviewEvaluation();
        $interview = $evaluationModel->getInterviewForEvaluation((int) $interview_id);

        if (!$interview) {
            redirect('recruitment/interview-schedule');
            return;
        }

        $existingFeedback = $evaluationModel->getFeedbackByInterview((int) $interview_id);

        $data = [];
        $data['page_title'] = 'Conduct Interview';
        $data['interview'] = [
            'id' => $interview['id'],
            'candidate_name' => $interview['candidate_name'],
            'job_title' => $interview['job_title'],
            'date' => $interview['scheduled_date'],
            'time' => $interview['scheduled_time'],
            'duration' => $interview['duration_minutes'],
            'type' => $interview['interview_type'],
            'candidate_email' => $interview['candidate_email'],
            'status' => $interview['status'],
            'resume_url' => !empty($interview['resume_path']) ? ROOT . '/' . ltrim($interview['resume_path'], '/') : '#'
        ];

        $data['evaluation_criteria'] = [
            'technical_skills' => 'Technical Skills',
            'problem_solving' => 'Problem Solving',
            'communication' => 'Communication',
            'cultural_fit' => 'Cultural Fit',
            'experience_relevance' => 'Experience Relevance'
        ];

        $data['existing_feedback'] = $existingFeedback ?: null;

        $this->view('recruitment/conduct-interview', $data);
    }

    public function submit($interview_id = null)
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$interview_id) {
            redirect('recruitment/interview-schedule');
            return;
        }

        if (ob_get_level() > 0) {
            ob_clean();
        }
        header('Content-Type: application/json');

        $evaluationModel = new InterviewEvaluation();
        $interviewModel = new Interview();
        $applicationModel = new Application();

        $interview = $evaluationModel->getInterviewForEvaluation((int) $interview_id);
        if (!$interview) {
            echo json_encode([
                'success' => false,
                'message' => 'Interview not found.'
            ]);
            exit;
        }

        $payload = [
            'technical_skills' => $_POST['technical_skills'] ?? '',
            'problem_solving' => $_POST['problem_solving'] ?? '',
            'communication' => $_POST['communication'] ?? '',
            'cultural_fit' => $_POST['cultural_fit'] ?? '',
            'experience_relevance' => $_POST['experience_relevance'] ?? '',
            'manager_points' => $_POST['manager_points'] ?? '',
            'interview_notes' => $_POST['interview_notes'] ?? '',
            'recommendation' => $_POST['recommendation'] ?? ''
        ];

        if (!$evaluationModel->validateFeedback($payload)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please complete all required fields correctly.',
                'errors' => $evaluationModel->errors
            ]);
            exit;
        }

        $saved = $evaluationModel->saveFeedback((int) $interview_id, $payload, Auth::user_id());
        if (!$saved) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save interview feedback.'
            ]);
            exit;
        }

        $interviewModel->updateInterview((int) $interview_id, ['status' => 'Completed']);
        $applicationModel->update($interview['application_id'], ['status' => 'Interview Completed']);

        $totalPoints = (int) $payload['technical_skills']
            + (int) $payload['problem_solving']
            + (int) $payload['communication']
            + (int) $payload['cultural_fit']
            + (int) $payload['experience_relevance']
            + (int) $payload['manager_points'];

        echo json_encode([
            'success' => true,
            'message' => 'Interview feedback submitted successfully.',
            'total_points' => $totalPoints
        ]);
        exit;
    }
}
