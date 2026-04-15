<?php

class Usermanage extends Controller
{
    public function index()
    {
        Auth::requireRole(1);

        $data = [];
        $user = new User();
        $role = new Role();

        $canManageUsers = Auth::hasRole(1);
        $data['can_manage_users'] = $canManageUsers;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                        return;
                    case 'update':
                        $this->handleUpdateUser($data, $user);
                        return;
                    case 'delete':
                        $this->handleDeleteUser($data, $user);
                        return;
                    case 'toggle_status':
                        $this->handleToggleStatus($data, $user);
                        return;
                    case 'fetch':
                        $this->handleGetUser($data, $user);
                        return;
                    default:
                        $data['errors']['general'] = "Invalid action";
                        return;
                }
            }

        }

        $data['users'] = $user->getUsersWithRoles();
        $data['roles'] = $role->findAll();
        $data['csrf_token'] = Auth::generateCSRFToken();
        $data['page_title'] = 'User Management';

        $data['view'] = 'usermanage';
        $this->view('systemadmin', $data);
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
            echo json_encode([
                'success' => true
            ]);
            exit;
        } else {
            $data['errors']['general'] = "Failed to update user";
            echo json_encode([
                'success' => false
            ]);
            exit;
        }
    }

    private function handleDeleteUser(&$data, $user)
    {
        $userId = (int) $_POST['user_id'];
        if (empty($userId)) {
            $data['errors']['general'] = "Invalid user ID";
            return;
        }

        if ($userId === Auth::user_id()) {
            $data['errors']['general'] = "Cannot delete your own account";
            return;
        }

        $userData = $user->first(['id' => $userId], []);

        if ($user->delete($userId)) {
            AccessLog::log('user_deleted', 'Deleted user: ' . ($userData['email'] ?? 'Unknown'));
            $data['success'] = "User deleted successfully!";
            echo json_encode([
                'success' => true
            ]);
            exit;
        } else {
            $data['errors']['general'] = "Failed to delete user";
            echo json_encode([
                'success' => false
            ]);
            exit;
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

        if ($userId === Auth::user_id()) {
            $data['errors']['general'] = "Cannot modify your own account status";
            return;
        }

        if ($user->update($userId, ['status' => $newStatus, 'updated_at' => date('Y-m-d H:i:s')])) {
            AccessLog::log('user_status_changed', "User ID $userId status changed to: $newStatus");
            $data['success'] = "User status updated successfully!";
            echo json_encode([
                'success' => true
            ]);
            exit;
        } else {
            $data['errors']['general'] = "Failed to update user status";
            echo json_encode([
                'success' => false
            ]);
            exit;
        }
    }

    public function sendAccountCreationEmail($email, $initialPassword)
    {
        $loginLink = ROOT . '/';
        $subject = 'Your HireFlow account is ready';
        $htmlBody = "
                <p>Hello,</p>
                <p>Your HireFlow account has been created.</p>
                <p>Email: {$email}</p>
                <p>Temporary Password: {$initialPassword}</p>
                <p>You can log in here:</p>
                <p><a href=\"{$loginLink}\">Login</a></p>
                <p>Please change your password after logging in.</p>
                <p>If you did not expect this account, you can ignore this email.</p>
        ";
        $textBody = "Your HireFlow account has been created.\n
        Email: {$email}\n
        Temporary Password: {$initialPassword}\n
        Login: {$loginLink}\n
        Please change your password in the Profile section after logging in.";
        Mailer::send($email, $subject, $htmlBody, '', $textBody);
    }
    public function handleCreateUser(&$data, $user)
    {
        $firstName = trim($_POST['firstName'] ?? '');
        $lastName = trim($_POST['lastName'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if (empty($firstName)) {
            $data['errors']['firstName'] = 'First name is required';
        }
        if (empty($lastName)) {
            $data['errors']['lastName'] = 'Last name is required';
        }
        if (empty($email)) {
            $data['errors']['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['errors']['email'] = 'Invalid email format';
        } elseif ($user->emailExists($email)) {
            $data['errors']['email'] = 'Email already exists';
        }

        if (empty($role)) {
            $data['errors']['role'] = 'Role is required';
        } elseif (!in_array($role, ['system_admin', 'hr_admin', 'recruitment_manager'])) {
            $data['errors']['role'] = 'Invalid role';
        }

        if (empty($password)) {
            $data['errors']['password'] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $data['errors']['password'] = 'Password must be at least 8 characters';
        } elseif ($password !== $confirmPassword) {
            $data['errors']['password'] = 'Passwords do not match';
        }

        if (!empty($data['errors'])) {
            $data['message'] = 'Please fix the errors and try again';
            echo json_encode($data);
            return;
        }

        $roleMap = [
            'system_admin' => 1,
            'hr_admin' => 2,
            'recruitment_manager' => 3
        ];

        $userData = [
            'full_name' => $firstName . ' ' . $lastName,
            'email' => $email,
            'password' => $password,
            'role_id' => $roleMap[$role],
            'phone' => $phone,
            'status' => $status
        ];

        if ($user->createUser($userData)) {
            $this->sendAccountCreationEmail($userData['email'], $userData['password']);
            AccessLog::log('user_created', 'Created user: ' . $email);
            $data['success'] = true;
            $data['message'] = 'Staff account created successfully!';
        } else {
            $data['message'] = 'Failed to create user account';
        }

        echo json_encode($data);
        exit;
    }

}