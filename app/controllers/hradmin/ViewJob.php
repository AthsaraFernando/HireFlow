<?php

class ViewJob extends Controller
{
    public function index($id = null)
    {
        if (!$id) {
            // Redirect to job posts if no ID provided
            header('Location: /HireFlow/public/hradmin/job-posts');
            exit;
        }
        
        $data = [];
        $data['page_title'] = 'Job Details';
        $data['job_id'] = $id;
        
        // Sample job data - in real implementation this would come from database
        $data['job'] = [
            'id' => $id,
            'title' => 'Senior Software Developer',
            'department' => 'Engineering',
            'location' => 'New York, NY',
            'type' => 'Full-time',
            'status' => 'Active',
            'experience_level' => 'Senior Level',
            'description' => 'We are looking for a Senior Software Developer to join our growing team. You will be responsible for developing high-quality software solutions and mentoring junior developers.',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field, 5+ years of experience in software development, proficiency in Java, Python, or C++, experience with agile methodologies.',
            'benefits' => 'Health insurance, dental and vision coverage, 401k with company matching, flexible working hours, professional development opportunities, stock options.',
            'salary_min' => 80000,
            'salary_max' => 120000,
            'created_date' => '2024-01-10',
            'deadline' => '2024-02-10',
            'created_by' => 'Sarah Johnson',
            'total_applications' => 23,
            'new_applications' => 5,
            'interviews_scheduled' => 8,
            'offers_made' => 2
        ];
        
        // Sample applications data
        $data['recent_applications'] = [
            [
                'id' => 1,
                'applicant_name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'applied_date' => '2024-01-15',
                'status' => 'Under Review',
                'experience' => '6 years',
                'score' => 85
            ],
            [
                'id' => 2,
                'applicant_name' => 'Jane Doe',
                'email' => 'jane.doe@email.com',
                'applied_date' => '2024-01-14',
                'status' => 'Interview Scheduled',
                'experience' => '8 years',
                'score' => 92
            ],
            [
                'id' => 3,
                'applicant_name' => 'Mike Johnson',
                'email' => 'mike.johnson@email.com',
                'applied_date' => '2024-01-13',
                'status' => 'Initial Screening',
                'experience' => '4 years',
                'score' => 78
            ]
        ];
        
        // Analytics data for charts
        $data['application_stats'] = [
            'daily_applications' => [
                ['date' => '2024-01-10', 'count' => 3],
                ['date' => '2024-01-11', 'count' => 5],
                ['date' => '2024-01-12', 'count' => 2],
                ['date' => '2024-01-13', 'count' => 4],
                ['date' => '2024-01-14', 'count' => 6],
                ['date' => '2024-01-15', 'count' => 3]
            ],
            'status_breakdown' => [
                'Under Review' => 8,
                'Interview Scheduled' => 6,
                'Initial Screening' => 5,
                'Rejected' => 3,
                'Offer Made' => 1
            ]
        ];
        
        $this->view('hradmin/view-job', $data);
    }
}
