<?php

class HrDashboard
{
    use Model;

    protected $table = 'job_posts';

    public function getSummaryMetrics()
    {
        $result = $this->get_row(
            "SELECT
                (SELECT COUNT(*) FROM job_posts) AS total_jobs,
                (SELECT COUNT(*) FROM job_posts WHERE status IN ('Open', 'Active')) AS active_jobs,
                (SELECT COUNT(*) FROM applications) AS total_applications,
                (SELECT COUNT(*) FROM applications WHERE status IN ('Applied', 'Under Review')) AS pending_applications,
                (SELECT COUNT(*) FROM interviews WHERE status IN ('Scheduled', 'Pending', 'Rescheduled') AND scheduled_date >= CURDATE()) AS scheduled_interviews,
                (SELECT COUNT(*) FROM users WHERE role_id = 4 AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)) AS new_applicants"
        );

        return $result ?: [
            'total_jobs' => 0,
            'active_jobs' => 0,
            'total_applications' => 0,
            'pending_applications' => 0,
            'scheduled_interviews' => 0,
            'new_applicants' => 0,
        ];
    }

    public function getRecentApplications($limit = 5)
    {
        $limit = max(1, (int)$limit);

        $rows = $this->query(
            "SELECT
                u.full_name AS name,
                jp.title AS position,
                a.applied_at
             FROM applications a
             JOIN users u ON u.id = a.applicant_id
             JOIN job_posts jp ON jp.id = a.job_id
             ORDER BY a.applied_at DESC
             LIMIT {$limit}"
        );

        foreach ($rows as &$row) {
            $row['time'] = $this->formatTimeAgo($row['applied_at'] ?? null);
        }

        return $rows;
    }

    public function getActiveJobPosts($limit = 5)
    {
        $limit = max(1, (int)$limit);

        return $this->query(
            "SELECT
                jp.id,
                jp.title,
                COALESCE(NULLIF(jp.department, ''), 'General') AS department,
                jp.status,
                COUNT(a.id) AS applications_count
             FROM job_posts jp
             LEFT JOIN applications a ON a.job_id = jp.id
             WHERE jp.status IN ('Open', 'Active')
             GROUP BY jp.id, jp.title, jp.department, jp.status
             ORDER BY jp.created_at DESC
             LIMIT {$limit}"
        );
    }

    public function getUpcomingInterviews($limit = 5)
    {
        $limit = max(1, (int)$limit);

        return $this->query(
            "SELECT
                i.id,
                i.scheduled_date,
                i.scheduled_time,
                u.full_name AS candidate,
                jp.title AS position
             FROM interviews i
             JOIN applications a ON a.id = i.application_id
             JOIN users u ON u.id = a.applicant_id
             JOIN job_posts jp ON jp.id = a.job_id
             WHERE i.status IN ('Scheduled', 'Pending', 'Rescheduled')
               AND i.scheduled_date >= CURDATE()
             ORDER BY i.scheduled_date ASC, i.scheduled_time ASC
             LIMIT {$limit}"
        );
    }

    public function getQuickStats()
    {
        $stats = $this->get_row(
            "SELECT
                (SELECT COUNT(*) FROM applications WHERE DATE(applied_at) = CURDATE()) AS applications_today,
                (SELECT COUNT(*) FROM applications WHERE status IN ('Applied', 'Under Review')) AS pending_reviews,
                (SELECT COUNT(*) FROM interviews WHERE status IN ('Scheduled', 'Pending', 'Rescheduled') AND YEARWEEK(scheduled_date, 1) = YEARWEEK(CURDATE(), 1)) AS interviews_this_week,
                (SELECT COUNT(*) FROM applications WHERE status = 'Offered') AS offers_extended,
                ROUND(AVG(CASE WHEN status = 'Hired' THEN DATEDIFF(CURDATE(), DATE(applied_at)) END), 0) AS avg_time_to_hire_days
             FROM applications"
        );

        return $stats ?: [
            'applications_today' => 0,
            'pending_reviews' => 0,
            'interviews_this_week' => 0,
            'offers_extended' => 0,
            'avg_time_to_hire_days' => 0,
        ];
    }

    public function getDashboardData()
    {
        return [
            'summary' => $this->getSummaryMetrics(),
            'recent_applications' => $this->getRecentApplications(5),
            'active_job_posts' => $this->getActiveJobPosts(5),
            'upcoming_interviews' => $this->getUpcomingInterviews(5),
            'quick_stats' => $this->getQuickStats(),
        ];
    }

    private function formatTimeAgo($datetime)
    {
        if (empty($datetime)) {
            return 'Just now';
        }

        $timestamp = strtotime((string)$datetime);
        if ($timestamp === false) {
            return 'Just now';
        }

        $seconds = time() - $timestamp;
        if ($seconds < 60) {
            return 'Just now';
        }

        $minutes = floor($seconds / 60);
        if ($minutes < 60) {
            return $minutes . ' minute' . ($minutes === 1 ? '' : 's') . ' ago';
        }

        $hours = floor($minutes / 60);
        if ($hours < 24) {
            return $hours . ' hour' . ($hours === 1 ? '' : 's') . ' ago';
        }

        $days = floor($hours / 24);
        return $days . ' day' . ($days === 1 ? '' : 's') . ' ago';
    }
}
