<?php

class InterviewEvaluation
{
    use Model;

    protected $table = 'interview_evaluations';

    protected $allowedColumns = [
        'interview_id',
        'technical_skills',
        'problem_solving',
        'communication',
        'cultural_fit',
        'experience_relevance',
        'manager_points',
        'interview_notes',
        'recommendation',
        'created_by',
        'updated_by',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function validateFeedback($data)
    {
        $this->errors = [];

        $requiredScoreFields = [
            'technical_skills',
            'problem_solving',
            'communication',
            'cultural_fit',
            'experience_relevance'
        ];

        foreach ($requiredScoreFields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                $this->errors[$field] = 'This field is required';
                continue;
            }

            $value = (int) $data[$field];
            if ($value < 1 || $value > 10) {
                $this->errors[$field] = 'Score must be between 1 and 10';
            }
        }

        if (!isset($data['manager_points']) || $data['manager_points'] === '') {
            $this->errors['manager_points'] = 'Manager points is required';
        } else {
            $managerPoints = (int) $data['manager_points'];
            if ($managerPoints < 0 || $managerPoints > 50) {
                $this->errors['manager_points'] = 'Manager points must be between 0 and 50';
            }
        }

        $allowedRecommendations = ['Hire', 'Reject', 'Pending'];
        if (empty($data['recommendation']) || !in_array($data['recommendation'], $allowedRecommendations, true)) {
            $this->errors['recommendation'] = 'Recommendation is required';
        }

        return empty($this->errors);
    }

    public function getInterviewForEvaluation($interviewId)
    {
        $query = "SELECT i.id,
                         i.application_id,
                         i.scheduled_date,
                         i.scheduled_time,
                         i.duration_minutes,
                         i.interview_type,
                         i.location,
                         i.meeting_link,
                         i.status,
                         a.applicant_id,
                         a.resume_path,
                         u.full_name as candidate_name,
                         u.email as candidate_email,
                         jp.title as job_title
                  FROM interviews i
                  JOIN applications a ON a.id = i.application_id
                  JOIN users u ON u.id = a.applicant_id
                  JOIN job_posts jp ON jp.id = a.job_id
                  WHERE i.id = :interview_id
                  LIMIT 1";

        return $this->get_row($query, ['interview_id' => $interviewId]);
    }

    public function getFeedbackByInterview($interviewId)
    {
        return $this->first([
            'interview_id' => $interviewId,
            'is_deleted' => 0
        ]);
    }

    public function saveFeedback($interviewId, $data, $userId)
    {
        $existing = $this->first([
            'interview_id' => $interviewId,
            'is_deleted' => 0
        ]);

        $payload = [
            'technical_skills' => (int) $data['technical_skills'],
            'problem_solving' => (int) $data['problem_solving'],
            'communication' => (int) $data['communication'],
            'cultural_fit' => (int) $data['cultural_fit'],
            'experience_relevance' => (int) $data['experience_relevance'],
            'manager_points' => (int) $data['manager_points'],
            'interview_notes' => trim((string) ($data['interview_notes'] ?? '')),
            'recommendation' => $data['recommendation'],
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            return $this->update($existing['id'], $payload);
        }

        $payload['interview_id'] = (int) $interviewId;
        $payload['created_by'] = $userId;
        $payload['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($payload);
    }

    public function listCompletedInterviewFeedback($filters = [])
    {
        $query = "SELECT ie.id,
                         ie.interview_id,
                         ie.technical_skills,
                         ie.problem_solving,
                         ie.communication,
                         ie.cultural_fit,
                         ie.experience_relevance,
                         ie.manager_points,
                         ie.interview_notes,
                         ie.recommendation,
                         ie.created_at,
                         ie.updated_at,
                         i.status as interview_status,
                         i.scheduled_date,
                         i.scheduled_time,
                         u.full_name as candidate_name,
                         u.email as candidate_email,
                         jp.title as job_title,
                         (ie.technical_skills + ie.problem_solving + ie.communication + ie.cultural_fit + ie.experience_relevance + ie.manager_points) AS total_points
                  FROM interview_evaluations ie
                  JOIN interviews i ON i.id = ie.interview_id
                  JOIN applications a ON a.id = i.application_id
                  JOIN users u ON u.id = a.applicant_id
                  JOIN job_posts jp ON jp.id = a.job_id
                  WHERE ie.is_deleted = 0
                  AND i.status = 'Completed'";

        $params = [];

        if (!empty($filters['candidate_name'])) {
            $query .= " AND u.full_name LIKE :candidate_name";
            $params['candidate_name'] = '%' . $filters['candidate_name'] . '%';
        }

        if (!empty($filters['recommendation']) && in_array($filters['recommendation'], ['Hire', 'Reject', 'Pending'], true)) {
            $query .= " AND ie.recommendation = :recommendation";
            $params['recommendation'] = $filters['recommendation'];
        }

        $query .= " ORDER BY ie.updated_at DESC";

        return $this->query($query, $params);
    }

    public function getFeedbackById($id)
    {
        $query = "SELECT ie.id,
                         ie.interview_id,
                         ie.technical_skills,
                         ie.problem_solving,
                         ie.communication,
                         ie.cultural_fit,
                         ie.experience_relevance,
                         ie.manager_points,
                         ie.interview_notes,
                         ie.recommendation,
                         ie.created_at,
                         ie.updated_at,
                         u.full_name as candidate_name,
                         jp.title as job_title,
                         (ie.technical_skills + ie.problem_solving + ie.communication + ie.cultural_fit + ie.experience_relevance + ie.manager_points) AS total_points
                  FROM interview_evaluations ie
                  JOIN interviews i ON i.id = ie.interview_id
                  JOIN applications a ON a.id = i.application_id
                  JOIN users u ON u.id = a.applicant_id
                  JOIN job_posts jp ON jp.id = a.job_id
                  WHERE ie.id = :id
                  AND ie.is_deleted = 0
                  LIMIT 1";

        return $this->get_row($query, ['id' => $id]);
    }

    public function softDeleteFeedback($id, $userId)
    {
        return $this->update($id, [
            'is_deleted' => 1,
            'deleted_by' => $userId,
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_by' => $userId,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getFeedbackForApplicant($applicantId)
    {
        $query = "SELECT ie.id,
                         ie.interview_id,
                         ie.technical_skills,
                         ie.problem_solving,
                         ie.communication,
                         ie.cultural_fit,
                         ie.experience_relevance,
                         ie.manager_points,
                         ie.interview_notes,
                         ie.recommendation,
                         ie.created_at,
                         ie.updated_at,
                         i.interview_type,
                         i.status AS interview_status,
                         i.scheduled_date,
                         i.scheduled_time,
                         a.id AS application_id,
                         jp.title AS job_title,
                         reviewer.full_name AS reviewer_name,
                         (ie.technical_skills + ie.problem_solving + ie.communication + ie.cultural_fit + ie.experience_relevance + ie.manager_points) AS total_points
                  FROM interview_evaluations ie
                  JOIN interviews i ON i.id = ie.interview_id
                  JOIN applications a ON a.id = i.application_id
                  JOIN job_posts jp ON jp.id = a.job_id
                  LEFT JOIN users reviewer ON reviewer.id = ie.updated_by
                  WHERE a.applicant_id = :applicant_id
                  AND ie.is_deleted = 0
                  ORDER BY ie.updated_at DESC";

        return $this->query($query, ['applicant_id' => $applicantId]);
    }
}
