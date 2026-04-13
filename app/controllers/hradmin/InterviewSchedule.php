<?php

class InterviewSchedule extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        // Initialize data array
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Interview Schedule';
        
        // Load models
        $interviewModel = new Interview();
        $userModel = new User();
        
        // Handle interview scheduling form submission
        if ($_POST) {
            $postData = $_POST;
            
            if ($interviewModel->validate($postData)) {
                $result = $interviewModel->createInterview($postData);
                if ($result) {
                    redirect('hradmin/interview-schedule?success=Interview scheduled successfully!');
                } else {
                    $data['errors'][] = 'Failed to schedule interview. Please try again.';
                    // Add model errors if any
                    if (!empty($interviewModel->errors)) {
                        $data['errors'] = array_merge($data['errors'], $interviewModel->errors);
                    }
                }
            } else {
                $data['errors'] = $interviewModel->errors;
            }
        }
        
        // Check for success message from redirect
        if (isset($_GET['success'])) {
            $data['success'] = urldecode($_GET['success']);
        }
        
        // Get current week start and end for calendar display
        $currentWeekStart = isset($_GET['week_start']) ? $_GET['week_start'] : date('Y-m-d', strtotime('monday this week'));
        $currentWeekEnd = date('Y-m-d', strtotime($currentWeekStart . ' +6 days'));
        
        // Store week dates for calendar navigation
        $data['current_week_start'] = $currentWeekStart;
        $data['current_week_end'] = $currentWeekEnd;
        $data['week_title'] = date('F j', strtotime($currentWeekStart)) . ' - ' . date('j, Y', strtotime($currentWeekEnd));
        
        // Get week days for calendar headers (Monday to Sunday)
        $data['week_days'] = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime($currentWeekStart . " +{$i} days"));
            $dayOfWeek = date('N', strtotime($date)); // 1=Monday, 7=Sunday
            $data['week_days'][] = [
                'date' => $date,
                'day_name' => date('D', strtotime($date)),
                'day_number' => date('j', strtotime($date)),
                'is_today' => ($date === date('Y-m-d')),
                'is_weekend' => ($dayOfWeek >= 6) // Saturday=6, Sunday=7
            ];
        }
        
        // Get detailed calendar interviews using enhanced method
        $data['calendar_interviews'] = $interviewModel->getCalendarInterviews($currentWeekStart, $currentWeekEnd);
        
        // Get interview statistics for dashboard - always use current week, not calendar view week
        // Stats should always reflect the actual current week regardless of calendar navigation
        $actualCurrentWeekStart = date('Y-m-d', strtotime('monday this week'));
        $actualCurrentWeekEnd = date('Y-m-d', strtotime('sunday this week'));
        $stats = $interviewModel->getInterviewStats($actualCurrentWeekStart, $actualCurrentWeekEnd);
        $data['interviews_today'] = $stats['today_interviews'] ?? 0;
        $data['interviews_week'] = $stats['week_interviews'] ?? 0;
        $data['interviews_pending'] = $stats['pending_interviews'] ?? 0;
        $data['interviews_completed'] = $stats['completed_interviews'] ?? 0;
        $data['avg_rating'] = number_format($stats['avg_rating'] ?? 0, 1);
        
        // Legacy data for backward compatibility
        $interviews = $interviewModel->getInterviewsForRecruitment();
        $data['interviews'] = [];
        if ($interviews) {
            foreach ($interviews as $interview) {
                $data['interviews'][] = [
                    'id' => $interview['id'],
                    'applicant_name' => $interview['candidate_name'],
                    'position' => $interview['job_title'],
                    'interviewer' => $interview['interviewer_name'] ?? 'TBD',
                    'date' => $interview['scheduled_date'],
                    'time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'type' => $interview['interview_type'],
                    'status' => $interview['status'],
                    'location' => $interview['location'] ?? $interview['meeting_link'] ?? 'TBD',
                    'interview_stage' => $interview['interview_stage'] ?? 'Screening',
                    'interviewer_role' => $interview['interviewer_role'] ?? 'HR Admin',
                    'duration_minutes' => $interview['duration_minutes'] ?? 60
                ];
            }
        }
        
        // Organize interviews by date for calendar display
        $data['interviews_by_date'] = [];
        if ($data['calendar_interviews']) {
            foreach ($data['calendar_interviews'] as $interview) {
                $interviewDate = $interview['scheduled_date'];
                
                if (!isset($data['interviews_by_date'][$interviewDate])) {
                    $data['interviews_by_date'][$interviewDate] = [];
                }
                
                // Calculate position for calendar block
                $timeObj = new DateTime($interview['scheduled_time']);
                $hour = (int)$timeObj->format('G');
                $minute = (int)$timeObj->format('i');
                
                // Calculate top position (8 AM = 0, each hour = 60px)
                $topPosition = ($hour - 8) * 60 + ($minute);
                
                // Calculate height based on duration
                $duration = $interview['duration_minutes'] ?? 60;
                $height = ($duration / 60) * 60; // 60px per hour
                
                $data['interviews_by_date'][$interviewDate][] = [
                    'id' => $interview['id'],
                    'candidate_name' => $interview['candidate_name'],
                    'job_title' => $interview['job_title'],
                    'interviewer_name' => $interview['interviewer_name'] ?? 'TBD',
                    'scheduled_time' => $interview['scheduled_time'],
                    'display_time' => date('g:i A', strtotime($interview['scheduled_time'])),
                    'duration_minutes' => $interview['duration_minutes'] ?? 60,
                    'interview_type' => $interview['interview_type'],
                    'interview_stage' => $interview['interview_stage'] ?? 'Screening',
                    'interviewer_role' => $interview['interviewer_role'] ?? 'HR Admin',
                    'status' => $interview['status'],
                    'location' => $interview['location'] ?? $interview['meeting_link'] ?? 'TBD',
                    'top_position' => max(0, $topPosition),
                    'height' => $height
                ];
            }
        }
        
        // Get form data for scheduling
        $data['available_candidates'] = $interviewModel->getAvailableCandidates();
        $data['interviewers'] = $userModel->query("SELECT id, full_name FROM users WHERE role_id IN (2, 3) AND status = 'active' ORDER BY full_name");
        $data['interviewer_roles'] = $interviewModel->getInterviewerRoles();
        $data['interview_stages'] = $interviewModel->getInterviewStages();
        $data['interviewers_by_role'] = $interviewModel->getInterviewersByRole();
        
        // Use enhanced view
        $this->view('hradmin/enhanced-interview-schedule', $data);
    }

    /**
     * Get interview details via AJAX
     */
    public function details()
    {
        Auth::requireRole(2);
        
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Interview ID required']);
            return;
        }
        
        $interviewModel = new Interview();
        $interviewDetails = $interviewModel->getInterviewDetails($_GET['id']);
        
        if (!$interviewDetails) {
            http_response_code(404);
            echo json_encode(['error' => 'Interview not found']);
            return;
        }
        
        header('Content-Type: application/json');
        echo json_encode($interviewDetails);
    }
    
    public function schedule()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $data['page_title'] = 'Schedule Interview';
        
        // Load models
        $interviewModel = new Interview();
        $userModel = new User();
        
        // Get available candidates and interviewers for the form
        $data['available_candidates'] = $interviewModel->getAvailableCandidates();
        $data['interviewers'] = $userModel->query("SELECT id, full_name FROM users WHERE role_id IN (2, 3) AND status = 'active' ORDER BY full_name");
        
        // Get interviewer roles and interview stages for the form
        $data['interviewer_roles'] = $interviewModel->getInterviewerRoles();
        $data['interview_stages'] = $interviewModel->getInterviewStages();
        $data['interviewers_by_role'] = $interviewModel->getInterviewersByRole();
        
        if ($_POST) {
            $postData = $_POST;
            
            if ($interviewModel->validate($postData)) {
                if ($interviewModel->createInterview($postData)) {
                    redirect('hradmin/interview-schedule?success=Interview scheduled successfully!');
                } else {
                    $data['errors'][] = 'Failed to schedule interview. Please try again.';
                }
            } else {
                $data['errors'] = $interviewModel->errors;
            }
        }
        
        $this->view('hradmin/schedule-interview', $data);
    }
}
