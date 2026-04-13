<?php

class Profile extends Controller
{
    public function index()
    {
        // Require login
        Auth::requireLogin();
        
        $data = [];
        $user = new User();
        $userData = Auth::user();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('profile', $data);
                return;
            }

            // Validate profile data
            if ($user->validateProfileUpdate($_POST, Auth::user_id())) {
                $updateData = [
                    'full_name' => trim($_POST['full_name']),
                    'email' => strtolower(trim($_POST['email'])),
                    'phone' => $_POST['phone'] ?? '',
                    'address' => $_POST['address'] ?? ''
                ];

                // Add password if provided
                if (!empty($_POST['password'])) {
                    $updateData['password'] = $_POST['password'];
                }

                // Handle profile image upload
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->handleProfileImageUpload($_FILES['profile_image']);
                    if ($uploadResult['success']) {
                        $updateData['profile_image'] = $uploadResult['filename'];
                    } else {
                        $data['errors']['profile_image'] = $uploadResult['error'];
                    }
                }

                if (empty($data['errors'])) {
                    if ($user->updateProfile(Auth::user_id(), $updateData)) {
                        // Update session data
                        $updatedUser = $user->first(['id' => Auth::user_id()], []);
                        $_SESSION['USER'] = $updatedUser;
                        
                        // Log profile update
                        AccessLog::log('profile_update', 'User profile updated');
                        
                        $data['success'] = "Profile updated successfully!";
                    } else {
                        $data['errors']['general'] = "Failed to update profile. Please try again.";
                    }
                }
            }
            
            $data['errors'] = array_merge($data['errors'] ?? [], $user->errors);
        }

        $data['user'] = Auth::user();
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('profile', $data);
    }

    private function handleProfileImageUpload($file)
    {
        $uploadDir = '../public/assets/images/profiles/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $file['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'error' => 'Only JPEG, PNG, and GIF images are allowed.'];
        }

        // Validate file size (2MB max)
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'File size must be less than 2MB.'];
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . Auth::user_id() . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old profile image if it exists
            $oldImage = Auth::user()['profile_image'] ?? '';
            if ($oldImage && $oldImage !== 'default-avatar.png' && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
            
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload image. Please try again.'];
        }
    }

    public function changePassword()
    {
        // Require login
        Auth::requireLogin();
        
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('change-password', $data);
                return;
            }

            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validate current password
            $user = new User();
            $userData = $user->first(['id' => Auth::user_id()], []);
            
            if (!password_verify($currentPassword, $userData['password'])) {
                $data['errors']['current_password'] = "Current password is incorrect";
            }

            // Validate new password
            if (empty($newPassword)) {
                $data['errors']['new_password'] = "New password is required";
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $newPassword)) {
                $data['errors']['new_password'] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
            }

            if (empty($confirmPassword)) {
                $data['errors']['confirm_password'] = "Please confirm your new password";
            } elseif ($newPassword !== $confirmPassword) {
                $data['errors']['confirm_password'] = "Passwords do not match";
            }

            if (empty($data['errors'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                if ($user->update(Auth::user_id(), ['password' => $hashedPassword, 'updated_at' => date('Y-m-d H:i:s')])) {
                    // Log password change
                    AccessLog::log('password_change', 'User changed password');
                    
                    $data['success'] = "Password changed successfully!";
                } else {
                    $data['errors']['general'] = "Failed to change password. Please try again.";
                }
            }
        }

        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('change-password', $data);
    }
}
