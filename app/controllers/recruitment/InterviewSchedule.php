<?php

class InterviewSchedule extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Interview Schedule';
        
        // Fetch shortlisted candidates for interview scheduling
        // Exclude candidates who already have scheduled interviews
        // Only show candidates with role_id = 4 (Applicant) and status = 'Shortlisted'
        $application = new Application();
        $query = "SELECT 
                    a.id as application_id,
                    a.applicant_id,
                    a.job_id,
                    u.full_name as candidate_name,
                    jp.title as job_title,
                    a.resume_path,
                    a.status,
                    a.applied_at
                  FROM applications a
                  JOIN users u ON a.applicant_id = u.id
                  JOIN job_posts jp ON a.job_id = jp.id
                  LEFT JOIN interviews i ON a.id = i.application_id
                  WHERE a.status = 'Shortlisted' 
                  AND u.role_id = 4
                  AND i.id IS NULL
                  ORDER BY a.applied_at DESC";
        
        $result = $application->query($query);
        $data['shortlisted_candidates'] = is_array($result) ? $result : [];
        
        // Fetch all scheduled interviews from database
        $interview = new Interview();
        $interviews = $interview->getInterviewsForRecruitment();
        $data['interviews'] = is_array($interviews) ? $interviews : [];

        // Fetch interviewers (users with recruitment manager or HR admin role)
        $user = new User();
        $interviewers_query = "SELECT id, full_name, email, role_id 
                              FROM users 
                              WHERE role_id IN (2, 3) 
                              AND status = 'active'
                              ORDER BY full_name ASC";
        $interviewers = $user->query($interviewers_query);
        $data['interviewers'] = is_array($interviewers) ? $interviewers : [];

        $this->view('recruitment/interview-schedule', $data);
    }

    
    //Create a new interview
    
    public function create()
    {
        // Require Recruitment Manager role
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Clear any output buffer
            ob_clean();
            header('Content-Type: application/json');
            
            try {
                $interview = new Interview();
                
                // Get POST data
                $application_id = $_POST['application_id'] ?? '';
                $interviewer_id = $_POST['interviewer_id'] ?? '';
                $datetime = $_POST['datetime'] ?? '';
                $duration = $_POST['duration'] ?? 60;
                $interview_type = $_POST['interview_type'] ?? 'Video';
                $location = $_POST['location'] ?? '';
                $meeting_link = $_POST['meeting_link'] ?? '';
                
                // Validate that candidate is selected
                if (empty($application_id)) {
                    echo json_encode(['success' => false, 'message' => 'Please select a candidate']);
                    exit;
                }
                
                // Check if this candidate already has an interview scheduled
                $check_query = "SELECT id FROM interviews WHERE application_id = :application_id";
                $existing = $interview->query($check_query, ['application_id' => $application_id]);
                
                if (!empty($existing) && is_array($existing)) {
                    echo json_encode(['success' => false, 'message' => 'This candidate already has an interview scheduled']);
                    exit;
                }
                
                // Split datetime into date and time
                if ($datetime) {
                    $dt = new DateTime($datetime);
                    $scheduled_date = $dt->format('Y-m-d');
                    $scheduled_time = $dt->format('H:i:s');
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid date/time']);
                    exit;
                }
                
                // Prepare interview data
                $interviewData = [
                    'application_id' => $application_id,
                    'interviewer_id' => $interviewer_id,
                    'interview_type' => $interview_type,
                    'scheduled_date' => $scheduled_date,
                    'scheduled_time' => $scheduled_time,
                    'duration_minutes' => $duration,
                    'location' => $location,
                    'meeting_link' => $meeting_link,
                    'status' => 'Pending'
                ];
                
                // Validate and create interview
                if ($interview->validate($interviewData)) {
                    $result = $interview->createInterview($interviewData);
                    
                    if ($result) {
                        // Update application status to 'Interview Scheduled'
                        $application = new Application();
                        $statusUpdated = $application->update($application_id, ['status' => 'Interview Scheduled']);

                        if ($statusUpdated) {
                            echo json_encode(['success' => true, 'message' => 'Interview scheduled successfully']);
                        } else {
                            $errorMessage = 'Interview was created, but application status update failed.';
                            if (!empty($application->errors)) {
                                $errorMessage .= ' ' . implode(' | ', $application->errors);
                            }
                            echo json_encode(['success' => false, 'message' => $errorMessage]);
                        }
                    } else {
                        $errorMessage = 'Failed to schedule interview.';
                        if (!empty($interview->errors)) {
                            $errorMessage .= ' ' . implode(' | ', $interview->errors);
                        }
                        echo json_encode(['success' => false, 'message' => $errorMessage]);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Validation failed', 'errors' => $interview->errors]);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
            }
            exit;
        }
    }

    
    //Get interview details for editing
     
    public function get($id)
    {
        // Require Recruitment Manager role
        Auth::requireRole(3);

        ob_clean();
        header('Content-Type: application/json');
        
        try {
            $interview = new Interview();
            $interviewData = $interview->getInterviewById($id);
            
            if ($interviewData) {
                echo json_encode(['success' => true, 'data' => $interviewData]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Interview not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
        exit;
    }

    /**
     * Update an existing interview
     */
    public function update($id)
    {
        // Require Recruitment Manager role
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_clean();
            header('Content-Type: application/json');
            
            try {
                $interview = new Interview();
                
                // Get POST data
                $interviewer_id = $_POST['interviewer_id'] ?? '';
                $datetime = $_POST['datetime'] ?? '';
                $duration = $_POST['duration'] ?? 60;
                $interview_type = $_POST['interview_type'] ?? 'Video';
                $location = $_POST['location'] ?? '';
                $meeting_link = $_POST['meeting_link'] ?? '';
                
                // Split datetime into date and time
                if ($datetime) {
                    $dt = new DateTime($datetime);
                    $scheduled_date = $dt->format('Y-m-d');
                    $scheduled_time = $dt->format('H:i:s');
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid date/time']);
                    exit;
                }
                
                // Prepare update data
                $updateData = [
                    'interviewer_id' => $interviewer_id,
                    'interview_type' => $interview_type,
                    'scheduled_date' => $scheduled_date,
                    'scheduled_time' => $scheduled_time,
                    'duration_minutes' => $duration,
                    'location' => $location,
                    'meeting_link' => $meeting_link,
                    'status' => 'Rescheduled'
                ];
                
                // Update interview
                $result = $interview->updateInterview($id, $updateData);
                
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Interview rescheduled successfully']);
                } else {
                    $errorMessage = 'Failed to reschedule interview.';
                    if (!empty($interview->errors)) {
                        $errorMessage .= ' ' . implode(' | ', $interview->errors);
                    }
                    echo json_encode(['success' => false, 'message' => $errorMessage]);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
            }
            exit;
        }
    }

    
    //Delete an interview
    
    public function delete($id)
    {
        // Require Recruitment Manager role
        Auth::requireRole(3);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_clean();
            header('Content-Type: application/json');
            
            try {
                $interview = new Interview();
                
                // Get interview details to update application status
                $interviewData = $interview->getInterviewById($id);
                
                if ($interviewData) {
                    // Delete the interview
                    $result = $interview->deleteInterview($id);
                    
                    if ($result) {
                        // Update application status back to 'Shortlisted'
                        $application = new Application();
                        $application->update($interviewData['application_id'], ['status' => 'Shortlisted']);
                        
                        echo json_encode(['success' => true, 'message' => 'Interview deleted successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to delete interview']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Interview not found']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
            }
            exit;
        }
    }
}
