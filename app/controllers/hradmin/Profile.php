<?php

class Profile extends Controller
{
    public function index()
    {
        // Require HR Admin role (role_id = 2)
        Auth::requireRole(2);
        
        $data = [];
        $user = new User();
        $userData = Auth::user();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate profile data
            $validation_errors = $this->validateProfileUpdate($_POST);
            if (empty($validation_errors)) {
                $updateData = [
                    'full_name' => trim($_POST['full_name']),
                    'email' => strtolower(trim($_POST['email'])),
                    'phone' => $_POST['phone'] ?? ''
                ];

                // Handle password change if provided
                if (!empty($_POST['new_password'])) {
                    // Verify current password first
                    if (!password_verify($_POST['current_password'], $userData['password'])) {
                        $data['errors'][] = "Current password is incorrect";
                    } else {
                        $updateData['password'] = $_POST['new_password'];
                    }
                }

                if (empty($data['errors'])) {
                    if ($user->updateProfile(Auth::user_id(), $updateData)) {
                        // Update session data
                        $updatedUser = $user->first(['id' => Auth::user_id()], []);
                        $_SESSION['USER'] = $updatedUser;

                        AccessLog::log('profile_update', 'HR Admin profile updated');
                        
                        $data['success'] = "Profile updated successfully!";
                    } else {
                        $data['errors'][] = "Failed to update profile. Please try again.";
                    }
                }
            } else {
                $data['errors'] = $validation_errors;
            }
        }
        
        // Pass user data to view
        $data['user'] = $userData;
        
        $this->view('hradmin/profile', $data);
    }
    
    private function validateProfileUpdate($data)
    {
        $errors = [];
        
        // Validate full name
        if (empty($data['full_name'])) {
            $errors[] = "Full name is required";
        }
        
        // Validate email
        if (empty($data['email'])) {
            $errors[] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        // Validate password if provided
        if (!empty($data['new_password'])) {
            if (empty($data['current_password'])) {
                $errors[] = "Current password is required to change password";
            }
            
            if (strlen($data['new_password']) < 8) {
                $errors[] = "New password must be at least 8 characters long";
            }
            
            if ($data['new_password'] !== $data['confirm_password']) {
                $errors[] = "New passwords do not match";
            }
            
            // Check password strength
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', $data['new_password'])) {
                $errors[] = "Password must contain at least one uppercase letter, lowercase letter, number, and special character";
            }
        }
        
        if (!empty($errors)) {
            return $errors;
        }
        
        return [];
    }
}
