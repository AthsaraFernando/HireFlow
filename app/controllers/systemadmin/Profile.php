<?php
class Profile extends Controller {

    public function index() {
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
                if ($existing && $existing->id != $_SESSION['USER']['id']) {
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

                // Add password to update if changing
                if (!empty($data['new_password'])) {
                    $updateData['password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
                }

                // Update user record
                if ($user->update($_SESSION['USER']['id'], $updateData)) {
                    // Update session data
                    $_SESSION['USER']['full_name'] = $data['full_name'];
                    $_SESSION['USER']['email'] = $data['email'];
                    $_SESSION['USER']['phone'] = $data['phone'];
                    $_SESSION['USER']['address'] = $data['address'];

                    // Log the profile update
                    $this->logActivity($_SESSION['USER']['id'], 'Profile Updated', 'System Admin profile information updated');

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

        // Load the profile view
        $this->view('systemadmin/profile', [
            'errors' => $errors,
            'success' => $success
        ]);
    }

    /**
     * Log user activity for security audit
     */
    private function logActivity($userId, $action, $details = '') {
        try {
            $accessLog = new AccessLog();
            $accessLog->insert([
                'user_id' => $userId,
                'action' => $action,
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

    /**
     * Handle avatar/profile picture upload (future enhancement)
     */
    public function uploadAvatar() {
        Auth::requireLogin();
        Auth::requireRole(1);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            // TODO: Implement avatar upload functionality
            // This would handle file validation, resizing, and storage
            
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Avatar upload not yet implemented']);
            exit;
        }
    }

    /**
     * Get user activity logs for profile page
     */
    public function getActivityLogs() {
        Auth::requireLogin();
        Auth::requireRole(1);

        $accessLog = new AccessLog();
        $logs = $accessLog->where(['user_id' => $_SESSION['USER']['id']], 'created_at DESC', 10);

        header('Content-Type: application/json');
        echo json_encode($logs);
        exit;
    }

    /**
     * Download user data (GDPR compliance)
     */
    public function downloadData() {
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

    /**
     * Check if email is available (AJAX endpoint)
     */
    public function checkEmail() {
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
