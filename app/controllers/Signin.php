<?php

class Signin extends Controller
{
    public function index()
    {
        // Redirect if already logged in
        if (Auth::logged_in()) {
            $this->redirectToUserDashboard();
            return;
        }

        $data = [];
        $user = new User;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('home', $data);
                return;
            }

            // Check for rate limiting
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $accessLog = new AccessLog();
            
            if ($accessLog->isIPBlocked($ipAddress)) {
                $data['errors']['general'] = "Too many failed login attempts. Please try again later.";
                AccessLog::log('blocked_login_attempt', "IP blocked due to excessive failed attempts");
                $this->view('home', $data);
                return;
            }

            // Validate login
            if ($user->signInValidate($_POST, $user)) {
                // Log successful login
                AccessLog::log('login', 'User logged in successfully');
                
                $this->redirectToUserDashboard();
                return;
            } else {
                // Log failed login attempt
                AccessLog::log('failed_login', 'Failed login attempt for email: ' . ($_POST['email'] ?? 'unknown'));
            }
        }

        // Check for logout message
        if (isset($_GET['logout'])) {
            $data['success'] = "You have been logged out successfully.";
        }

        // Check for session timeout
        if (isset($_GET['timeout'])) {
            $data['errors']['general'] = "Your session has expired. Please login again.";
        }

        // Check for registration success
        if (isset($_GET['registered'])) {
            $data['success'] = "Registration successful! Please login with your credentials.";
        }

        $data['errors'] = $user->errors;
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('home', $data);
    }

    private function redirectToUserDashboard()
    {
        $user_role = Auth::user_role();
        
        switch ($user_role) {
            case 1: // System Admin
                redirect('systemadmin/dashboard');
                break;
            case 2: // HR Admin
                redirect('hradmin/dashboard');
                break;
            case 3: // Recruitment Manager
                redirect('manager/dashboard');
                break;
            case 4: // Applicant
                redirect('applicant/dashboard');
                break;
            default:
                Auth::logout();
                redirect('signin?error=invalid_role');
                break;
        }
    }
}