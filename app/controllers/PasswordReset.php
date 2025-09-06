<?php

class PasswordReset extends Controller
{
    public function index()
    {
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('password-reset', $data);
                return;
            }

            $email = trim($_POST['email']);
            
            if (empty($email)) {
                $data['errors']['email'] = "Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = "Please enter a valid email address";
            } else {
                $user = new User();
                $token = $user->generatePasswordResetToken($email);
                
                if ($token) {
                    // In a real application, you would send an email here
                    // For now, we'll just show a success message
                    $data['success'] = "If an account with that email exists, you will receive password reset instructions.";
                    
                    // Log password reset request
                    AccessLog::log('password_reset_request', 'Password reset requested for: ' . $email);
                    
                    // For development, you might want to show the token
                    if (DEBUG) {
                        $data['debug_token'] = $token;
                        $data['debug_link'] = ROOT . '/password-reset/reset?token=' . $token;
                    }
                } else {
                    // Don't reveal if email exists or not for security
                    $data['success'] = "If an account with that email exists, you will receive password reset instructions.";
                }
            }
        }

        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('password-reset', $data);
    }

    public function reset()
    {
        $data = [];
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            redirect('password-reset');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('password-reset-form', $data);
                return;
            }

            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validate password
            if (empty($password)) {
                $data['errors']['password'] = "Password is required";
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
                $data['errors']['password'] = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character";
            }
            
            if (empty($confirmPassword)) {
                $data['errors']['confirm_password'] = "Please confirm your password";
            } elseif ($password !== $confirmPassword) {
                $data['errors']['confirm_password'] = "Passwords do not match";
            }

            if (empty($data['errors'])) {
                $user = new User();
                if ($user->resetPassword($token, $password)) {
                    // Log successful password reset
                    AccessLog::log('password_reset_success', 'Password successfully reset');
                    
                    redirect('signin?password_reset=1');
                    return;
                } else {
                    $data['errors']['general'] = "Invalid or expired reset token. Please request a new password reset.";
                }
            }
        }

        $data['token'] = $token;
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('password-reset-form', $data);
    }
}
