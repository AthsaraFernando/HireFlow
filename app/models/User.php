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
        'phone',
        'address',
        'profile_picture',
        'status',
        'last_login',
        'password_reset_token',
        'password_reset_expires',
        'created_at',
        'updated_at'
    ];

    public function signUpValidate($data)
    {
        $this->errors = [];

        // Validate first name
        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "First name is required";
        } elseif (strlen($data['first_name']) < 2) {
            $this->errors['first_name'] = "First name must be at least 2 characters";
        }

        // Validate last name
        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Last name is required";
        } elseif (strlen($data['last_name']) < 2) {
            $this->errors['last_name'] = "Last name must be at least 2 characters";
        }

        // Validate email
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        } else {
            // Check if email already exists
            if ($this->emailExists($data['email'])) {
                $this->errors['email'] = "Email already exists";
            }
        }

        // Validate password
        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $data['password'])) {
            $this->errors['password'] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
        }

        // Validate password confirmation
        if (empty($data['confirm_password'])) {
            $this->errors['confirm_password'] = "Please confirm your password";
        } elseif ($data['password'] !== $data['confirm_password']) {
            $this->errors['confirm_password'] = "Passwords do not match";
        }

        // Validate phone (optional)
        if (!empty($data['phone']) && !preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
            $this->errors['phone'] = "Please enter a valid phone number";
        }

        return empty($this->errors);
    }

    public function signInValidate($data, $user)
    {
        $this->errors = [];

        // Validate email
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
            return false;
        }

        // Validate password
        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required";
            return false;
        }

        // Find user by email
        $arr['email'] = $data['email'];
        $row = $user->first($arr, []);

        if ($row) {
            // Check if account is active
            if (isset($row['status']) && $row['status'] !== 'active') {
                $this->errors['general'] = "Your account is inactive. Please contact administrator.";
                return false;
            }

            // Verify password
            if (password_verify($data['password'], $row['password']) || $data['password'] === $row['password']) {
                // Check role if provided
                if (isset($data['role_id'])) {
                    $posted_role_id = (int) $data['role_id'];
                    $db_role_id = (int) $row['role_id'];

                    if ($db_role_id !== $posted_role_id) {
                        $this->errors['role_id'] = "Invalid user type";
                        return false;
                    }
                }

                // Update last login
                $this->updateLastLogin($row['id']);

                // Set session
                $_SESSION['USER'] = $row;
                $_SESSION['USER_ID'] = $row['id'];
                $_SESSION['USER_ROLE'] = $row['role_id'];
                $_SESSION['LOGIN_TIME'] = time();

                return true;
            } else {
                $this->errors['password'] = "Invalid password";
            }
        } else {
            $this->errors['email'] = "Invalid email address";
        }

        return false;
    }

    public function emailExists($email)
    {
        $result = $this->first(['email' => $email], []);
        return !empty($result);
    }

    public function updateLastLogin($userId)
    {
        $data = ['last_login' => date('Y-m-d H:i:s')];
        $this->update($userId, $data);
    }

    public function createUser($data)
    {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Set default values
        $data['status'] = $data['status'] ?? 'active';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }

    public function updateProfile($userId, $data)
    {
        // Remove password from data if empty
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        } elseif (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($userId, $data);
    }

    public function generatePasswordResetToken($email)
    {
        $user = $this->first(['email' => $email], []);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->update($user['id'], [
                'password_reset_token' => $token,
                'password_reset_expires' => $expires
            ]);

            return $token;
        }
        return false;
    }

    public function resetPassword($token, $newPassword)
    {
        // $user = $this->first([
        //     'password_reset_token' => $token,
        //     'password_reset_expires >' => date('Y-m-d H:i:s')
        // ], []);

        if ($_SESSION['USER_ID']) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->update($_SESSION['USER_ID'] , [
                'password' => $hashedPassword,
                // 'password_reset_token' => null,
                // 'password_reset_expires' => null,
                // 'updated_at' => date('Y-m-d H:i:s')
            ]);
            return true;
        }
        return false;
    }

    public function getUserWithRole($userId)
    {
        $query = "SELECT u.*, r.role_name, r.permissions 
                  FROM users u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  WHERE u.id = ?";

        $result = $this->query($query, [$userId]);
        return $result ? $result[0] : false;
    }

    public function validateProfileUpdate($data, $userId)
    {
        $this->errors = [];

        // Validate full name
        if (empty($data['full_name'])) {
            $this->errors['full_name'] = "Full name is required";
        } elseif (strlen($data['full_name']) < 3) {
            $this->errors['full_name'] = "Full name must be at least 3 characters";
        }

        // Validate email
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        } else {
            // Check if email exists for different user
            $existing = $this->first(['email' => $data['email']], []);
            if ($existing && $existing['id'] != $userId) {
                $this->errors['email'] = "Email already exists";
            }
        }

        // Validate phone (if provided)
        if (!empty($data['phone']) && !preg_match('/^[\+]?[1-9][\d]{0,15}$/', $data['phone'])) {
            $this->errors['phone'] = "Please enter a valid phone number";
        }

        // Validate password (if provided)
        if (!empty($data['password'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $data['password'])) {
                $this->errors['password'] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
            }
            if ($data['password'] !== $data['confirm_password']) {
                $this->errors['confirm_password'] = "Passwords do not match";
            }
        }

        return empty($this->errors);
    }

    public function getUserCount()
    {
        $query = "SELECT COUNT(*) AS total FROM {$this->table}";
        $result = $this->query($query);
        return $result ? (int) $result[0]['total'] : 0;
    }

}