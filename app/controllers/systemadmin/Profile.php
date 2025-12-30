<?php
class Profile extends Controller
{

    public function index()
    {
        // Ensure user is logged in and is a system admin
        Auth::requireLogin();
        Auth::requireRole(1); // System Admin role_id = 1

        $user = new User();
        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle profile update
            $data = [
                'id' => $_SESSION['USER']['id'],
                'full_name' => trim($_POST['full_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'current_password' => $_POST['current_password'] ?? '',
                'new_password' => $_POST['new_password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];

            // Validate required fields
            if (empty($data['full_name'])) {
                $errors[] = "Full name is required";
            }

            if (empty($data['email'])) {
                $errors[] = "Email is required";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }


            // Check if email is already taken by another user
            if (!empty($data['email'])) {
                $existing = $user->first(['email' => $data['email']]);
                if ($existing && $existing['id'] != $data['id']) {
                    $errors[] = "Email is already in use by another account";
                }
            }

            // Password validation if changing password
            if (!empty($data['new_password'])) {
                if (empty($data['current_password'])) {
                    $errors[] = "Current password is required to change password";
                } else {
                    // Verify current password
                    $currentUser = $user->first(['id' => $_SESSION['USER']['id']]);
                    if (!$currentUser || !password_verify($data['current_password'], $currentUser->password)) {
                        $errors[] = "Current password is incorrect";
                    }
                }

                if (strlen($data['new_password']) < 8) {
                    $errors[] = "New password must be at least 8 characters long";
                }

                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', $data['new_password'])) {
                    $errors[] = "Password must contain uppercase, lowercase, number, and special character";
                }

                if ($data['new_password'] !== $data['confirm_password']) {
                    $errors[] = "Passwords do not match";
                }
            }

            // Update profile if no errors
            if (empty($errors)) {
                $updateData = [
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Handle profile picture upload
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->handleProfileImageUpload($_FILES['profile_picture']);
                    if ($uploadResult['success']) {
                        $updateData['profile_picture'] = $uploadResult['filename'];
                    } else {
                        $errors[] = $uploadResult['error'];
                    }
                }

                // Add password to update if changing
                if (!empty($data['new_password'])) {
                    $updateData['password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                }

                if (empty($errors)) {
                    // Update user record
                    if ($user->update($_SESSION['USER']['id'], $updateData)) {
                        // Update session data
                        $_SESSION['USER']['full_name'] = $data['full_name'];
                        $_SESSION['USER']['email'] = $data['email'];
                        $_SESSION['USER']['phone'] = $data['phone'];
                        $_SESSION['USER']['address'] = $data['address'];

                        if (isset($updateData['profile_picture'])) {
                            $_SESSION['USER']['profile_picture'] = $updateData['profile_picture'];
                        }

                        // Log the profile update
                        $this->logActivity($_SESSION['USER']['id'], 'profile_update', 'System Admin profile information updated', $_SESSION['USER']['role_id'] ?? null);

                        $success = "Profile updated successfully!";

                        // Clear password fields after successful update
                        $_POST['current_password'] = '';
                        $_POST['new_password'] = '';
                        $_POST['confirm_password'] = '';
                    } else {
                        $errors[] = "Failed to update profile. Please try again.";
                    }
                }
            }
        }

        // Load the profile view
        $this->view('systemadmin/profile', [
            'errors' => $errors,
            'success' => $success
        ]);
    }

    
    private function logActivity($userId, $action, $details = '', $userRole = null)
    {
        try {
            $accessLog = new AccessLog();
            $accessLog->insert([
                'user_id' => $userId,
                'action' => $action,
                'user_role' => $userRole,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
                'details' => $details,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            // Log error but don't break the profile update
            error_log("Failed to log activity: " . $e->getMessage());
        }
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
            $oldImage = Auth::user()['profile_picture'] ?? '';
            if ($oldImage && $oldImage !== 'default-avatar.png' && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }

            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload image. Please try again.'];
        }
    }

  
    public function getActivityLogs()
    {
        Auth::requireLogin();
        Auth::requireRole(1);

        $accessLog = new AccessLog();
        $logs = $accessLog->where(['user_id' => $_SESSION['USER']['id']], 'created_at DESC');

        header('Content-Type: application/json');
        echo json_encode($logs);
        exit;
    }

 
    public function downloadData()
    {
        Auth::requireLogin();
        Auth::requireRole(1);

        $user = new User();
        $userData = $user->first(['id' => $_SESSION['USER']['id']]);

        if ($userData) {
            // Remove sensitive data
            unset($userData->password);

            $filename = 'user_data_' . $_SESSION['USER']['id'] . '_' . date('Y-m-d') . '.json';

            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            echo json_encode($userData, JSON_PRETTY_PRINT);
            exit;
        }
    }

    
    public function checkEmail()
    {
        Auth::requireLogin();
        Auth::requireRole(1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $currentUserId = $_SESSION['USER']['id'];

            $user = new User();
            $existing = $user->first(['email' => $email]);

            $available = !$existing || $existing->id == $currentUserId;

            header('Content-Type: application/json');
            echo json_encode(['available' => $available]);
            exit;
        }
    }
}
