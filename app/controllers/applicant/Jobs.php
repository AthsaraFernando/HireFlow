<?php

/**
 * Jobs Controller
 * Handles job browsing, searching, details, and saved jobs
 */
class Jobs extends Controller
{
    use ApplicantBaseTrait;

    public function index()
    {
        Auth::requireRole(4);
        
        $data = [];
        $jobModel = new JobPost();
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $savedJobModel = new SavedJob();
        $user_id = Auth::user_id();
        $saved_job_ids = $savedJobModel->getSavedJobIdsByApplicant($user_id);
        
        // Get current user data for navigation
        $data['user'] = $this->getUserData($user_id);
        
        // Get filters from URL parameters
        $filters = [];
        if (isset($_GET['title'])) $filters['title'] = $_GET['title'];
        if (isset($_GET['department'])) $filters['department'] = $_GET['department'];
        if (isset($_GET['location'])) $filters['location'] = $_GET['location'];
        if (isset($_GET['employment_type'])) $filters['employment_type'] = $_GET['employment_type'];
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Jobs per page
        $offset = ($page - 1) * $limit;
        
        // Get jobs based on filters
        if (!empty($filters)) {
            $jobs = $jobModel->searchJobs($filters, $limit, $offset);
            $total_jobs = $jobModel->getJobCount($filters);
        } else {
            $jobs = $jobModel->getActiveJobs($limit, $offset);
            $total_jobs = $jobModel->getJobCount();
        }
        
        // Format jobs data for view
        $data['jobs'] = [];
        if ($jobs && is_array($jobs)) {
            foreach ($jobs as $job) {
                // Check if user has already applied
                $has_applied = $applicationModel->hasAppliedToJob($user_id, $job['id']);
                
                // Check if application form exists for this job
                $applicationFormMeta = $applicationFormModel->getFormByJobPostId($job['id']);
                $form_available = $applicationFormMeta && ($applicationFormMeta['status'] ?? 'inactive') === 'active';
                
                // Parse requirements from text format to array
                $requirements = [];
                if (!empty($job['requirements'])) {
                    $req_lines = explode("\n", $job['requirements']);
                    foreach ($req_lines as $line) {
                        $line = trim($line);
                        if (!empty($line) && $line !== '???') {
                            // Remove bullet points and clean up
                            $line = preg_replace('/^[•???*-]\s*/', '', $line);
                            if (!empty($line)) {
                                $requirements[] = $line;
                            }
                        }
                    }
                }

                $data['jobs'][] = [
                    'id' => $job['id'],
                    'title' => $job['title'],
                    'company' => 'HireFlow Company',
                    'location' => $job['location'] ?? 'Not specified',
                    'type' => $job['employment_type'] ?? 'Full-time',
                    'remote' => false,
                    'salary' => $job['salary_range'] ?? 'Competitive',
                    'posted_date' => date('Y-m-d', strtotime($job['created_at'])),
                    'deadline' => $job['deadline'] ? date('Y-m-d', strtotime($job['deadline'])) : 'Open',
                    'description' => substr($job['description'], 0, 150) . '...',
                    'department' => $job['department'] ?? 'General',
                    'requirements' => $requirements,
                    'has_applied' => $has_applied,
                    'form_available' => $form_available,
                    'is_saved' => in_array((int)$job['id'], $saved_job_ids, true)
                ];
            }
        }
        
        // Pagination data
        $data['pagination'] = [
            'current_page' => $page,
            'total_jobs' => $total_jobs,
            'jobs_per_page' => $limit,
            'total_pages' => ceil($total_jobs / $limit),
            'has_previous' => $page > 1,
            'has_next' => $page < ceil($total_jobs / $limit)
        ];
        
        // Filter options for dropdown
        $data['filters'] = $filters;
        $data['employment_types'] = ['Full-time', 'Part-time', 'Contract', 'Internship'];
        
        // Get unique departments from database
        $all_jobs = $jobModel->findAll();
        $departments = [];
        if ($all_jobs && is_array($all_jobs)) {
            foreach ($all_jobs as $job) {
                if (!empty($job['department']) && !in_array($job['department'], $departments)) {
                    $departments[] = $job['department'];
                }
            }
        }
        $data['departments'] = $departments;

        $this->view('applicant/jobs', $data);
    }

    public function details($id = null)
    {
        Auth::requireRole(4);
        
        if (!$id) {
            redirect('applicant/jobs');
            return;
        }
        
        $data = [];
        $jobModel = new JobPost();
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $savedJobModel = new SavedJob();
        $user_id = Auth::user_id();
        
        // Get job details
        $job = $jobModel->getJobById($id);
        
        if (!$job) {
            redirect('applicant/jobs');
            return;
        }
        
        // Check if user has already applied
        $has_applied = $applicationModel->hasAppliedToJob($user_id, $job['id']);
        $user_application = null;
        
        if ($has_applied) {
            $user_apps = $applicationModel->getUserApplications($user_id);
            if ($user_apps && is_array($user_apps)) {
                foreach ($user_apps as $app) {
                    if ($app['job_id'] == $job['id']) {
                        $user_application = $app;
                        break;
                    }
                }
            }
        }
        
        // Check if application form exists for this job
        $applicationFormMeta = $applicationFormModel->getFormByJobPostId($job['id']);
        $form_available = $applicationFormMeta && ($applicationFormMeta['status'] ?? 'inactive') === 'active';
        
        // Parse requirements if they're stored as text
        $requirements = [];
        if (!empty($job['requirements'])) {
            $requirements = array_filter(array_map('trim', explode("\n", $job['requirements'])));
        }
        
        // Format job data for view
        $data['job'] = [
            'id' => $job['id'],
            'title' => $job['title'],
            'company' => 'HireFlow Company',
            'location' => $job['location'] ?? 'Not specified',
            'type' => $job['employment_type'] ?? 'Full-time',
            'experience_level' => $job['experience_level'] ?? 'Not specified',
            'remote' => false,
            'salary' => $job['salary_range'] ?? 'Competitive salary',
            'posted_date' => date('Y-m-d', strtotime($job['created_at'])),
            'deadline' => $job['deadline'] ? date('Y-m-d', strtotime($job['deadline'])) : null,
            'description' => $job['description'],
            'requirements' => $requirements,
            'department' => $job['department'] ?? 'General',
            'has_applied' => $has_applied,
            'application_status' => $user_application['status'] ?? null,
            'applied_at' => $user_application['applied_at'] ?? null,
            'form_available' => $form_available,
            'is_saved' => $savedJobModel->isJobSaved($user_id, $job['id'])
        ];

        $this->view('applicant/job-details', $data);
    }

    public function savedJobs($action = null, $id = null)
    {
        Auth::requireRole(4);

        $savedJobModel = new SavedJob();
        $user_id = Auth::user_id();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($action === 'save') {
                $job_id = (int)($_POST['job_id'] ?? $id ?? 0);
                $note = trim($_POST['note'] ?? '');

                if ($job_id <= 0) {
                    $_SESSION['error'] = 'Invalid job selected.';
                } elseif ($savedJobModel->saveJob($user_id, $job_id, $note)) {
                    $_SESSION['success'] = 'Job saved successfully.';
                } else {
                    $_SESSION['error'] = 'Unable to save this job right now.';
                }

                $return_to = $_POST['return_to'] ?? '';
                if (!empty($return_to) && preg_match('/^applicant\//', $return_to)) {
                    redirect($return_to);
                }

                redirect('applicant/jobs/savedJobs');
                return;
            }

            if ($action === 'updateNote') {
                $saved_job_id = (int)($id ?? $_POST['saved_job_id'] ?? 0);
                $note = trim($_POST['note'] ?? '');

                if ($saved_job_id <= 0) {
                    $_SESSION['error'] = 'Invalid saved job selected.';
                    redirect('applicant/jobs/savedJobs');
                    return;
                }

                if ($savedJobModel->updateNote($saved_job_id, $user_id, $note)) {
                    $_SESSION['success'] = 'Saved job note updated.';
                } else {
                    $_SESSION['error'] = 'Failed to update note. Please try again.';
                }

                redirect('applicant/jobs/savedJobs');
                return;
            }

            if ($action === 'delete') {
                $saved_job_id = (int)($id ?? $_POST['saved_job_id'] ?? 0);

                if ($saved_job_id <= 0) {
                    $_SESSION['error'] = 'Invalid saved job selected.';
                    redirect('applicant/jobs/savedJobs');
                    return;
                }

                if ($savedJobModel->removeSavedJob($saved_job_id, $user_id)) {
                    $_SESSION['success'] = 'Saved job removed.';
                } else {
                    $_SESSION['error'] = 'Unable to remove saved job.';
                }

                redirect('applicant/jobs/savedJobs');
                return;
            }
        }

        $data = [];
        $applicationModel = new Application();
        $applicationFormModel = new ApplicationForm();
        $data['user'] = $this->getUserData($user_id);

        $saved_jobs = $savedJobModel->getSavedJobsWithDetails($user_id);
        $data['saved_jobs'] = [];

        if ($saved_jobs && is_array($saved_jobs)) {
            foreach ($saved_jobs as $saved_job) {
                $data['saved_jobs'][] = [
                    'id' => (int)$saved_job['id'],
                    'job_id' => (int)$saved_job['job_id'],
                    'title' => $saved_job['title'] ?? 'Untitled Job',
                    'company' => 'HireFlow Company',
                    'location' => $saved_job['location'] ?? 'Not specified',
                    'employment_type' => $saved_job['employment_type'] ?? 'Not specified',
                    'department' => $saved_job['department'] ?? 'General',
                    'salary_range' => $saved_job['salary_range'] ?? 'Not specified',
                    'description' => $saved_job['description'] ?? '',
                    'job_status' => $saved_job['job_status'] ?? 'Draft',
                    'deadline' => $saved_job['deadline'] ?? null,
                    'note' => $saved_job['note'] ?? '',
                    'has_applied' => $applicationModel->hasAppliedToJob($user_id, (int)$saved_job['job_id']),
                    'form_available' => (function() use ($applicationFormModel, $saved_job) {
                        $form = $applicationFormModel->getFormByJobPostId((int)$saved_job['job_id']);
                        return $form && ($form['status'] ?? 'inactive') === 'active';
                    })()
                ];
            }
        }

        $this->view('applicant/saved-jobs', $data);
    }
}
