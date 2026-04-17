<?php

class Profile extends Controller
{
    public function index()
    {
        // Require Recruitment Manager role (role_id = 3)
        Auth::requireRole(3);
        
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
                    'phone' => trim($_POST['phone'] ?? ''),
                    'address' => trim($_POST['address'] ?? '')
                ];

                // Handle profile picture upload
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->handleProfileImageUpload($_FILES['profile_picture']);
                    if ($uploadResult['success']) {
                        $updateData['profile_picture'] = $uploadResult['filename'];
                    } else {
                        $data['errors'][] = $uploadResult['error'];
                    }
                }

                // Handle password change if provided
                if (!empty($_POST['new_password'])) {
                    // Verify current password first
                    if (!password_verify($_POST['current_password'], $userData['password'])) {
                        $data['errors'][] = "Current password is incorrect";
                    } else {
                        $updateData['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    }
                }

                if (empty($data['errors'])) {
                    if ($user->updateProfile(Auth::user_id(), $updateData)) {
                        // Update session data
                        $updatedUser = $user->first(['id' => Auth::user_id()]);
                        $_SESSION['USER'] = $updatedUser;

                        AccessLog::log('profile_update', 'Recruitment Manager profile updated');
                        
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
        
        $this->view('recruitment/profile', $data);
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

    private function handleProfileImageUpload($file)
    {
        $uploadDir = '../public/assets/images/profiles/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $file['type'];

        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Only JPEG, PNG, and GIF images are allowed.'];
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File size must be less than 2MB.'];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . Auth::user_id() . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $oldImage = Auth::user()['profile_picture'] ?? '';
            if ($oldImage && $oldImage !== 'default-avatar.jpg' && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }

            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Failed to upload image. Please try again.'];
    }

    public function downloadData()
    {
        Auth::requireRole(3);

        $user = new User();
        $userData = $user->first(['id' => Auth::user_id()]);

        if ($userData) {
            unset($userData['password']);

            $filename = 'recruitment_user_data_' . Auth::user_id() . '_' . date('Y-m-d') . '.json';

            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo json_encode($userData, JSON_PRETTY_PRINT);
            exit;
        }
    }
}
