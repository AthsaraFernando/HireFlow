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
                if ($interviewModel->createInterview($postData)) {
                    $data['success'] = 'Interview scheduled successfully!';
                } else {
                    $data['errors'][] = 'Failed to schedule interview. Please try again.';
                }
            } else {
                $data['errors'] = $interviewModel->errors;
            }
        }
        
        // Get real interview data from database
        $interviews = $interviewModel->getInterviewsForRecruitment();
        
        // Transform interview data to match view format
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
                    'location' => $interview['location'] ?? $interview['meeting_link'] ?? 'TBD'
                ];
            }
        }
        
        // Get available candidates for scheduling interviews
        $data['available_candidates'] = $interviewModel->getAvailableCandidates();
        
        // Get potential interviewers (HR admins and other staff)
        $data['interviewers'] = $userModel->query("SELECT id, full_name FROM users WHERE role_id IN (2, 3) AND status = 'active' ORDER BY full_name");
        
        // Calculate statistics for the dashboard from database
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));
        
        // Today's interviews
        $data['interviews_today'] = $interviewModel->query("SELECT COUNT(*) as count FROM interviews WHERE DATE(scheduled_date) = ?", [$today])[0]['count'] ?? 0;
        
        // This week's interviews
        $data['interviews_this_week'] = $interviewModel->query("SELECT COUNT(*) as count FROM interviews WHERE scheduled_date BETWEEN ? AND ?", [$weekStart, $weekEnd])[0]['count'] ?? 0;
        
        // Pending interviews
        $data['interviews_pending'] = $interviewModel->query("SELECT COUNT(*) as count FROM interviews WHERE status = 'Pending' OR status = 'Scheduled'")[0]['count'] ?? 0;
        
        // Keep existing statistics for backward compatibility
        $allInterviews = $interviews ?? [];
        $data['total_interviews'] = count($allInterviews);
        $data['upcoming_interviews'] = count(array_filter($allInterviews, function($int) {
            return $int['status'] === 'Scheduled' && strtotime($int['scheduled_date']) >= strtotime('today');
        }));
        $data['completed_interviews'] = count(array_filter($allInterviews, function($int) {
            return $int['status'] === 'Completed';
        }));
        $data['avg_rating'] = '4.2'; // This would need a rating system
        
        $this->view('hradmin/interview-schedule', $data);
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
