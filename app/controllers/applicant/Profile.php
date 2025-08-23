<?php

class Profile extends Controller
{
    public function index()
    {
        $URL['view'] = 'profile';
        
        // Dummy profile data
        $URL['profile'] = [
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+94 77 123 4567',
            'address' => '123 Main Street, Colombo 03, Sri Lanka',
            'date_of_birth' => '1995-05-15',
            'gender' => 'Male',
            'profile_image' => 'default-avatar.png',
            'linkedin' => 'https://linkedin.com/in/johndoe',
            'github' => 'https://github.com/johndoe',
            'portfolio' => 'https://johndoe.portfolio.com'
        ];
        
        // Education details
        $URL['education'] = [
            [
                'id' => 1,
                'degree' => 'Bachelor of Science in Computer Science',
                'institution' => 'University of Colombo',
                'start_year' => '2017',
                'end_year' => '2021',
                'gpa' => '3.75'
            ],
            [
                'id' => 2,
                'degree' => 'Advanced Level',
                'institution' => 'Royal College Colombo',
                'start_year' => '2015',
                'end_year' => '2017',
                'gpa' => '2A 1B'
            ]
        ];
        
        // Work experience
        $URL['experience'] = [
            [
                'id' => 1,
                'position' => 'Junior Software Developer',
                'company' => 'StartUp Tech Ltd.',
                'start_date' => '2021-06-01',
                'end_date' => '2023-12-31',
                'description' => 'Developed web applications using PHP, JavaScript, and MySQL. Collaborated with senior developers on various client projects.',
                'current' => false
            ],
            [
                'id' => 2,
                'position' => 'Freelance Web Developer',
                'company' => 'Self Employed',
                'start_date' => '2024-01-01',
                'end_date' => null,
                'description' => 'Working on various freelance projects including e-commerce websites and business management systems.',
                'current' => true
            ]
        ];
        
        // Skills
        $URL['skills'] = [
            'PHP', 'JavaScript', 'MySQL', 'HTML5', 'CSS3', 'React', 'Node.js', 'Git', 'Laravel', 'Bootstrap'
        ];

        $this->view('applicant', $URL);
    }
}
