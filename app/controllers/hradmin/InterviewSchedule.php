<?php

class InterviewSchedule extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        

        // Sample data - in real implementation this would come from database
        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Interview Schedule';
        
        if ($_POST) {
            // Handle interview scheduling
            $data['success'] = 'Interview scheduled successfully!';
        }
        
        // Sample interview data
        $data['interviews'] = [
            [
                'id' => 1,
                'applicant_name' => 'John Smith',
                'position' => 'Senior Software Developer',
                'interviewer' => 'Jane Doe',
                'date' => '2024-01-20',
                'time' => '10:00 AM',
                'type' => 'Technical',
                'status' => 'Scheduled',
                'location' => 'Conference Room A'
            ],
            [
                'id' => 2,
                'applicant_name' => 'Sarah Johnson',
                'position' => 'UI/UX Designer',
                'interviewer' => 'Bob Wilson',
                'date' => '2024-01-21',
                'time' => '2:00 PM',
                'type' => 'Portfolio Review',
                'status' => 'Scheduled',
                'location' => 'Design Studio'
            ],
            [
                'id' => 3,
                'applicant_name' => 'Mike Wilson',
                'position' => 'Project Manager',
                'interviewer' => 'Alice Brown',
                'date' => '2024-01-22',
                'time' => '11:00 AM',
                'type' => 'Behavioral',
                'status' => 'Completed',
                'location' => 'Virtual Meeting'
            ]
        ];
        
        $this->view('hradmin/interview-schedule', $data);
    }
}
