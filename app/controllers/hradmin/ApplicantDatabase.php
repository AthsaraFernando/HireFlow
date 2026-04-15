<?php

class ApplicantDatabase extends Controller
{
    public function index()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Applicants & Applications Management';

        $data['active_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'applicants';

        $liveData = $this->buildLiveData();
        $data = array_merge($data, $liveData);
        
        $this->view('hradmin/applicant-database', $data);
    }

    public function liveData()
    {
        Auth::requireRole(2);

        header('Content-Type: application/json');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

        try {
            $payload = $this->buildLiveData();
            echo json_encode(['success' => true, 'data' => $payload]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Unable to fetch applicant database data']);
        }

        exit;
    }

    public function viewApplication($id = null)
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $data['page_title'] = 'Application Details';
        $data['application_id'] = $id;
        
        // Get real application data from database
        $applicationModel = new Application();
        $application = $applicationModel->getApplicationById($id);
        
        if ($application) {
            $data['application'] = [
                'id' => $application['id'],
                'applicant_name' => $application['full_name'] ?? 'N/A',
                'email' => $application['email'] ?? 'N/A',
                'phone' => 'N/A', // Would need user phone from join
                'position' => $application['job_title'] ?? 'N/A',
                'status' => $application['status'] ?? 'Unknown',
                'applied_date' => date('Y-m-d', strtotime($application['applied_at'] ?? 'now')),
                'experience' => 'N/A', // Would need additional profile data
                'location' => $application['location'] ?? 'N/A',
                'education' => 'N/A', // Would need additional profile data
                'skills' => [], // Would need additional profile data
                'cover_letter' => $application['cover_letter'] ?? 'No cover letter provided.',
                'resume_url' => $application['resume_path'] ?? ''
            ];
        } else {
            $data['application'] = [
                'id' => $id,
                'applicant_name' => 'Application not found',
                'email' => 'N/A',
                'phone' => 'N/A',
                'position' => 'N/A',
                'status' => 'Not Found',
                'applied_date' => 'N/A',
                'experience' => 'N/A',
                'location' => 'N/A',
                'education' => 'N/A',
                'skills' => [],
                'cover_letter' => 'Application not found.',
                'resume_url' => ''
            ];
        }
        
        $this->view('hradmin/view-application', $data);
    }

    private function buildLiveData()
    {
        $userModel = new User();
        $applicationModel = new Application();

        $query = "SELECT
                    u.id,
                    u.full_name,
                    u.email,
                    u.phone,
                    u.address,
                    u.status,
                                        (
                                                SELECT a2.status
                                                FROM applications a2
                                                WHERE a2.applicant_id = u.id
                                                ORDER BY a2.applied_at DESC, a2.id DESC
                                                LIMIT 1
                                        ) AS latest_application_status,
                    MAX(a.applied_at) AS last_application
                  FROM users u
                  INNER JOIN applications a ON u.id = a.applicant_id
                  GROUP BY u.id, u.full_name, u.email, u.phone, u.address, u.status
                  ORDER BY last_application DESC";

        $applicantUsers = $userModel->query($query);

        $applicants = [];
        if ($applicantUsers) {
            foreach ($applicantUsers as $user) {
                $applicants[] = [
                    'id' => (int)$user['id'],
                    'name' => $user['full_name'] ?? 'N/A',
                    'email' => $user['email'] ?? 'N/A',
                    'phone' => $user['phone'] ?? 'N/A',
                    'experience' => 'N/A',
                    'skills' => [],
                    'location' => $user['address'] ?? 'N/A',
                    'last_application' => !empty($user['last_application']) ? date('Y-m-d H:i:s', strtotime((string)$user['last_application'])) : 'Never',
                    'status' => ucfirst((string)($user['status'] ?? 'inactive')),
                    'latest_application_status' => (string)($user['latest_application_status'] ?? 'Applied'),
                    'rating' => 0
                ];
            }
        }

        $rawApplications = $applicationModel->getApplicationsWithDetails();
        $applications = [];
        if ($rawApplications) {
            foreach ($rawApplications as $app) {
                $status = (string)($app['status'] ?? 'Applied');
                $applications[] = [
                    'id' => (int)($app['id'] ?? 0),
                    'applicant_name' => $app['full_name'] ?? 'N/A',
                    'email' => $app['email'] ?? 'N/A',
                    'phone' => $app['phone'] ?? 'N/A',
                    'position' => $app['job_title'] ?? 'N/A',
                    'status' => strtolower(str_replace(' ', '-', $status)),
                    'status_label' => $status,
                    'applied_date' => !empty($app['applied_at']) ? date('Y-m-d', strtotime((string)$app['applied_at'])) : date('Y-m-d'),
                    'experience' => 'N/A',
                    'location' => 'N/A',
                    'source' => 'website',
                    'rating' => 0,
                    'education' => 'N/A',
                    'skills' => [],
                    'resume_url' => $app['resume_path'] ?? ''
                ];
            }
        }

        $activeCandidatesRow = $userModel->get_row(
            "SELECT COUNT(DISTINCT u.id) AS count
             FROM users u
             INNER JOIN applications a ON u.id = a.applicant_id
             WHERE u.status = 'active'"
        );

        $hiredCandidatesRow = $applicationModel->get_row(
            "SELECT COUNT(*) AS count FROM applications WHERE status = 'Hired'"
        );

        $pendingReviewRow = $applicationModel->get_row(
            "SELECT COUNT(*) AS count
             FROM applications
             WHERE status IN ('Applied', 'Under Review')"
        );

        $shortlistedRow = $applicationModel->get_row(
            "SELECT COUNT(*) AS count FROM applications WHERE status = 'Shortlisted'"
        );

        $interviewedRow = $applicationModel->get_row(
            "SELECT COUNT(*) AS count
             FROM applications
             WHERE status IN ('Interview Scheduled', 'Interview Completed')"
        );

        return [
            'applicants' => $applicants,
            'applications' => $applications,
            'total_candidates' => count($applicants),
            'active_candidates' => (int)($activeCandidatesRow['count'] ?? 0),
            'hired_candidates' => (int)($hiredCandidatesRow['count'] ?? 0),
            'top_skills' => 0,
            'total_applications' => count($applications),
            'pending_review' => (int)($pendingReviewRow['count'] ?? 0),
            'shortlisted' => (int)($shortlistedRow['count'] ?? 0),
            'interviewed' => (int)($interviewedRow['count'] ?? 0),
        ];
    }
}
