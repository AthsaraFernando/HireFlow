<?php

/**
 * Main Applicant Controller
 * Handles routing for all applicant-related functionalities
 */
class Applicant extends Controller
{

    public function index()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        // Default route redirects to dashboard
        redirect('applicant/dashboard');
    }

    public function dashboard()
    {
        // Require Applicant role (role_id = 4)
        Auth::requireRole(4);
        
        $data = [];
        
        // Sample dashboard data for frontend testing
        $data['user'] = [
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'profile_completion' => 85,
            'applications_count' => 12,
            'interviews_count' => 3,
            'pending_count' => 7
        ];

        $data['recent_applications'] = [
            [
                'id' => 1,
                'job_title' => 'Senior Software Engineer',
                'company' => 'TechCorp Inc.',
                'status' => 'interviewed',
                'applied_date' => '2024-01-15',
                'salary' => '$120,000 - $150,000'
            ],
            [
                'id' => 2,
                'job_title' => 'Full Stack Developer',
                'company' => 'StartupTech',
                'status' => 'pending',
                'applied_date' => '2024-01-12',
                'salary' => '$90,000 - $120,000'
            ],
            [
                'id' => 3,
                'job_title' => 'Frontend Developer',
                'company' => 'DesignStudio',
                'status' => 'shortlisted',
                'applied_date' => '2024-01-10',
                'salary' => '$80,000 - $100,000'
            ]
        ];

        $data['upcoming_interviews'] = [
            [
                'id' => 1,
                'job_title' => 'Senior Software Engineer',
                'company' => 'TechCorp Inc.',
                'date' => '2024-01-25',
                'time' => '2:00 PM',
                'type' => 'Technical Interview',
                'interviewer' => 'Sarah Johnson'
            ],
            [
                'id' => 2,
                'job_title' => 'Frontend Developer',
                'company' => 'DesignStudio',
                'date' => '2024-01-28',
                'time' => '10:00 AM',
                'type' => 'HR Interview',
                'interviewer' => 'Mike Wilson'
            ]
        ];

        $this->view('applicant/dashboard', $data);
    }

    public function jobs($action = null, $id = null)
    {
        if ($action === 'details') {
            return $this->jobDetails($id);
        }

        $data = [];
        
        // Sample jobs data for frontend testing
        $data['jobs'] = [
            [
                'id' => 1,
                'title' => 'Senior Software Engineer',
                'company' => 'TechCorp Inc.',
                'location' => 'San Francisco, CA',
                'type' => 'Full-time',
                'remote' => true,
                'salary' => '$120,000 - $150,000',
                'posted_date' => '2024-01-10',
                'deadline' => '2024-02-15',
                'description' => 'Join our team as a Senior Software Engineer and help build scalable web applications.',
                'requirements' => ['5+ years experience', 'React/Node.js', 'Team leadership']
            ],
            [
                'id' => 2,
                'title' => 'Full Stack Developer',
                'company' => 'StartupTech',
                'location' => 'New York, NY',
                'type' => 'Full-time',
                'remote' => false,
                'salary' => '$90,000 - $120,000',
                'posted_date' => '2024-01-08',
                'deadline' => '2024-02-10',
                'description' => 'Looking for a versatile Full Stack Developer to work on exciting projects.',
                'requirements' => ['3+ years experience', 'PHP/Laravel', 'MySQL']
            ],
            [
                'id' => 3,
                'title' => 'Frontend Developer',
                'company' => 'DesignStudio',
                'location' => 'Los Angeles, CA',
                'type' => 'Contract',
                'remote' => true,
                'salary' => '$80,000 - $100,000',
                'posted_date' => '2024-01-05',
                'deadline' => '2024-02-05',
                'description' => 'Create beautiful and responsive user interfaces for our clients.',
                'requirements' => ['2+ years experience', 'React/Vue.js', 'UI/UX design']
            ]
        ];

        $this->view('applicant/jobs', $data);
    }

    public function jobDetails($id = null)
    {
        $data = [];
        
        // Sample job details for frontend testing
        $data['job'] = [
            'id' => $id ?: 1,
            'title' => 'Senior Software Engineer',
            'company' => 'TechCorp Inc.',
            'location' => 'San Francisco, CA',
            'type' => 'Full-time',
            'remote' => true,
            'salary' => '$120,000 - $150,000',
            'posted_date' => '2024-01-10',
            'deadline' => '2024-02-15',
            'description' => 'We are looking for a Senior Software Engineer to join our dynamic team. You will be responsible for developing and maintaining our core applications, mentoring junior developers, and contributing to architectural decisions.',
            'requirements' => [
                '5+ years of experience in software development',
                'Strong proficiency in React and Node.js',
                'Experience with cloud platforms (AWS/Azure)',
                'Team leadership experience',
                'Excellent problem-solving skills'
            ],
            'responsibilities' => [
                'Develop and maintain scalable web applications',
                'Mentor junior developers and conduct code reviews',
                'Participate in architectural decisions and planning',
                'Collaborate with cross-functional teams',
                'Ensure code quality and best practices'
            ],
            'benefits' => [
                'Competitive salary and equity',
                'Health, dental, and vision insurance',
                'Flexible working hours',
                'Remote work options',
                'Professional development budget'
            ]
        ];

        $this->view('applicant/job-details', $data);
    }

    public function applications($action = null)
    {
        if ($action === 'apply') {
            return $this->applyJob();
        }

        $data = [];
        
        // Sample applications data for frontend testing
        $data['applications'] = [
            [
                'id' => 1,
                'job_title' => 'Senior Software Engineer',
                'company' => 'TechCorp Inc.',
                'status' => 'interviewed',
                'applied_date' => '2024-01-15',
                'last_update' => '2024-01-20',
                'salary' => '$120,000 - $150,000',
                'location' => 'San Francisco, CA'
            ],
            [
                'id' => 2,
                'job_title' => 'Full Stack Developer',
                'company' => 'StartupTech',
                'status' => 'pending',
                'applied_date' => '2024-01-12',
                'last_update' => '2024-01-12',
                'salary' => '$90,000 - $120,000',
                'location' => 'New York, NY'
            ],
            [
                'id' => 3,
                'job_title' => 'Frontend Developer',
                'company' => 'DesignStudio',
                'status' => 'shortlisted',
                'applied_date' => '2024-01-10',
                'last_update' => '2024-01-18',
                'salary' => '$80,000 - $100,000',
                'location' => 'Los Angeles, CA'
            ]
        ];

        $this->view('applicant/applications', $data);
    }

    public function applyJob()
    {
        $data = [];
        
        // Sample job data for apply form
        $data['job'] = [
            'id' => $_GET['job_id'] ?? 1,
            'title' => 'Senior Software Engineer',
            'company' => 'TechCorp Inc.',
            'location' => 'San Francisco, CA',
            'salary' => '$120,000 - $150,000'
        ];

        $this->view('applicant/apply', $data);
    }

    public function interviews($action = null)
    {
        if ($action === 'feedback') {
            return $this->interviewFeedback();
        }

        $data = [];
        
        // Sample interviews data for frontend testing
        $data['interviews'] = [
            [
                'id' => 1,
                'job_title' => 'Senior Software Engineer',
                'company' => 'TechCorp Inc.',
                'date' => '2024-01-25',
                'time' => '2:00 PM',
                'type' => 'Technical Interview',
                'interviewer' => 'Sarah Johnson',
                'status' => 'scheduled',
                'location' => 'Online - Zoom',
                'duration' => '60 minutes'
            ],
            [
                'id' => 2,
                'job_title' => 'Frontend Developer',
                'company' => 'DesignStudio',
                'date' => '2024-01-28',
                'time' => '10:00 AM',
                'type' => 'HR Interview',
                'interviewer' => 'Mike Wilson',
                'status' => 'scheduled',
                'location' => '123 Main St, Los Angeles',
                'duration' => '45 minutes'
            ],
            [
                'id' => 3,
                'job_title' => 'Full Stack Developer',
                'company' => 'StartupTech',
                'date' => '2024-01-15',
                'time' => '3:00 PM',
                'type' => 'Final Interview',
                'interviewer' => 'John Doe',
                'status' => 'completed',
                'location' => 'Online - Teams',
                'duration' => '90 minutes'
            ]
        ];

        $this->view('applicant/interviews', $data);
    }

    public function interviewFeedback()
    {
        $data = [];
        
        // Sample feedback data for frontend testing
        $data['feedbacks'] = [
            [
                'id' => 1,
                'job_title' => 'Full Stack Developer',
                'company' => 'StartupTech',
                'interview_date' => '2024-01-15',
                'interviewer' => 'John Doe',
                'feedback_date' => '2024-01-18',
                'overall_rating' => 4,
                'technical_score' => 4,
                'communication_score' => 5,
                'feedback_text' => 'Strong technical skills and excellent communication. Would be a great fit for our team.',
                'status' => 'positive'
            ],
            [
                'id' => 2,
                'job_title' => 'Backend Developer',
                'company' => 'DataTech',
                'interview_date' => '2024-01-08',
                'interviewer' => 'Lisa Zhang',
                'feedback_date' => '2024-01-10',
                'overall_rating' => 3,
                'technical_score' => 3,
                'communication_score' => 4,
                'feedback_text' => 'Good foundation but needs more experience with our tech stack.',
                'status' => 'neutral'
            ]
        ];

        $this->view('applicant/feedback', $data);
    }

    public function profile()
    {
        $data = [];
        
        // Sample profile data for frontend testing
        $data['user'] = [
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'phone' => '+1 (555) 123-4567',
            'location' => 'San Francisco, CA',
            'bio' => 'Experienced software engineer with 6+ years of full-stack development. Passionate about creating scalable web applications and leading development teams.',
            'skills' => ['JavaScript', 'React', 'Node.js', 'Python', 'AWS', 'Docker'],
            'experience' => [
                [
                    'title' => 'Senior Software Engineer',
                    'company' => 'TechCorp',
                    'duration' => '2022 - Present',
                    'description' => 'Lead development of core platform features'
                ],
                [
                    'title' => 'Full Stack Developer',
                    'company' => 'StartupXYZ',
                    'duration' => '2020 - 2022',
                    'description' => 'Built and maintained web applications'
                ]
            ],
            'education' => [
                [
                    'degree' => 'Bachelor of Computer Science',
                    'school' => 'University of California',
                    'year' => '2020'
                ]
            ]
        ];

        $this->view('applicant/profile', $data);
    }
}
