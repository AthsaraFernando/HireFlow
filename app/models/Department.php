<?php

class Department
{
    use Model;
    protected $table = 'departments';
    protected $allowedColumns = [
        'name',
        'description',
        'head_of_department'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['name'])) {
            $this->errors['name'] = "Department name is required";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getDepartmentsWithHeads()
    {
        $query = "SELECT d.*, u.first_name, u.last_name 
                  FROM departments d 
                  LEFT JOIN users u ON d.head_of_department = u.id 
                  ORDER BY d.name";
        
        return $this->query($query);
    }
}
