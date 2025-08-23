<?php

class Interviews extends Controller
{
    public function index()
    {
        $URL['view'] = 'interviews';
        
        // Dummy interview schedules
        $URL['interviews'] = [
            [
                'id' => 1,
                'job_title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'interview_date' => '2025-08-25',
                'interview_time' => '10:00 AM',
                'interview_type' => 'Virtual',
                'interviewer' => 'Mr. John Smith',
                'status' => 'Scheduled',
                'meeting_link' => 'https://zoom.us/j/1234567890',
                'instructions' => 'Please join the meeting 5 minutes before the scheduled time. Have your resume and portfolio ready.'
            ],
            [
                'id' => 2,
                'job_title' => 'UI/UX Designer',
                'company' => 'Design Studio Pro',
                'interview_date' => '2025-08-28',
                'interview_time' => '2:00 PM',
                'interview_type' => 'In-person',
                'interviewer' => 'Ms. Sarah Johnson',
                'status' => 'Scheduled',
                'location' => 'Design Studio Pro, 123 Main Street, Galle',
                'instructions' => 'Please bring your portfolio and arrive 10 minutes early.'
            ],
            [
                'id' => 3,
                'job_title' => 'Frontend Developer',
                'company' => 'Creative Minds Ltd.',
                'interview_date' => '2025-08-20',
                'interview_time' => '11:00 AM',
                'interview_type' => 'Virtual',
                'interviewer' => 'Mr. David Wilson',
                'status' => 'Completed',
                'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/...',
                'instructions' => 'Technical interview focusing on JavaScript and React.'
            ]
        ];

        $this->view('applicant', $URL);
    }
    
    public function feedback()
    {
        $URL['view'] = 'feedback';
        
        // Dummy interview feedback
        $URL['feedback_list'] = [
            [
                'id' => 1,
                'job_title' => 'Frontend Developer',
                'company' => 'Creative Minds Ltd.',
                'interview_date' => '2025-08-20',
                'interviewer' => 'Mr. David Wilson',
                'overall_rating' => 4,
                'technical_skills' => 4,
                'communication' => 5,
                'problem_solving' => 3,
                'feedback' => 'Strong technical knowledge and excellent communication skills. Could improve on algorithmic problem-solving. Overall a good candidate with potential for growth.',
                'next_steps' => 'We will contact you within 3-5 business days with our decision.',
                'status' => 'Under Review'
            ],
            [
                'id' => 2,
                'job_title' => 'Web Developer',
                'company' => 'Digital Dreams',
                'interview_date' => '2025-08-15',
                'interviewer' => 'Ms. Emily Brown',
                'overall_rating' => 2,
                'technical_skills' => 2,
                'communication' => 3,
                'problem_solving' => 2,
                'feedback' => 'Basic understanding of web technologies but lacks depth in framework knowledge. Communication was adequate but technical responses were incomplete.',
                'next_steps' => 'Unfortunately, we will not be moving forward with your application at this time.',
                'status' => 'Rejected'
            ]
        ];

        $this->view('applicant', $URL);
    }
}
