<?php

class Dashboard extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Recruitment Dashboard';

        $application = new Application();
        $interview = new Interview();

        // Dashboard metrics from real application statuses.
        $metricsQuery = "SELECT
                            SUM(CASE WHEN status = 'Under Review' THEN 1 ELSE 0 END) AS under_review_applications,
                            SUM(CASE WHEN status = 'Shortlisted' THEN 1 ELSE 0 END) AS shortlisted_applications,
                            SUM(CASE WHEN status = 'Interview Scheduled' THEN 1 ELSE 0 END) AS interview_scheduled_applications
                         FROM applications";

        $metricsResult = $application->get_row($metricsQuery);
        $data['metrics'] = [
            'under_review_applications' => isset($metricsResult['under_review_applications']) ? (int)$metricsResult['under_review_applications'] : 0,
            'shortlisted_applications' => isset($metricsResult['shortlisted_applications']) ? (int)$metricsResult['shortlisted_applications'] : 0,
            'interview_scheduled_applications' => isset($metricsResult['interview_scheduled_applications']) ? (int)$metricsResult['interview_scheduled_applications'] : 0,
        ];

        // Upcoming interviews from database (future date/time, not completed/cancelled).
        $upcomingInterviewsQuery = "SELECT
                                        i.id,
                                        u.full_name AS candidate_name,
                                        jp.title AS position,
                                        i.interview_type AS type,
                                        i.status,
                                        CONCAT(i.scheduled_date, ' ', i.scheduled_time) AS scheduled_time
                                    FROM interviews i
                                    JOIN applications a ON i.application_id = a.id
                                    JOIN users u ON a.applicant_id = u.id
                                    JOIN job_posts jp ON a.job_id = jp.id
                                    WHERE CONCAT(i.scheduled_date, ' ', i.scheduled_time) >= NOW()
                                      AND i.status NOT IN ('Completed', 'Cancelled')
                                    ORDER BY i.scheduled_date ASC, i.scheduled_time ASC
                                    LIMIT 8";

        $upcomingInterviews = $interview->query($upcomingInterviewsQuery);
        $data['upcoming_interviews'] = is_array($upcomingInterviews) ? $upcomingInterviews : [];

        $this->view('recruitment/dashboard', $data);
    }
}
