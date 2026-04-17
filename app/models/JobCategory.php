<?php

class JobCategory
{
    use Model;

    protected $table = 'job_categories';
    protected $allowedColumns = [
        'name',
        'department',
        'status'
    ];

    public function validate($data, $id = null)
    {
        $this->errors = [];

        $name = trim($data['name'] ?? '');
        $department = $data['department'] ?? null;
        if ($name === '') {
            $this->errors['name'] = 'Category name is required.';
        }

        if (empty($department) || !is_numeric($department)) {
            $this->errors['department'] = 'Department is required.';
        } else {
            $existsDepartment = $this->query(
                "SELECT id FROM departments WHERE id = ? LIMIT 1",
                [(int)$department]
            );
            if (empty($existsDepartment)) {
                $this->errors['department'] = 'Selected department is invalid.';
            }
        }

        if ($name !== '') {
            if ($id) {
                $exists = $this->query(
                    "SELECT id FROM {$this->table} WHERE name = ? AND id != ? LIMIT 1",
                    [$name, $id]
                );
            } else {
                $exists = $this->query(
                    "SELECT id FROM {$this->table} WHERE name = ? LIMIT 1",
                    [$name]
                );
            }

            if (!empty($exists)) {
                $this->errors['name'] = 'Category name already exists.';
            }
        }

        return empty($this->errors);
    }
}
