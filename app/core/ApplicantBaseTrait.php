<?php

/**
 * ApplicantBaseTrait
 * Shared methods and utilities for all applicant controllers
 */
trait ApplicantBaseTrait
{
    /**
     * Get lightweight user data (name, email)
     */
    protected function getUserData($user_id)
    {
        $userModel = new User();
        $users = $userModel->where(['id' => $user_id]);
        $current_user = $users[0] ?? null;
        
        return [
            'name' => $current_user['full_name'] ?? 'User',
            'email' => $current_user['email'] ?? ''
        ];
    }

    /**
     * Calculate profile completion percentage
     */
    protected function calculateProfileCompletion($user)
    {
        $completion = 0;
        $total_fields = 6;
        
        if (!empty($user['full_name'])) $completion++;
        if (!empty($user['email'])) $completion++;
        if (!empty($user['phone'])) $completion++;
        if (!empty($user['address'])) $completion++;
        if (!empty($user['profile_picture'])) $completion++;
        if (isset($user['created_at'])) $completion++; // Basic setup completion
        
        return round(($completion / $total_fields) * 100);
    }

    /**
     * Get application form category labels
     */
    protected function getApplicationFormCategoryLabels()
    {
        return [
            'personal_info' => 'Personal Information',
            'education' => 'Education Details',
            'work_experience' => 'Work Experience',
            'skills' => 'Skills & Competencies',
            'documents' => 'Resume & Documents',
            'availability' => 'Availability & Expectations',
            'declarations' => 'Declarations & Consent',
            'additional_info' => 'Additional Information'
        ];
    }

    /**
     * Extract a file from form files array
     */
    protected function extractFormFile($formFiles, $fieldName)
    {
        if (!$formFiles || !isset($formFiles['name'][$fieldName])) {
            return null;
        }

        return [
            'name' => $formFiles['name'][$fieldName],
            'type' => $formFiles['type'][$fieldName],
            'tmp_name' => $formFiles['tmp_name'][$fieldName],
            'error' => $formFiles['error'][$fieldName],
            'size' => $formFiles['size'][$fieldName],
        ];
    }

    /**
     * Handle dynamic form file uploads (resumes, documents)
     */
    protected function handleDynamicFormFileUpload($file, $user_id, $strict_pdf = false)
    {
        $upload_dir = $this->publicPath('uploads/resumes');

        if (!is_dir($upload_dir) && !@mkdir($upload_dir, 0755, true)) {
            return ['success' => false, 'error' => 'Failed to create resume upload directory. Please contact support.'];
        }

        if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
            return ['success' => false, 'error' => 'Resume upload directory is not writable on this server.'];
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'Temporary upload file is not available. Check PHP upload_tmp_dir settings.'];
        }

        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $max_size = 5242880; // 5MB

        if ($strict_pdf) {
            if ($file_extension !== 'pdf') {
                return ['success' => false, 'error' => 'Resume must be a PDF file.'];
            }
        } else {
            $allowed_extensions = ['pdf', 'doc', 'docx'];
            if (!in_array($file_extension, $allowed_extensions, true)) {
                return ['success' => false, 'error' => 'Uploaded file type is not allowed.'];
            }
        }

        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'File size must be less than 5MB.'];
        }

        $filename = 'resume_' . $user_id . '_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $file_extension;
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => false, 'error' => 'Failed to upload file. Server blocked moving uploaded file.'];
        }

        return ['success' => true, 'path' => '/uploads/resumes/' . $filename];
    }

    /**
     * Get upload error message from error code
     */
    protected function getUploadErrorMessage($errorCode, $fieldLabel = 'File')
    {
        switch ((int)$errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return $fieldLabel . ' exceeds the maximum upload size.';
            case UPLOAD_ERR_PARTIAL:
                return $fieldLabel . ' was only partially uploaded. Please retry.';
            case UPLOAD_ERR_NO_FILE:
                return $fieldLabel . ' is required.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Temporary upload directory is missing on server.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Server cannot write uploaded files to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension blocked the file upload.';
            default:
                return 'Failed to upload ' . strtolower($fieldLabel) . '.';
        }
    }

    /**
     * Build dynamic application summary from form and responses
     */
    protected function buildDynamicApplicationSummary($form, $responses)
    {
        $lines = [];
        $lines[] = "Submitted via dynamic application form: " . ($form['form_title'] ?? 'Application Form');

        foreach ($form['fields'] as $field) {
            $name = $field['field_name'];
            if (!isset($responses[$name])) {
                continue;
            }

            if ($field['field_type'] === 'file') {
                continue;
            }

            $value = is_scalar($responses[$name]) ? (string)$responses[$name] : '';
            if ($value === '') {
                continue;
            }

            $lines[] = $field['field_label'] . ': ' . $value;
        }

        $summary = implode("\n", $lines);
        return mb_substr($summary, 0, 60000);
    }

    /**
     * Parse dynamic application summary back into field values
     */
    protected function parseDynamicApplicationSummary($cover_letter)
    {
        $values_by_label = [];
        $lines = preg_split('/\r\n|\r|\n/', (string)$cover_letter);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || stripos($line, 'Submitted via dynamic application form:') === 0) {
                continue;
            }

            $separator_pos = strpos($line, ':');
            if ($separator_pos === false) {
                continue;
            }

            $label = trim(substr($line, 0, $separator_pos));
            $value = trim(substr($line, $separator_pos + 1));

            if ($label !== '') {
                $values_by_label[$label] = $value;
            }
        }

        return $values_by_label;
    }

    /**
     * Extract resume from dynamic form files
     */
    protected function extractResumeFromDynamicFiles($form_files)
    {
        if (!$form_files || !isset($form_files['name']) || !is_array($form_files['name'])) {
            return null;
        }

        foreach ($form_files['name'] as $field_name => $name) {
            if (stripos((string)$field_name, 'resume') !== false) {
                $error = $form_files['error'][$field_name] ?? UPLOAD_ERR_NO_FILE;
                if ($error === UPLOAD_ERR_OK) {
                    return [
                        'name' => $name,
                        'type' => $form_files['type'][$field_name] ?? '',
                        'tmp_name' => $form_files['tmp_name'][$field_name] ?? '',
                        'error' => $error,
                        'size' => $form_files['size'][$field_name] ?? 0,
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Handle resume upload (for legacy flows)
     */
    protected function handleResumeUpload($file, $user_id)
    {
        $upload_dir = $this->publicPath('uploads/resumes');
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir) && !@mkdir($upload_dir, 0755, true)) {
            return ['success' => false, 'error' => 'Failed to create resume upload directory.'];
        }

        if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
            return ['success' => false, 'error' => 'Resume upload directory is not writable on this server.'];
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'Temporary upload file is not available. Check PHP upload settings.'];
        }
        
        // Validate file type - Only PDF allowed
        $allowed_types = ['application/pdf'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($file['type'], $allowed_types) || $file_extension !== 'pdf') {
            return ['success' => false, 'error' => 'Only PDF files are allowed.'];
        }
        
        // Validate file size (5MB max)
        if ($file['size'] > 5242880) {
            return ['success' => false, 'error' => 'File size must be less than 5MB.'];
        }
        
        // Generate unique filename
        $filename = 'resume_' . $user_id . '_' . time() . '.pdf';
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => true, 'path' => '/uploads/resumes/' . $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload file.'];
        }
    }

    /**
     * Get public path for file operations
     */
    protected function publicPath($relative = '')
    {
        // app/core -> project root (HireFlow)
        $project_root = dirname(__DIR__, 2);
        $public_root = rtrim($project_root . '/public', '/');

        // Fallback for setups where web root points directly to /public
        if (!is_dir($public_root) && !empty($_SERVER['DOCUMENT_ROOT'])) {
            $doc_root = rtrim((string)$_SERVER['DOCUMENT_ROOT'], '/');
            if (is_dir($doc_root)) {
                $public_root = $doc_root;
            }
        }

        if ($relative === '' || $relative === null) {
            return $public_root;
        }

        return $public_root . '/' . ltrim($relative, '/');
    }

    /**
     * Ensure resume file is accessible from public directory
     */
    protected function ensureResumeFileAccessible($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);

        if (file_exists($expected)) {
            return;
        }

        // Legacy fallback for previously uploaded files written to nested path
        $legacy = $this->publicPath('HireFlow/public/' . $relative);
        if (!file_exists($legacy)) {
            return;
        }

        $target_dir = dirname($expected);
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        @copy($legacy, $expected);
    }

    /**
     * Delete uploaded resume file
     */
    protected function deleteResumeFile($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);
        $legacy = $this->publicPath('HireFlow/public/' . $relative);

        if (file_exists($expected)) {
            @unlink($expected);
        }

        if (file_exists($legacy)) {
            @unlink($legacy);
        }
    }

    /**
     * Handle profile picture upload
     */
    protected function handleProfilePictureUpload($file, $user_id)
    {
        $upload_dir = $this->publicPath('uploads/profiles');
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            return ['success' => false, 'error' => 'Only JPEG, PNG, and GIF images are allowed.'];
        }
        
        // Validate file size (2MB max)
        if ($file['size'] > 2097152) {
            return ['success' => false, 'error' => 'Image size must be less than 2MB.'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
        $file_path = rtrim($upload_dir, '/') . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => true, 'path' => '/uploads/profiles/' . $filename];
        } else {
            return ['success' => false, 'error' => 'Failed to upload image.'];
        }
    }

    /**
     * Get profile picture URL with fallback to default
     */
    protected function getProfilePictureUrl($profile_picture)
    {
        $default = ROOT . '/assets/images/profiles/default-avatar.jpg';

        if (empty($profile_picture)) {
            return $default;
        }

        $relative = ltrim($profile_picture, '/');
        $expected = $this->publicPath($relative);
        if (file_exists($expected)) {
            return ROOT . '/' . $relative;
        }

        $legacy = $this->publicPath('HireFlow/public/' . $relative);
        if (file_exists($legacy)) {
            $target_dir = dirname($expected);
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            @copy($legacy, $expected);
            return ROOT . '/' . $relative;
        }

        return $default;
    }

    /**
     * Delete uploaded asset file
     */
    protected function deleteUploadedAsset($web_path)
    {
        if (empty($web_path)) {
            return;
        }

        $relative = ltrim($web_path, '/');
        $expected = $this->publicPath($relative);
        $legacy = $this->publicPath('HireFlow/public/' . $relative);

        if (file_exists($expected)) {
            @unlink($expected);
        }

        if (file_exists($legacy)) {
            @unlink($legacy);
        }
    }

    /**
     * Check if table exists in database
     */
    protected function tableExists(PDO $pdo, $table_name)
    {
        $query = 'SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = :schema_name AND TABLE_NAME = :table_name LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'schema_name' => DB_NAME,
            'table_name' => $table_name
        ]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * Check if column exists in table
     */
    protected function columnExists(PDO $pdo, $table_name, $column_name)
    {
        $query = 'SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :schema_name AND TABLE_NAME = :table_name AND COLUMN_NAME = :column_name LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'schema_name' => DB_NAME,
            'table_name' => $table_name,
            'column_name' => $column_name
        ]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * Create database connection
     */
    protected function createDatabaseConnection()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
        return new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    /**
     * Build notification feed for applicant
     */
    protected function buildApplicantNotificationFeed($user_id, $limit = 20)
    {
        $notificationModel = new Notification();
        $notificationModel->syncApplicantNotifications($user_id);
        $rows = $notificationModel->getUserNotifications($user_id, $limit);
        $notifications = [];

        if ($rows && is_array($rows)) {
            foreach ($rows as $row) {
                $title = trim((string)($row['title'] ?? 'Notification'));
                $message = trim((string)($row['message'] ?? ''));
                $type = trim((string)($row['type'] ?? 'info'));
                $isRead = ((int)($row['is_read'] ?? 0)) === 1;
                $createdAt = $row['created_at'] ?? null;
                if (empty($createdAt)) {
                    $createdAt = date('Y-m-d H:i:s');
                }

                $isFeedback = stripos($title, 'Feedback') !== false;
                $category = $isFeedback ? 'feedback' : 'interview';
                $link = $isFeedback ? ROOT . '/applicant/interviews/feedback' : ROOT . '/applicant/interviews';

                $notifications[] = [
                    'id' => (int)($row['id'] ?? 0),
                    'category' => $category,
                    'title' => $title,
                    'message' => $message,
                    'type' => in_array($type, ['info', 'success', 'warning', 'error'], true) ? $type : 'info',
                    'is_read' => $isRead,
                    'link' => $link,
                    'link_label' => $isFeedback ? 'Open feedback' : 'Open interview',
                    'created_at' => $createdAt,
                    'created_at_display' => date('M d, Y g:i A', strtotime($createdAt)),
                ];
            }
        }

        return $notifications;
    }
}
