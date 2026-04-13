<?php

class Departments extends Controller
{
    public function index()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Departments';

        if (!empty($_SESSION['success_message'])) {
            $data['success'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        if (!empty($_SESSION['error_message'])) {
            $data['errors'][] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $departmentModel = new Department();
        $data['departments'] = $departmentModel->query(
            "SELECT d.*, u.full_name AS head_name,
                    (SELECT COUNT(*) FROM job_posts jp WHERE jp.department_id = d.id) AS jobs_count
             FROM departments d
             LEFT JOIN users u ON d.head_of_department = u.id
             ORDER BY d.name ASC"
        );

        $this->view('hradmin/departments', $data);
    }

    public function create()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Create Department';

        $departmentModel = new Department();
        $userModel = new User();
        $data['managers'] = $this->getActiveManagers($userModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $headId = !empty($_POST['head_of_department']) ? (int)$_POST['head_of_department'] : null;

            if ($name === '') {
                $data['errors'][] = 'Department name is required.';
            }

            $existing = $departmentModel->first(['name' => $name], []);
            if ($existing) {
                $data['errors'][] = 'Department name already exists.';
            }

            if ($headId !== null && !$this->isValidManager($data['managers'], $headId)) {
                $data['errors'][] = 'Selected department head is invalid.';
            }

            if (empty($data['errors'])) {
                $insertData = [
                    'name' => $name,
                    'description' => $description,
                    'head_of_department' => $headId,
                ];

                if ($departmentModel->insert($insertData)) {
                    $_SESSION['success_message'] = 'Department created successfully!';
                    redirect('hradmin/departments');
                }

                $data['errors'][] = !empty($departmentModel->errors)
                    ? 'Failed to create department: ' . $departmentModel->errors[0]
                    : 'Failed to create department.';
            }

            $data['form_data'] = $_POST;
        }

        $this->view('hradmin/create-department', $data);
    }

    public function edit($id = null)
    {
        Auth::requireRole(2);

        if (!$id) {
            $_SESSION['error_message'] = 'Invalid department ID.';
            redirect('hradmin/departments');
        }

        $departmentModel = new Department();
        $department = $departmentModel->first(['id' => $id], []);

        if (!$department) {
            $_SESSION['error_message'] = 'Department not found.';
            redirect('hradmin/departments');
        }

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Edit Department';
        $data['department'] = $department;

        $userModel = new User();
        $data['managers'] = $this->getActiveManagers($userModel);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $headId = !empty($_POST['head_of_department']) ? (int)$_POST['head_of_department'] : null;

            if ($name === '') {
                $data['errors'][] = 'Department name is required.';
            }

            $duplicate = $departmentModel->query(
                "SELECT id FROM departments WHERE name = ? AND id != ? LIMIT 1",
                [$name, $id]
            );
            if (!empty($duplicate)) {
                $data['errors'][] = 'Department name already exists.';
            }

            if ($headId !== null && !$this->isValidManager($data['managers'], $headId)) {
                $data['errors'][] = 'Selected department head is invalid.';
            }

            if (empty($data['errors'])) {
                $updateData = [
                    'name' => $name,
                    'description' => $description,
                    'head_of_department' => $headId,
                ];

                if ($departmentModel->update($id, $updateData)) {
                    $_SESSION['success_message'] = 'Department updated successfully!';
                    redirect('hradmin/departments');
                }

                $data['errors'][] = !empty($departmentModel->errors)
                    ? 'Failed to update department: ' . $departmentModel->errors[0]
                    : 'Failed to update department.';
            }

            $data['department'] = array_merge($data['department'], [
                'name' => $name,
                'description' => $description,
                'head_of_department' => $headId,
            ]);
        }

        $this->view('hradmin/edit-department', $data);
    }

    public function delete($id = null)
    {
        Auth::requireRole(2);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('hradmin/departments');
        }

        if (!$id) {
            $_SESSION['error_message'] = 'Invalid department ID.';
            redirect('hradmin/departments');
        }

        $departmentModel = new Department();
        $department = $departmentModel->first(['id' => $id], []);

        if (!$department) {
            $_SESSION['error_message'] = 'Department not found.';
            redirect('hradmin/departments');
        }

        $inUse = $departmentModel->query(
            "SELECT COUNT(*) AS total FROM job_posts WHERE department_id = ?",
            [$id]
        );

        $jobCount = !empty($inUse) ? (int)$inUse[0]['total'] : 0;
        if ($jobCount > 0) {
            $_SESSION['error_message'] = 'Cannot delete department. It is assigned to existing job posts.';
            redirect('hradmin/departments');
        }

        if ($departmentModel->delete($id)) {
            $_SESSION['success_message'] = 'Department deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete department.';
        }

        redirect('hradmin/departments');
    }

    private function getActiveManagers($userModel)
    {
        return $userModel->query(
            "SELECT id, full_name
             FROM users
             WHERE role_id IN (2, 3) AND status = 'active'
             ORDER BY full_name ASC"
        );
    }

    private function isValidManager($managers, $managerId)
    {
        foreach ($managers as $manager) {
            if ((int)$manager['id'] === (int)$managerId) {
                return true;
            }
        }
        return false;
    }
}
