<?php

class PasswordReset extends Controller
{
    public function index()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
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
                    
                    $data['success'] = "If an account with that email exists, you will receive password reset link.";

                    
                    AccessLog::log('password_reset_request', 'Password reset requested for: ' . $email);

                    
                    if (DEBUG) {
                        // $data['debug_token'] = $token;
                        // $data['debug_link'] = ROOT . '/passwordreset/reset?token=' . $token;
                    }

                    $resetLink = ROOT . '/passwordreset/reset?token=' . urlencode($token);
                    $subject = 'Reset your HireFlow password';
                    $htmlBody = "
                        <p>Hello,</p>
                        <p>We received a request to reset your HireFlow password.</p>
                        <p>Click the link below to reset your password:</p>
                        <p><a href=\"{$resetLink}\">Reset Password</a></p>
                        <p>If the button does not work, copy and paste this URL:</p>
                        <p>{$resetLink}</p>
                        <p>This link will expire in 20 mins.</p>
                        <p>If you did not request this, you can ignore this email.</p>
                    ";
                    $textBody = "Reset your HireFlow password: {$resetLink} (expires in 20 mins).";
                
                    Mailer::send($email, $subject, $htmlBody, '', $textBody);

                } else {
                    
                    $data['success'] = "If an account with that email exists, you will receive password reset link.";
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
                $resettedUser = $user->resetPassword($token, $password);
                if ($resettedUser) {
                    
                    AccessLog::log('password_change', 'Password successfully reset', $resettedUser['id'], 0, $resettedUser['role_id']);

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
