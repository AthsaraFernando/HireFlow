<?php

/**
 * Profile Controller
 * Handles applicant profile management and account settings
 */
class Profile extends Controller
{
    use ApplicantBaseTrait;

    public function index()
    {
        Auth::requireRole(4);
        
        $data = [];
        $userModel = new User();
        $applicationModel = new Application();
        $interviewModel = new Interview();
        $user_id = Auth::user_id();
        
        // Get current user data
        $current_user = Auth::user();
        $application_stats = $applicationModel->getApplicationStats($user_id) ?: [];
        $interview_stats = $interviewModel->getInterviewCount($user_id) ?: [];
        $profile_picture_url = $this->getProfilePictureUrl($current_user['profile_picture'] ?? '');
        
        $data['user'] = [
            'id' => $current_user['id'],
            'name' => $current_user['full_name'] ?? 'Not provided',
            'email' => $current_user['email'] ?? 'Not provided',
            'phone' => $current_user['phone'] ?? 'Not provided',
            'location' => $current_user['address'] ?? 'Not provided',
            'profile_picture' => $current_user['profile_picture'] ?? '',
            'profile_picture_url' => $profile_picture_url,
            'created_at' => $current_user['created_at'] ?? '',
            'last_login' => $current_user['last_login'] ?? 'Never',
            'status' => $current_user['status'] ?? 'active',
            'role_label' => 'Applicant',
            'member_since' => !empty($current_user['created_at']) ? date('M j, Y', strtotime($current_user['created_at'])) : 'Not available',
            'last_login_display' => !empty($current_user['last_login']) ? date('M j, Y g:i A', strtotime($current_user['last_login'])) : 'Never',
            'bio' => 'Professional seeking new opportunities in the field.',
            'skills' => [],
            'experience' => [],
            'education' => []
        ];

        $data['form_values'] = [
            'full_name' => $current_user['full_name'] ?? '',
            'email' => $current_user['email'] ?? '',
            'phone' => $current_user['phone'] ?? '',
            'address' => $current_user['address'] ?? ''
        ];

        $data['application_stats'] = [
            'total_applications' => (int)($application_stats['total_applications'] ?? 0),
            'under_review_applications' => (int)($application_stats['under_review_applications'] ?? 0),
            'shortlisted_applications' => (int)($application_stats['shortlisted_applications'] ?? 0),
            'interview_scheduled' => (int)($application_stats['interview_scheduled'] ?? 0)
        ];

        $data['interview_stats'] = [
            'total_interviews' => (int)($interview_stats['total_interviews'] ?? 0),
            'upcoming_interviews' => (int)($interview_stats['upcoming_interviews'] ?? 0),
            'completed_interviews' => (int)($interview_stats['completed_interviews'] ?? 0)
        ];
        
        // Calculate profile completion
        $data['profile_completion'] = $this->calculateProfileCompletion($current_user);

        $this->view('applicant/profile', $data);
    }

    public function update()
    {
        Auth::requireRole(4);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('applicant/profile');
            return;
        }
        
        $userModel = new User();
        $user_id = Auth::user_id();
        $existing_user = $userModel->first(['id' => $user_id], []);
        $submit_section = $_POST['submit_section'] ?? '';
        $photo_intent = ($_POST['photo_upload_intent'] ?? '') === '1';
        $has_profile_picture_upload = isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK;
        $is_photo_only_request = $has_profile_picture_upload && (
            $submit_section === 'photo' ||
            ($submit_section !== 'personal' && $submit_section !== 'security' && $photo_intent)
        );

        // Photo-only update should not require personal info validation
        if ($is_photo_only_request) {
            if ($has_profile_picture_upload) {
                $upload_result = $this->handleProfilePictureUpload($_FILES['profile_picture'], $user_id);
                if ($upload_result['success']) {
                    $photo_update = [
                        'profile_picture' => $upload_result['path'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($userModel->update($user_id, $photo_update)) {
                        $_SESSION['USER'] = array_merge($_SESSION['USER'], $photo_update);
                        $_SESSION['success'] = 'Profile picture updated successfully!';
                    } else {
                        $_SESSION['error'] = 'Failed to update profile picture. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = $upload_result['error'];
                }
            } else {
                $_SESSION['error'] = 'Please select an image to upload.';
            }

            redirect('applicant/profile');
            return;
        }
        
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => strtolower(trim($_POST['email'] ?? '')),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? '')
        ];

        $password_change_requested = !empty($_POST['new_password']) || !empty($_POST['confirm_password']);

        if ($password_change_requested) {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($current_password)) {
                $_SESSION['error'] = 'Current password is required to change your password.';
                redirect('applicant/profile');
                return;
            }

            if (!$existing_user || !password_verify($current_password, $existing_user['password'])) {
                $_SESSION['error'] = 'Current password is incorrect.';
                redirect('applicant/profile');
                return;
            }

            if (empty($new_password)) {
                $_SESSION['error'] = 'New password is required.';
                redirect('applicant/profile');
                return;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = 'New passwords do not match.';
                redirect('applicant/profile');
                return;
            }

            $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $validation_data = $data;
        if ($password_change_requested) {
            $validation_data['password'] = $_POST['new_password'];
            $validation_data['confirm_password'] = $_POST['confirm_password'];
        }

        if (!$userModel->validateProfileUpdate($validation_data, $user_id)) {
            $_SESSION['error'] = implode(' ', $userModel->errors);
            redirect('applicant/profile');
            return;
        }
        
        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_result = $this->handleProfilePictureUpload($_FILES['profile_picture'], $user_id);
            if ($upload_result['success']) {
                $data['profile_picture'] = $upload_result['path'];
            } else {
                $_SESSION['error'] = $upload_result['error'];
                redirect('applicant/profile');
                return;
            }
        }
        
        // Remove empty values
        $data = array_filter($data, function($value) {
            return $value !== '';
        });
        
        if (!empty($data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            if ($userModel->update($user_id, $data)) {
                // Update session data
                $_SESSION['USER'] = array_merge($_SESSION['USER'], $data);
                $_SESSION['success'] = "Profile updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update profile. Please try again.";
            }
        }
        
        redirect('applicant/profile');
    }

    public function delete()
    {
        Auth::requireRole(4);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('applicant/profile');
            return;
        }

        $user_id = Auth::user_id();
        $userModel = new User();
        $existing_user = $userModel->first(['id' => $user_id], []);

        if (!$existing_user) {
            Auth::logout();
            redirect('signin');
            return;
        }

        $delete_confirmation = strtoupper(trim($_POST['delete_confirmation'] ?? ''));
        $delete_password = $_POST['delete_current_password'] ?? '';

        if ($delete_confirmation !== 'DELETE') {
            $_SESSION['error'] = 'Type DELETE to confirm profile deletion.';
            redirect('applicant/profile');
            return;
        }

        if (empty($delete_password) || !password_verify($delete_password, $existing_user['password'])) {
            $_SESSION['error'] = 'Current password is required to delete your profile.';
            redirect('applicant/profile');
            return;
        }

        $pdo = null;

        try {
            $pdo = $this->createDatabaseConnection();

            $pdo->beginTransaction();

            $now = date('Y-m-d H:i:s');
            $stamp = date('YmdHis');
            $anonymized_email = 'deleted+' . $user_id . '.' . $stamp . '@deleted.local';
            $replacement_password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

            $update_data = [
                'full_name' => 'Deleted Applicant #' . $user_id,
                'email' => $anonymized_email,
                'password' => $replacement_password,
                'status' => 'inactive',
                'phone' => null,
                'address' => null,
                'profile_picture' => null,
                'last_login' => null,
                'updated_at' => $now,
            ];

            if ($this->columnExists($pdo, 'users', 'password_reset_token')) {
                $update_data['password_reset_token'] = null;
            }

            if ($this->columnExists($pdo, 'users', 'password_reset_expires')) {
                $update_data['password_reset_expires'] = null;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_at')) {
                $update_data['deleted_at'] = $now;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_by')) {
                $update_data['deleted_by'] = $user_id;
            }

            if ($this->columnExists($pdo, 'users', 'deleted_email')) {
                $update_data['deleted_email'] = $existing_user['email'] ?? null;
            }

            if ($this->columnExists($pdo, 'users', 'delete_reason')) {
                $update_data['delete_reason'] = 'Self-service account closure';
            }

            $set_clauses = [];
            $params = ['user_id' => $user_id];

            foreach ($update_data as $column => $value) {
                $set_clauses[] = "$column = :$column";
                $params[$column] = $value;
            }

            $soft_delete_sql = 'UPDATE users SET ' . implode(', ', $set_clauses) . ' WHERE id = :user_id AND role_id = 4';
            $soft_delete_stmt = $pdo->prepare($soft_delete_sql);
            $soft_delete_stmt->execute($params);

            if ($soft_delete_stmt->rowCount() !== 1) {
                throw new RuntimeException('Unable to deactivate applicant profile.');
            }

            if ($this->tableExists($pdo, 'saved_jobs')) {
                $saved_jobs_stmt = $pdo->prepare('DELETE FROM saved_jobs WHERE applicant_id = :user_id');
                $saved_jobs_stmt->execute(['user_id' => $user_id]);
            }

            $pdo->commit();

            AccessLog::log('account_soft_deleted', 'Applicant self-deactivated account', $user_id);

            Auth::logout();
            redirect('signin?deleted=1');
            return;
        } catch (Throwable $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $_SESSION['error'] = 'Failed to deactivate profile. Please try again or contact support.';
            redirect('applicant/profile');
            return;
        }
    }
}
