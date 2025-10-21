<?php

class Usermanage extends Controller
{
    public function index()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);

        $data = [];
        $user = new User();
        $role = new Role();

        // Check if user has admin privileges for actions
        $canManageUsers = Auth::hasRole(1); // Only System Admin can manage users
        $data['can_manage_users'] = $canManageUsers;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Only System Admins can perform user management actions
            if (!$canManageUsers) {
                $data['errors']['general'] = "Insufficient privileges to perform this action.";
            } elseif (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                // Skip CSRF check for fetch action (read-only)
                $action = $_POST['action'] ?? '';
                if ($action !== 'fetch') {
                    $data['errors']['general'] = "Invalid request. Please try again.";
                }
            }

            if (empty($data['errors'])) {
                $action = $_POST['action'] ?? '';

                switch ($action) {
                    case 'create':
                        $this->handleCreateUser($data, $user);
                        break;
                    case 'update':
                        $this->handleUpdateUser($data, $user);
                        break;
                    case 'delete':
                        $this->handleDeleteUser($data, $user);
                        break;
                    case 'toggle_status':
                        $this->handleToggleStatus($data, $user);
                        break;
                    case 'fetch':
                        $this->handleGetUser($data, $user);
                        return;
                    default:
                        $data['errors']['general'] = "Invalid action";
                        break;
                }
            }

        }

        // Get all users with role information
        $data['users'] = $this->getUsersWithRoles();
        $data['roles'] = $role->findAll();
        $data['csrf_token'] = Auth::generateCSRFToken();

        $data['view'] = 'usermanage';
        $this->view('systemadmin', $data);
    }

    private function handleCreateUser(&$data, $user)
    {
        // logger($data);
        // Validate input
        $requiredFields = ['full_name', 'email', 'password', 'role_id'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $data['errors'][$field] = ucfirst(str_replace('_', ' ', $field)) . " is required";
            }
        }

        // Validate email
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $data['errors']['email'] = "Invalid email format";
        }

        // Check if email exists
        if (!empty($_POST['email']) && $user->emailExists($_POST['email'])) {
            $data['errors']['email'] = "Email already exists";
        }

        // Validate password
        if (!empty($_POST['password']) && !isStrongPassword($_POST['password'])) {
            $data['errors']['password'] = "Password must be at least 8 characters with uppercase, lowercase, number, and special character";
        }

        // Validate role (only allow HR Admin and Recruitment Manager creation)
        $allowedRoles = [2, 3]; // HR Admin, Recruitment Manager
        if (!empty($_POST['role_id']) && !in_array((int) $_POST['role_id'], $allowedRoles)) {
            $data['errors']['role_id'] = "Invalid role selection";
        }

        if (empty($data['errors'])) {
            $userData = [
                'full_name' => trim($_POST['full_name']),
                'email' => strtolower(trim($_POST['email'])),
                'password' => $_POST['password'],
                'role_id' => (int) $_POST['role_id'],
                'phone' => $_POST['phone'] ?? '',
                'address' => $_POST['address'] ?? '',
                'status' => $_POST['status'] ?? 'active'
            ];

            if ($user->createUser($userData)) {
                AccessLog::log('user_created', 'Created user: ' . $userData['email']);
                $data['success'] = "User created successfully!";
            } else {
                $data['errors']['general'] = "Failed to create user";
            }
        }
    }

    private function handleGetUser(&$data, $user)
    {
        header('Content-Type: application/json');

        $userId = (int) ($_POST['user_id'] ?? 0);

        if (empty($userId)) {
            echo json_encode(['success' => false, 'message' => 'User ID is required']);
            return;
        }

        $userData = $user->first(['id' => $userId], []);

        if ($userData) {
            echo json_encode([
                'success' => true,
                'user' => $userData
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    }

    private function handleUpdateUser(&$data, $user)
    {
        $userId = (int) $_POST['user_id'];
        if (empty($userId)) {
            $data['errors']['general'] = "Invalid user ID";
            return;
        }

        // Don't allow updating own account through this interface
        if ($userId === Auth::user_id()) {
            $data['errors']['general'] = "Cannot modify your own account here. Use profile settings.";
            return;
        }

        $updateData = [
            'full_name' => trim($_POST['full_name']),
            'email' => strtolower(trim($_POST['email'])),
            'phone' => $_POST['phone'] ?? '',
            'address' => $_POST['address'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'role_id' => (int) ($_POST['role_id'] ?? 0),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Only update password if provided
        if (!empty($_POST['password'])) {
            if (isStrongPassword($_POST['password'])) {
                $updateData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $data['errors']['password'] = "Password must be at least 8 characters with uppercase, lowercase, number, and special character";
                return;
            }
        }

        if ($user->update($userId, $updateData)) {
            AccessLog::log('user_updated', 'Updated user ID: ' . $userId);
            $data['success'] = "User updated successfully!";
        } else {
            $data['errors']['general'] = "Failed to update user";
        }
    }

    private function handleDeleteUser(&$data, $user)
    {
        $userId = (int) $_POST['user_id'];
        if (empty($userId)) {
            $data['errors']['general'] = "Invalid user ID";
            return;
        }

        // Don't allow deleting own account
        if ($userId === Auth::user_id()) {
            $data['errors']['general'] = "Cannot delete your own account";
            return;
        }

        // Get user info for logging
        $userData = $user->first(['id' => $userId], []);

        if ($user->delete($userId)) {
            AccessLog::log('user_deleted', 'Deleted user: ' . ($userData['email'] ?? 'Unknown'));
            $data['success'] = "User deleted successfully!";
        } else {
            logger($userData);
            $data['errors']['general'] = "Failed to delete user";
        }
    }

    private function handleToggleStatus(&$data, $user)
    {
        $userId = (int) $_POST['user_id'];
        $newStatus = $_POST['status'];

        if (empty($userId) || !in_array($newStatus, ['active', 'inactive'])) {
            $data['errors']['general'] = "Invalid parameters";
            return;
        }

        // Don't allow deactivating own account
        if ($userId === Auth::user_id()) {
            $data['errors']['general'] = "Cannot modify your own account status";
            return;
        }

        if ($user->update($userId, ['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')])) {
            AccessLog::log('user_status_changed', "User ID $userId status changed to: $newStatus");
            $data['success'] = "User status updated successfully!";
        } else {
            $data['errors']['general'] = "Failed to update user status";
        }
    }

    private function getUsersWithRoles()
    {
        $user = new User();
        $query = "SELECT u.*, r.role_name 
                  FROM users u 
                  LEFT JOIN roles r ON u.role_id = r.id 
                  ORDER BY u.created_at DESC";

        return $user->query($query) ?: [];
    }

    public function create()
    {
        // Require System Admin role (role_id = 1)
        Auth::requireRole(1);

        // Set JSON response header
        header('Content-Type: application/json');

        // Check if user has System Admin privileges
        if (!Auth::hasRole(1)) {
            echo json_encode(['success' => false, 'message' => 'Insufficient privileges to create users']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $user = new User();
        $response = ['success' => false, 'message' => '', 'errors' => []];

        // Validate input
        $firstName = trim($_POST['firstName'] ?? '');
        $lastName = trim($_POST['lastName'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Validation
        if (empty($firstName)) {
            $response['errors']['firstName'] = 'First name is required';
        }
        if (empty($lastName)) {
            $response['errors']['lastName'] = 'Last name is required';
        }
        if (empty($email)) {
            $response['errors']['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = 'Invalid email format';
        } elseif ($user->emailExists($email)) {
            $response['errors']['email'] = 'Email already exists';
        }

        if (empty($role)) {
            $response['errors']['role'] = 'Role is required';
        } elseif (!in_array($role, ['system_admin', 'hr_admin', 'recruitment_manager'])) {
            $response['errors']['role'] = 'Invalid role';
        }

        if (empty($password)) {
            $response['errors']['password'] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $response['errors']['password'] = 'Password must be at least 8 characters';
        } elseif ($password !== $confirmPassword) {
            $response['errors']['password'] = 'Passwords do not match';
        }

        if (!empty($response['errors'])) {
            // logger($response['errors']);
            $response['message'] = 'Please fix the errors and try again';
            echo json_encode($response);
            return;
        }

        // Map role names to IDs
        $roleMap = [
            'system_admin' => 1,
            'hr_admin' => 2,
            'recruitment_manager' => 3
        ];

        $userData = [
            'full_name' => $firstName . ' ' . $lastName,
            'email' => $email,
            'password' => $password, // Will be hashed by the User model
            'role_id' => $roleMap[$role],
            'phone' => $phone,
            'status' => $status
        ];

        if ($user->createUser($userData)) {
            AccessLog::log('user_created', 'Created user: ' . $email);
            $response['success'] = true;
            $response['message'] = 'Staff account created successfully!';
        } else {
            // logger($userData);
            $response['message'] = 'Failed to create user account';
        }

        echo json_encode($response);
    }
}