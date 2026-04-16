<?php

class ShortlistCandidates extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $searchName = trim($_GET['name'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $evaluationModel = new InterviewEvaluation();
        $feedbackList = $evaluationModel->listCompletedInterviewFeedback([
            'candidate_name' => $searchName,
            'recommendation' => $status
        ]);

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Shortlist Feedback';
        $data['feedback_list'] = is_array($feedbackList) ? $feedbackList : [];
        $data['filters'] = [
            'name' => $searchName,
            'status' => $status
        ];

        $this->view('recruitment/shortlist-candidates', $data);
    }

    public function getFeedback($id = null)
    {
        Auth::requireRole(3);

        ob_clean();
        header('Content-Type: application/json');

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Feedback ID is required.']);
            exit;
        }

        $evaluationModel = new InterviewEvaluation();
        $feedback = $evaluationModel->getFeedbackById((int) $id);

        if (!$feedback) {
            echo json_encode(['success' => false, 'message' => 'Feedback not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'data' => $feedback]);
        exit;
    }

    public function updateFeedback($id = null)
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('recruitment/shortlist-candidates');
            return;
        }

        ob_clean();
        header('Content-Type: application/json');

        $evaluationModel = new InterviewEvaluation();
        $feedback = $evaluationModel->getFeedbackById((int) $id);

        if (!$feedback) {
            echo json_encode(['success' => false, 'message' => 'Feedback not found.']);
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

        $saved = $evaluationModel->saveFeedback((int) $feedback['interview_id'], $payload, Auth::user_id());
        if (!$saved) {
            echo json_encode(['success' => false, 'message' => 'Failed to update feedback.']);
            exit;
        }

        $interviewModel = new Interview();
        $applicationModel = new Application();
        $interviewData = $interviewModel->getInterviewById((int) $feedback['interview_id']);

        if ($interviewData && !empty($interviewData['application_id'])) {
            $nextApplicationStatus = null;

            if ($payload['recommendation'] === 'Hire') {
                $nextApplicationStatus = 'Offered';
            } elseif ($payload['recommendation'] === 'Reject') {
                $nextApplicationStatus = 'Rejected';
            }

            if ($nextApplicationStatus !== null) {
                $applicationModel->update((int) $interviewData['application_id'], [
                    'status' => $nextApplicationStatus
                ]);
            }
        }

        $totalPoints = (int) $payload['technical_skills']
            + (int) $payload['problem_solving']
            + (int) $payload['communication']
            + (int) $payload['cultural_fit']
            + (int) $payload['experience_relevance']
            + (int) $payload['manager_points'];

        echo json_encode([
            'success' => true,
            'message' => 'Feedback updated successfully.',
            'total_points' => $totalPoints
        ]);
        exit;
    }

    public function deleteFeedback($id = null)
    {
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            redirect('recruitment/shortlist-candidates');
            return;
        }

        ob_clean();
        header('Content-Type: application/json');

        $evaluationModel = new InterviewEvaluation();
        $feedback = $evaluationModel->getFeedbackById((int) $id);

        if (!$feedback) {
            echo json_encode(['success' => false, 'message' => 'Feedback not found.']);
            exit;
        }

        $deleted = $evaluationModel->softDeleteFeedback((int) $id, Auth::user_id());

        if (!$deleted) {
            echo json_encode(['success' => false, 'message' => 'Failed to delete feedback.']);
            exit;
        }

        echo json_encode(['success' => true, 'message' => 'Feedback removed successfully.']);
        exit;
    }
}
