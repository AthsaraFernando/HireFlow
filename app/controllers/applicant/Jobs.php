<?php

class Jobs extends Controller
{
    public function index()
    {
        $URL['view'] = 'jobs';
        
        // Dummy job listings
        $URL['jobs'] = [
            [
                'id' => 1,
                'title' => 'Software Engineer',
                'company' => 'Tech Solutions Inc.',
                'location' => 'Colombo, Sri Lanka',
                'type' => 'Full-time',
                'salary' => 'LKR 80,000 - 120,000',
                'posted_date' => '2025-08-15',
                'deadline' => '2025-09-15',
                'department' => 'Engineering',
                'description_short' => 'We are looking for a skilled Software Engineer to join our development team...'
            ],
            [
                'id' => 2,
                'title' => 'Frontend Developer',
                'company' => 'Creative Minds Ltd.',
                'location' => 'Kandy, Sri Lanka',
                'type' => 'Full-time',
                'salary' => 'LKR 60,000 - 90,000',
                'posted_date' => '2025-08-18',
                'deadline' => '2025-09-18',
                'department' => 'Development',
                'description_short' => 'Join our creative team as a Frontend Developer and help build amazing user experiences...'
            ],
            [
                'id' => 3,
                'title' => 'UI/UX Designer',
                'company' => 'Design Studio Pro',
                'location' => 'Galle, Sri Lanka',
                'type' => 'Part-time',
                'salary' => 'LKR 45,000 - 70,000',
                'posted_date' => '2025-08-20',
                'deadline' => '2025-09-20',
                'department' => 'Design',
                'description_short' => 'We need a creative UI/UX Designer to enhance our product design capabilities...'
            ],
            [
                'id' => 4,
                'title' => 'Data Analyst',
                'company' => 'Analytics Corp',
                'location' => 'Colombo, Sri Lanka',
                'type' => 'Full-time',
                'salary' => 'LKR 70,000 - 100,000',
                'posted_date' => '2025-08-22',
                'deadline' => '2025-09-22',
                'department' => 'Data Science',
                'description_short' => 'Seeking a detail-oriented Data Analyst to join our analytics team...'
            ],
            [
                'id' => 5,
                'title' => 'Project Manager',
                'company' => 'Management Solutions',
                'location' => 'Negombo, Sri Lanka',
                'type' => 'Full-time',
                'salary' => 'LKR 100,000 - 150,000',
                'posted_date' => '2025-08-21',
                'deadline' => '2025-09-21',
                'department' => 'Management',
                'description_short' => 'Lead cross-functional teams and drive project success as our Project Manager...'
            ]
        ];

        $this->view('applicant', $URL);
    }
    
    public function details()
    {
        $URL['view'] = 'job-details';
        
        // Get job ID from URL (for demo, using job ID 1)
        $job_id = 1;
        
        // Dummy job details
        $URL['job'] = [
            'id' => 1,
            'title' => 'Software Engineer',
            'company' => 'Tech Solutions Inc.',
            'location' => 'Colombo, Sri Lanka',
            'type' => 'Full-time',
            'salary' => 'LKR 80,000 - 120,000',
            'posted_date' => '2025-08-15',
            'deadline' => '2025-09-15',
            'department' => 'Engineering',
            'experience_level' => '2-4 years',
            'description' => 'We are looking for a skilled Software Engineer to join our development team. The ideal candidate will have experience in web development, database management, and software architecture. You will be responsible for designing, developing, and maintaining software applications that meet our business requirements.',
            'requirements' => [
                'Bachelor\'s degree in Computer Science or related field',
                '2+ years of experience in software development',
                'Proficiency in PHP, JavaScript, and MySQL',
                'Knowledge of MVC architecture and design patterns',
                'Experience with version control systems (Git)',
                'Strong problem-solving and analytical skills',
                'Excellent communication and teamwork abilities'
            ],
            'responsibilities' => [
                'Design and develop web applications using PHP and MySQL',
                'Collaborate with cross-functional teams to define and implement new features',
                'Write clean, maintainable, and efficient code',
                'Participate in code reviews and provide constructive feedback',
                'Debug and resolve technical issues',
                'Stay updated with latest technology trends and best practices',
                'Contribute to system architecture and design decisions'
            ],
            'benefits' => [
                'Competitive salary and performance bonuses',
                'Health insurance coverage',
                'Professional development opportunities',
                'Flexible working hours',
                'Modern office environment',
                'Team building activities and events'
            ]
        ];

        $this->view('applicant', $URL);
    }
}
