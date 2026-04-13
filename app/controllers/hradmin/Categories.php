<?php

class Categories extends Controller
{
    public function index()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['success'] = '';
        $data['page_title'] = 'Job Categories';

        if (!empty($_SESSION['success_message'])) {
            $data['success'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        if (!empty($_SESSION['error_message'])) {
            $data['errors'][] = $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }

        $categoryModel = new JobCategory();
        $data['categories'] = $categoryModel->query(
            "SELECT jc.*, 
                d.name AS department_name,
                (SELECT COUNT(*) FROM job_posts jp WHERE jp.title = jc.name) AS jobs_count
             FROM job_categories jc
             LEFT JOIN departments d ON d.id = jc.department
             ORDER BY jc.name ASC"
        );

        $this->view('hradmin/categories', $data);
    }

    public function create()
    {
        Auth::requireRole(2);

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Create Category';

        $departmentModel = new Department();
        $data['departments'] = $departmentModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new JobCategory();

            $payload = [
                'name' => trim($_POST['name'] ?? ''),
                'department' => (int)($_POST['department'] ?? 0),
                'status' => !empty($_POST['status']) ? 'active' : 'inactive'
            ];

            if ($categoryModel->validate($payload)) {
                if ($categoryModel->insert($payload)) {
                    $_SESSION['success_message'] = 'Category created successfully!';
                    redirect('hradmin/categories');
                }

                $data['errors'][] = !empty($categoryModel->errors)
                    ? 'Failed to create category: ' . $categoryModel->errors[0]
                    : 'Failed to create category.';
            } else {
                $data['errors'] = array_values($categoryModel->errors);
            }

            $data['form_data'] = $_POST;
        }

        $this->view('hradmin/create-category', $data);
    }

    public function edit($id = null)
    {
        Auth::requireRole(2);

        if (!$id) {
            $_SESSION['error_message'] = 'Invalid category ID.';
            redirect('hradmin/categories');
        }

        $categoryModel = new JobCategory();
        $category = $categoryModel->first(['id' => $id], []);

        if (!$category) {
            $_SESSION['error_message'] = 'Category not found.';
            redirect('hradmin/categories');
        }

        $data = [];
        $data['errors'] = [];
        $data['page_title'] = 'Edit Category';
        $data['category'] = $category;

        $departmentModel = new Department();
        $data['departments'] = $departmentModel->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload = [
                'name' => trim($_POST['name'] ?? ''),
                'department' => (int)($_POST['department'] ?? 0),
                'status' => !empty($_POST['status']) ? 'active' : 'inactive'
            ];

            if ($categoryModel->validate($payload, $id)) {
                if ($categoryModel->update($id, $payload)) {
                    $_SESSION['success_message'] = 'Category updated successfully!';
                    redirect('hradmin/categories');
                }

                $data['errors'][] = !empty($categoryModel->errors)
                    ? 'Failed to update category: ' . $categoryModel->errors[0]
                    : 'Failed to update category.';
            } else {
                $data['errors'] = array_values($categoryModel->errors);
            }

            $data['category'] = array_merge($data['category'], $payload);
        }

        $this->view('hradmin/edit-category', $data);
    }

    public function delete($id = null)
    {
        Auth::requireRole(2);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('hradmin/categories');
        }

        if (!$id) {
            $_SESSION['error_message'] = 'Invalid category ID.';
            redirect('hradmin/categories');
        }

        $categoryModel = new JobCategory();
        $category = $categoryModel->first(['id' => $id], []);

        if (!$category) {
            $_SESSION['error_message'] = 'Category not found.';
            redirect('hradmin/categories');
        }

        if ($categoryModel->delete($id)) {
            $_SESSION['success_message'] = 'Category deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete category.';
        }

        redirect('hradmin/categories');
    }
}
