<?php

class ApplicantDatabase extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        // Initialize data array
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Applicants & Applications Management';
        
        // Get the active tab (applicants or applications)
        $data['active_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'applicants';
        
        // Load models
        $userModel = new User();
        $applicationModel = new Application();
        
        // Get all users who have applied for jobs (applicants)
        $query = "SELECT DISTINCT u.* FROM users u 
                  INNER JOIN applications a ON u.id = a.applicant_id 
                  ORDER BY u.created_at DESC";
        $applicantUsers = $userModel->query($query);
        
        // Transform applicant data to match view format
        $data['applicants'] = [];
        if ($applicantUsers) {
            foreach ($applicantUsers as $user) {
                // Get the most recent application for this user
                $recentApplication = $applicationModel->query(
                    "SELECT applied_at FROM applications WHERE applicant_id = ? ORDER BY applied_at DESC LIMIT 1", 
                    [$user['id']]
                );
                
                $data['applicants'][] = [
                    'id' => $user['id'],
                    'name' => $user['full_name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'] ?? 'N/A',
                    'experience' => 'N/A', // This would need to be added to user profile
                    'skills' => [], // This would need to be added to user profile or separate table
                    'location' => $user['address'] ?? 'N/A',
                    'last_application' => $recentApplication ? $recentApplication[0]['applied_at'] : 'Never',
                    'status' => ucfirst($user['status']),
                    'rating' => 0 // This would need to be calculated from reviews/ratings
                ];
            }
        }

        // Get applications data from database with details
        $applications = $applicationModel->getApplicationsWithDetails();
        
        // Transform applications data to match view format
        $data['applications'] = [];
        if ($applications) {
            foreach ($applications as $app) {
                $data['applications'][] = [
                    'id' => $app['id'],
                    'applicant_name' => $app['full_name'],
                    'email' => $app['email'],
                    'phone' => 'N/A', // Would need to join user data for phone
                    'position' => $app['job_title'],
                    'status' => strtolower($app['status']),
                    'applied_date' => date('Y-m-d', strtotime($app['applied_at'])),
                    'experience' => 'N/A', // Would need additional profile data
                    'location' => 'N/A', // Would need additional profile data
                    'source' => 'website',
                    'rating' => 0, // Would need rating system
                    'education' => 'N/A', // Would need additional profile data
                    'skills' => [], // Would need additional profile data
                    'resume_url' => $app['resume_path'] ?? ''
                ];
            }
        }

        // Statistics - calculate from real data
        $data['total_candidates'] = count($data['applicants']);
        $data['active_candidates'] = $userModel->query("SELECT COUNT(DISTINCT u.id) as count FROM users u INNER JOIN applications a ON u.id = a.applicant_id WHERE u.status = 'active'")[0]['count'] ?? 0;
        $data['hired_candidates'] = $applicationModel->query("SELECT COUNT(*) as count FROM applications WHERE status = 'hired'")[0]['count'] ?? 0;
        $data['top_skills'] = 0; // This would need a skills tracking system
        
        $data['total_applications'] = count($data['applications']);
        $data['pending_review'] = $applicationModel->query("SELECT COUNT(*) as count FROM applications WHERE status = 'applied' OR status = 'under review'")[0]['count'] ?? 0;
        $data['shortlisted'] = $applicationModel->query("SELECT COUNT(*) as count FROM applications WHERE status = 'shortlisted'")[0]['count'] ?? 0;
        $data['interviewed'] = $applicationModel->query("SELECT COUNT(*) as count FROM applications WHERE status = 'interviewed' OR status = 'interview scheduled'")[0]['count'] ?? 0;
        
        $this->view('hradmin/applicant-database', $data);
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
}
