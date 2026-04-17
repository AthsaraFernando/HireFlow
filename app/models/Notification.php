<?php

class Notification
{
    use Model;

    protected $table = 'notifications';
    protected $allowedColumns = [
        'user_id',
        'title',
        'message',
        'type'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['user_id'])) {
            $this->errors['user_id'] = "User ID is required";
        }

        if (empty($data['title'])) {
            $this->errors['title'] = "Notification title is required";
        }

        if (empty($data['message'])) {
            $this->errors['message'] = "Notification message is required";
        }

        return empty($this->errors);
    }

    public function getUserNotifications($user_id, $limit = 10)
    {
        $limit = max(1, (int)$limit);

        $query = "SELECT * FROM notifications
                  WHERE user_id = ?
                  AND is_deleted = 0
                  ORDER BY created_at DESC
                  LIMIT $limit";

        return $this->query($query, [$user_id]);
    }

    public function markAsRead($notification_id)
    {
        $query = "UPDATE notifications
                  SET is_read = 1
                  WHERE id = ?";

        return $this->query($query, [$notification_id]);
    }

    public function getUnreadCount($user_id)
    {
        $query = "SELECT COUNT(*) as unread_count FROM notifications
                  WHERE user_id = ? AND is_read = 0 AND is_deleted = 0";

        $result = $this->get_row($query, [$user_id]);
        return $result ? (int)$result['unread_count'] : 0;
    }

    public function markAsReadForUser($notification_id, $user_id)
    {
        $query = "UPDATE notifications
                  SET is_read = 1
                  WHERE id = ? AND user_id = ? AND is_deleted = 0";

        return $this->query($query, [$notification_id, $user_id]);
    }

    public function deleteForUser($notification_id, $user_id)
    {
        $query = "UPDATE notifications
                  SET is_deleted = 1
                  WHERE id = ? AND user_id = ? AND is_deleted = 0";
        return $this->query($query, [$notification_id, $user_id]);
    }

    public function createForApplicant($user_id, $title, $message, $type = 'info')
    {
        $payload = [
            'user_id' => (int)$user_id,
            'title' => trim((string)$title),
            'message' => trim((string)$message),
            'type' => in_array($type, ['info', 'success', 'warning', 'error'], true) ? $type : 'info'
        ];

        if ($payload['user_id'] < 1 || $payload['title'] === '' || $payload['message'] === '') {
            return false;
        }

        if ($this->notificationExists($payload['user_id'], $payload['title'], $payload['message'])) {
            return true;
        }

        $inserted = $this->insert($payload) !== false;
        if (!$inserted) {
            return false;
        }

        $this->sendNotificationEmail(
            $payload['user_id'],
            $payload['title'],
            $payload['message'],
            $payload['type']
        );

        return true;
    }

    public function createForApplication($application_id, $title, $message, $type = 'info')
    {
        $query = "SELECT applicant_id FROM applications WHERE id = ? LIMIT 1";
        $row = $this->get_row($query, [$application_id]);

        if (!$row || empty($row['applicant_id'])) {
            return false;
        }

        return $this->createForApplicant((int)$row['applicant_id'], $title, $message, $type);
    }

    public function createForInterview($interview_id, $title, $message, $type = 'info')
    {
        $query = "SELECT a.applicant_id
                  FROM interviews i
                  JOIN applications a ON a.id = i.application_id
                  WHERE i.id = ?
                  LIMIT 1";
        $row = $this->get_row($query, [$interview_id]);

        if (!$row || empty($row['applicant_id'])) {
            return false;
        }

        return $this->createForApplicant((int)$row['applicant_id'], $title, $message, $type);
    }

    public function syncApplicantNotifications($user_id)
    {
        $candidates = $this->getApplicantNotificationCandidates($user_id);
        if (!$candidates || !is_array($candidates)) {
            return;
        }

        foreach ($candidates as $candidate) {
            $title = trim((string)($candidate['title'] ?? ''));
            $message = trim((string)($candidate['message'] ?? ''));
            $type = trim((string)($candidate['type'] ?? 'info'));

            if ($title === '' || $message === '') {
                continue;
            }

            if (!$this->notificationExists($user_id, $title, $message)) {
                $this->insert([
                    'user_id' => $user_id,
                    'title' => $title,
                    'message' => $message,
                    'type' => in_array($type, ['info', 'success', 'warning', 'error'], true) ? $type : 'info'
                ]);
            }
        }
    }

    private function notificationExists($user_id, $title, $message)
    {
        $query = "SELECT id
                  FROM notifications
                  WHERE user_id = ? AND title = ? AND message = ?
                  LIMIT 1";

        $row = $this->get_row($query, [$user_id, $title, $message]);
        return !empty($row);
    }

    private function getApplicantNotificationCandidates($user_id)
    {
        $query = "SELECT * FROM (
                    SELECT
                        CASE i.status
                            WHEN 'Scheduled' THEN 'Interview Scheduled'
                            WHEN 'Rescheduled' THEN 'Interview Rescheduled'
                            WHEN 'Canceled' THEN 'Interview Canceled'
                            ELSE 'Interview Update'
                        END AS title,
                        CASE i.status
                            WHEN 'Scheduled' THEN CONCAT('Your interview for ', jp.title, ' is scheduled for ', DATE_FORMAT(i.scheduled_date, '%M %e, %Y'), ' at ', DATE_FORMAT(i.scheduled_time, '%h:%i %p'), '.')
                            WHEN 'Rescheduled' THEN CONCAT('Your interview for ', jp.title, ' has been rescheduled to ', DATE_FORMAT(i.scheduled_date, '%M %e, %Y'), ' at ', DATE_FORMAT(i.scheduled_time, '%h:%i %p'), '.')
                            WHEN 'Canceled' THEN CONCAT('Your interview for ', jp.title, ' has been canceled.')
                            ELSE CONCAT('There is an update for your interview for ', jp.title, '.')
                        END AS message,
                        CASE i.status
                            WHEN 'Canceled' THEN 'warning'
                            WHEN 'Rescheduled' THEN 'info'
                            ELSE 'success'
                        END AS type
                    FROM interviews i
                    JOIN applications a ON a.id = i.application_id
                    JOIN job_posts jp ON jp.id = a.job_id
                    WHERE a.applicant_id = ?
                    AND i.status IN ('Scheduled', 'Rescheduled', 'Canceled')

                    UNION ALL

                    SELECT
                        CASE ie.recommendation
                            WHEN 'Hire' THEN 'Interview Feedback: Hire'
                            WHEN 'Reject' THEN 'Interview Feedback: Reject'
                            ELSE 'Interview Feedback Update'
                        END AS title,
                        CASE ie.recommendation
                            WHEN 'Hire' THEN CONCAT('Your interview feedback for ', jp.title, ' recommends you for hire.')
                            WHEN 'Reject' THEN CONCAT('Your interview feedback for ', jp.title, ' recommends rejection.')
                            ELSE CONCAT('Your interview feedback for ', jp.title, ' has been updated.')
                        END AS message,
                        CASE ie.recommendation
                            WHEN 'Hire' THEN 'success'
                            WHEN 'Reject' THEN 'error'
                            ELSE 'info'
                        END AS type
                    FROM interview_evaluations ie
                    JOIN interviews i ON i.id = ie.interview_id
                    JOIN applications a ON a.id = i.application_id
                    JOIN job_posts jp ON jp.id = a.job_id
                    WHERE a.applicant_id = ?
                    AND ie.is_deleted = 0
                    AND ie.recommendation IN ('Hire', 'Reject')
                ) applicant_notifications
                ORDER BY title ASC, message ASC";

        return $this->query($query, [$user_id, $user_id]);
    }

    private function sendNotificationEmail($user_id, $title, $message, $type)
    {
        try {
            $user = $this->get_row(
                "SELECT full_name, email FROM users WHERE id = ? LIMIT 1",
                [(int)$user_id]
            );

            if (!$user || empty($user['email'])) {
                return;
            }

            $displayType = ucfirst((string)$type);
            $safeTitle = htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8');
            $safeMessage = nl2br(htmlspecialchars((string)$message, ENT_QUOTES, 'UTF-8'));
            $notificationsUrl = rtrim(ROOT, '/') . '/applicant/notifications';

            $subject = 'HireFlow Notification: ' . (string)$title;
            $htmlBody = '
                <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937;">
                    <h2 style="margin: 0 0 12px;">You have a new HireFlow update</h2>
                    <p style="margin: 0 0 10px;"><strong>' . $safeTitle . '</strong></p>
                    <p style="margin: 0 0 10px;">' . $safeMessage . '</p>
                    <p style="margin: 0 0 16px;">Type: <strong>' . htmlspecialchars($displayType, ENT_QUOTES, 'UTF-8') . '</strong></p>
                    <p style="margin: 0 0 18px;">
                        <a href="' . htmlspecialchars($notificationsUrl, ENT_QUOTES, 'UTF-8') . '" style="background: #111827; color: #ffffff; text-decoration: none; padding: 10px 14px; border-radius: 6px; display: inline-block;">View Notifications</a>
                    </p>
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">This is an automated email from HireFlow.</p>
                </div>
            ';

            $textBody = "You have a new HireFlow update\n\n"
                . $title . "\n"
                . $message . "\n\n"
                . 'Type: ' . $displayType . "\n"
                . 'View notifications: ' . $notificationsUrl;

            Mailer::send(
                (string)$user['email'],
                $subject,
                $htmlBody,
                (string)($user['full_name'] ?? ''),
                $textBody
            );
        } catch (Throwable $e) {
            error_log('Notification email skipped: ' . $e->getMessage());
        }
    }
}
