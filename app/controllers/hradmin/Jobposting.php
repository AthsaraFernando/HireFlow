<?php

class Jobposting extends Controller
{
    private $jobposting;

    public function __construct() 
    {
        $this->jobposting = new JobpostingModel();
    }

    public function index() 
    {
        $URL['view'] = 'jobposting';
        $URL['stats'] = $this->jobposting->getStats();
        $URL['jobpostings'] = $this->jobposting->getJobPostings();
        $this->view('hradmin', $URL);
    }

    public function create() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'company' => $_POST['company'] ?? '',
                'location' => $_POST['location'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'department' => $_POST['department'] ?? '',
                'deadline' => $_POST['deadline'] ?? '',
                'description' => $_POST['description'] ?? '',
                'status' => $_POST['status'] ?? 'Open'
            ];

            if ($this->jobposting->insert($data)) {
                $_SESSION['success'] = "Job posting created successfully!";
                header('Location: ' . ROOT . '/hradmin/jobposting');
                exit;
            } else {
                $URL['error'] = "Failed to create job posting.";
            }
        }
        
        $URL['view'] = 'jobposting/create';
        $this->view('hradmin', $URL);
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . ROOT . '/hradmin/jobposting');
            exit;
        }

        $jobposting = $this->jobposting->first(['id' => $id], []);
        
        if (!$jobposting) {
            $_SESSION['error'] = "Job posting not found.";
            header('Location: ' . ROOT . '/hradmin/jobposting');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'company' => $_POST['company'] ?? '',
                'location' => $_POST['location'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'department' => $_POST['department'] ?? '',
                'deadline' => $_POST['deadline'] ?? '',
                'description' => $_POST['description'] ?? '',
                'status' => $_POST['status'] ?? 'Open'
            ];

            if ($this->jobposting->update($id, $data)) {
                $_SESSION['success'] = "Job posting updated successfully!";
                header('Location: ' . ROOT . '/hradmin/jobposting');
                exit;
            } else {
                $URL['error'] = "Failed to update job posting.";
            }
        }

        $URL['view'] = 'jobposting/edit';
        $URL['jobposting'] = $jobposting;
        $this->view('hradmin', $URL);
    }

    public function delete($id = null)
    {
        if (!$id) {
            header('Location: ' . ROOT . '/hradmin/jobposting');
            exit;
        }

        if ($this->jobposting->delete($id)) {
            $_SESSION['success'] = "Job posting deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete job posting.";
        }

        header('Location: ' . ROOT . '/hradmin/jobposting');
        exit;
    }
}
?>
