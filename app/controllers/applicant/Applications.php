<?php

require_once __DIR__ . '/MyApplications.php';
require_once __DIR__ . '/ApplyJob.php';
require_once __DIR__ . '/ViewApplication.php';
require_once __DIR__ . '/EditApplication.php';
require_once __DIR__ . '/DeleteApplication.php';

/**
 * Applications Controller (Facade)
 * Keeps compatibility for /applicant/applications/* routes and delegates
 * behavior to page-focused controllers.
 */
class Applications extends Controller
{
	public function index()
	{
		return (new MyApplications())->index();
	}

	public function apply()
	{
		$job_id = $_GET['job_id'] ?? $_POST['job_id'] ?? null;
		return (new ApplyJob())->index($job_id);
	}

	public function processJobApplication()
	{
		return (new ApplyJob())->processJobApplication();
	}

	public function view($name, $data = [])
	{
		if ($name === null || (is_scalar($name) && ctype_digit((string)$name))) {
			return $this->viewApplication($name !== null ? (int)$name : null);
		}

		return parent::view($name, $data);
	}

	public function viewApplication($application_id = null)
	{
		return (new ViewApplication())->index($application_id);
	}

	public function edit($application_id = null)
	{
		return (new EditApplication())->index($application_id);
	}

	public function update($application_id)
	{
		return (new EditApplication())->update($application_id);
	}

	public function delete($application_id = null)
	{
		return (new DeleteApplication())->index($application_id);
	}
}
