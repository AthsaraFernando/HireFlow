<?php

class Notifications extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);

        $data = [];
        $data['page_title'] = 'Notifications';
        
        $data['notifications'] = [
            [
                'id' => 1,
                'type' => 'new_application',
                'title' => 'New Application Received',
                'message' => 'John Smith applied for Senior Software Developer position',
                'time' => '2 hours ago',
                'read' => false,
                'priority' => 'high'
            ],
            [
                'id' => 2,
                'type' => 'interview_reminder',
                'title' => 'Upcoming Interview',
                'message' => 'Interview with Alice Chen scheduled for tomorrow at 10:00 AM',
                'time' => '4 hours ago',
                'read' => false,
                'priority' => 'medium'
            ],
            [
                'id' => 3,
                'type' => 'feedback_pending',
                'title' => 'Feedback Pending',
                'message' => 'Interview feedback for Robert Kim is pending submission',
                'time' => '1 day ago',
                'read' => true,
                'priority' => 'low'
            ]
        ];

        $this->view('recruitment/notifications', $data);
    }
}
