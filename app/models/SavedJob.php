<?php

class SavedJob
{
    use Model;

    protected $table = 'saved_jobs';
    protected $allowedColumns = [
        'applicant_id',
        'job_id',
        'note',
        'saved_at',
        'updated_at'
    ];

    public function saveJob($applicant_id, $job_id, $note = '')
    {
        $existing = $this->getSavedJobByApplicantAndJob($applicant_id, $job_id);
        $payload = [
            'note' => $note,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            return $this->update($existing['id'], $payload);
        }

        $payload['applicant_id'] = $applicant_id;
        $payload['job_id'] = $job_id;
        $payload['saved_at'] = date('Y-m-d H:i:s');

        return (bool)$this->insert($payload);
    }

    public function getSavedJobByApplicantAndJob($applicant_id, $job_id)
    {
        $query = "SELECT * FROM {$this->table} WHERE applicant_id = ? AND job_id = ? LIMIT 1";
        return $this->get_row($query, [$applicant_id, $job_id]);
    }

    public function isJobSaved($applicant_id, $job_id)
    {
        return (bool)$this->getSavedJobByApplicantAndJob($applicant_id, $job_id);
    }

    public function getSavedJobIdsByApplicant($applicant_id)
    {
        $query = "SELECT job_id FROM {$this->table} WHERE applicant_id = ?";
        $rows = $this->query($query, [$applicant_id]);

        if (!$rows || !is_array($rows)) {
            return [];
        }

        return array_map('intval', array_column($rows, 'job_id'));
    }

    public function getSavedJobsWithDetails($applicant_id)
    {
        $query = "SELECT sj.*, jp.title, jp.location, jp.employment_type, jp.department,
                         jp.salary_range, jp.description, jp.status as job_status, jp.deadline
                  FROM {$this->table} sj
                  INNER JOIN job_posts jp ON jp.id = sj.job_id
                  WHERE sj.applicant_id = ?
                  ORDER BY sj.saved_at DESC";

        return $this->query($query, [$applicant_id]) ?: [];
    }

    public function updateNote($saved_job_id, $applicant_id, $note)
    {
        $query = "UPDATE {$this->table}
                  SET note = :note, updated_at = :updated_at
                  WHERE id = :id AND applicant_id = :applicant_id";

        return $this->query($query, [
            'note' => $note,
            'updated_at' => date('Y-m-d H:i:s'),
            'id' => $saved_job_id,
            'applicant_id' => $applicant_id
        ]);
    }

    public function removeSavedJob($saved_job_id, $applicant_id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id AND applicant_id = :applicant_id";

        return $this->query($query, [
            'id' => $saved_job_id,
            'applicant_id' => $applicant_id
        ]);
    }
}
