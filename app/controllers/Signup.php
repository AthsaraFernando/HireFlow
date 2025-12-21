<?php

class Signup extends Controller
{
    public function index()
    {
        // Redirect if already logged in
        if (Auth::logged_in()) {
            redirect('home');
            return;
        }

        $data = [];
        $user = new User;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check for CSRF token
            if (!isset($_POST['csrf_token']) || !Auth::verifyCSRFToken($_POST['csrf_token'])) {
                $data['errors']['general'] = "Invalid request. Please try again.";
                $this->view('signup', $data);
                return;
            }

            // Validate signup data
            if ($user->signUpValidate($_POST)) {
                // Prepare user data
                $userData = [
                    'full_name' => trim($_POST['first_name'] . ' ' . $_POST['last_name']),
                    'email' => strtolower(trim($_POST['email'])),
                    'password' => $_POST['password'],
                    'phone' => $_POST['phone'] ?? '',
                    'address' => $_POST['address'] ?? '',
                    'role_id' => 4, // Applicant role only
                    'status' => 'active'
                ];

                // Create user account
                if ($user->createUser($userData)) {
                    // Log registration
                    AccessLog::log('registration', 'New applicant account created: ' . $userData['email'], Auth::user_id());
                    // Redirect to login with success message
                    redirect('signin?registered=1');
                    return;
                } else {
                    $data['errors']['general'] = "Registration failed. Please try again.";
                }
            }
        }

        $data['errors'] = $user->errors;
        $data['csrf_token'] = Auth::generateCSRFToken();
        $this->view('signup', $data);
    }
}