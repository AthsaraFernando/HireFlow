<?php

class ViewApplication extends Controller
{
    public function index($id = null)
    {
        if (!$id) {
            // Redirect to applications if no ID provided
            header('Location: /HireFlow/public/hradmin/applications');
            exit;
        }
        
        $data = [];
        $data['page_title'] = 'Application Details';
        $data['application_id'] = $id;
        
        // Sample application data - in real implementation this would come from database
        $data['application'] = [
            'id' => $id,
            'applicant_name' => 'John Smith',
            'email' => 'john.smith@email.com',
            'phone' => '+1 (555) 123-4567',
            'location' => 'New York, NY',
            'job_title' => 'Senior Software Developer',
            'job_id' => 1,
            'applied_date' => '2024-01-15',
            'status' => 'Under Review',
            'experience_years' => 6,
            'current_company' => 'Tech Solutions Inc.',
            'current_position' => 'Software Developer',
            'expected_salary' => 95000,
            'availability' => 'Immediate',
            'cover_letter' => 'Dear Hiring Manager, I am excited to apply for the Senior Software Developer position...',
            'resume_file' => 'john_smith_resume.pdf',
            'portfolio_url' => 'https://johnsmith.dev',
            'linkedin_url' => 'https://linkedin.com/in/johnsmith',
            'github_url' => 'https://github.com/johnsmith'
        ];
        
        // Skills and qualifications
        $data['skills'] = [
            'Technical Skills' => ['Java', 'Python', 'React', 'Node.js', 'PostgreSQL', 'AWS'],
            'Soft Skills' => ['Team Leadership', 'Project Management', 'Communication', 'Problem Solving'],
            'Certifications' => ['AWS Certified Developer', 'Scrum Master Certified'],
            'Languages' => ['English (Native)', 'Spanish (Conversational)']
        ];
        
        // Education history
        $data['education'] = [
            [
                'degree' => 'Bachelor of Computer Science',
                'institution' => 'University of Technology',
                'graduation_year' => '2018',
                'gpa' => '3.8/4.0'
            ],
            [
                'degree' => 'Master of Software Engineering',
                'institution' => 'Tech University',
                'graduation_year' => '2020',
                'gpa' => '3.9/4.0'
            ]
        ];
        
        // Work experience
        $data['experience'] = [
            [
                'position' => 'Software Developer',
                'company' => 'Tech Solutions Inc.',
                'duration' => '2020 - Present',
                'description' => 'Developed and maintained web applications using Java and React...'
            ],
            [
                'position' => 'Junior Developer',
                'company' => 'StartupXYZ',
                'duration' => '2018 - 2020',
                'description' => 'Built mobile applications and REST APIs...'
            ]
        ];
        
        // Interview history
        $data['interviews'] = [
            [
                'type' => 'Phone Screening',
                'date' => '2024-01-18',
                'interviewer' => 'Sarah Johnson',
                'status' => 'Completed',
                'score' => 8,
                'notes' => 'Strong technical background, good communication skills'
            ],
            [
                'type' => 'Technical Interview',
                'date' => '2024-01-22',
                'interviewer' => 'Mike Davis',
                'status' => 'Scheduled',
                'score' => null,
                'notes' => ''
            ]
        ];
        
        // Assessment scores
        $data['assessments'] = [
            [
                'name' => 'Technical Skills Test',
                'score' => 85,
                'max_score' => 100,
                'completed_date' => '2024-01-16'
            ],
            [
                'name' => 'Problem Solving',
                'score' => 78,
                'max_score' => 100,
                'completed_date' => '2024-01-16'
            ],
            [
                'name' => 'Cultural Fit',
                'score' => 92,
                'max_score' => 100,
                'completed_date' => '2024-01-17'
            ]
        ];
        
        // Notes and comments
        $data['notes'] = [
            [
                'author' => 'Sarah Johnson',
                'date' => '2024-01-18',
                'note' => 'Candidate shows strong technical skills and enthusiasm for the role.'
            ],
            [
                'author' => 'HR Team',
                'date' => '2024-01-16',
                'note' => 'Resume screening passed. Moving to phone interview stage.'
            ]
        ];
        
        // Status options for updating
        $data['status_options'] = [
            'Applied',
            'Under Review',
            'Phone Screening',
            'Technical Interview',
            'Final Interview',
            'Offer Made',
            'Hired',
            'Rejected'
        ];
        
        // Handle status update
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
            // In real implementation, update database
            $data['application']['status'] = $_POST['status'];
            $data['success'] = 'Application status updated successfully!';
        }
        
        // Handle adding notes
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_note'])) {
            if (!empty($_POST['note'])) {
                // In real implementation, save to database
                $new_note = [
                    'author' => 'Current User', // Would get from session
                    'date' => date('Y-m-d'),
                    'note' => $_POST['note']
                ];
                array_unshift($data['notes'], $new_note);
                $data['success'] = 'Note added successfully!';
            }
        }
        
        $this->view('hradmin/view-application', $data);
    }
}
