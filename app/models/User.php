<?php

class User
{
    use Model;
    protected $table = 'users';
    protected $allowedColumns = [
        'full_name',
        'email',
        'password',
        'role_id',
        'status'

    ];

    public function signUpValidate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "First name is required";
        }

        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Last name is required";
        }

        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $data['password'])) {
            $this->errors['password'] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
        }

        if ($data['password'] !== $data['confirm_password']) {
            $this->errors['password'] = "Passwords do not match";
        }

        if (empty($this->errors)) {
            return true;
        }
        return false;
    }

    public function signInValidate($data, $user)
    {
        $arr['email'] = $data['email'];
        $row = $user->first($arr, []);
        if ($row) {

            $posted_role_id = (int) $data['role_id'];
            $db_role_id = (int) $row['role_id'];

            if ($row['password'] === $_POST['password'] && $db_role_id === $posted_role_id) {
                $_SESSION['USER'] = $row;
                return true;
            } else {
                if ($db_role_id !== $posted_role_id) {
                    $user->errors['role_id'] = "Invalid user type";
                }
                if ($row['password'] !== $_POST['password']) {
                    $user->errors['password'] = "Invalid password";
                }
            }
        } else {
            $user->errors['email'] = "Invalid email";
        }

        return false;


    }

}