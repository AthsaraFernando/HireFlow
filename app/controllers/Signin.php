<?php

class Signin extends Controller
{
    public function index()
    {
        // Handle logout request from signin page
        if (isset($_GET['logout']) && Auth::logged_in()) {
            Auth::logout();
            redirect('signin?logout=1');
            return;
        }
        
        // Show logout prompt if user is logged in but trying to access signin
        if (Auth::logged_in()) {
            // Show a page asking if they want to logout first
            $data = [];
            $data['current_user'] = Auth::user();
            $data['current_role'] = getRoleName(Auth::user_role());
            $data['show_logout_prompt'] = true;
            $this->view('home', $data);
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

        // Check for account deletion success
        if (isset($_GET['deleted'])) {
            $data['success'] = "Your account was deactivated successfully.";
        }
        
        // Check if authentication was required
        if (isset($_GET['required'])) {
            $data['errors']['general'] = "Please login to access that page.";
        }

        $data['errors'] = $user->errors;
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('home', $data);
    }

    private function redirectToUserDashboard()
    {
        // Check if there's a redirect URL stored
        if (isset($_SESSION['redirect_after_login'])) {
            $redirectUrl = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            
            // Clean the URL to remove the /HireFlow/public prefix
            $redirectUrl = str_replace('/HireFlow/public/', '', $redirectUrl);
            $redirectUrl = ltrim($redirectUrl, '/');
            
            // Validate that the redirect URL is safe (within our application)
            if (!empty($redirectUrl) && !preg_match('/^https?:\/\//', $redirectUrl)) {
                redirect($redirectUrl);
                return;
            }
        }
        
        // Default role-based redirect
        $user_role = Auth::user_role();
        
        switch ($user_role) {
            case 1: // System Admin
                redirect('systemadmin/dashboard');
                break;
            case 2: // HR Admin
                redirect('hradmin/dashboard');
                break;
            case 3: // Recruitment Manager
                redirect('recruitment/dashboard');
                break;
            case 4: // Applicant
                redirect('applicant');
                break;
            default:
                Auth::logout();
                redirect('signin?error=invalid_role');
                break;
        }
    }
}