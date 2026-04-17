<?php

/**
 * Legacy SavedJobs Controller
 * Keeps backward compatibility for /applicant/savedJobs/* routes.
 */
class SavedJobs extends Controller
{
    public function index()
    {
        $jobsController = new Jobs();
        return $jobsController->savedJobs();
    }

    public function save($id = null)
    {
        $jobsController = new Jobs();
        return $jobsController->savedJobs('save', $id);
    }

    public function updateNote($id = null)
    {
        $jobsController = new Jobs();
        return $jobsController->savedJobs('updateNote', $id);
    }

    public function delete($id = null)
    {
        $jobsController = new Jobs();
        return $jobsController->savedJobs('delete', $id);
    }
}
