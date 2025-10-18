<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    die;
}

/**
 * Check if user is logged in
 */
function logged_in()
{
    return Auth::logged_in();
}

/**
 * Get current user
 */
function user()
{
    return Auth::user();
}

/**
 * Get user ID
 */
function user_id()
{
    return Auth::user_id();
}

/**
 * Get user role
 */
function user_role()
{
    return Auth::user_role();
}

/**
 * Generate CSRF token input field
 */
function csrf_token_input()
{
    $token = Auth::generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Get CSRF token
 */
function csrf_token()
{
    return Auth::generateCSRFToken();
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'Y-m-d H:i:s')
{
    if (empty($date) || $date === '0000-00-00 00:00:00') {
        return 'Never';
    }
    return date($format, strtotime($date));
}

/**
 * Get role name by ID
 */
function getRoleName($roleId)
{
    $roles = [
        1 => 'System Administrator',
        2 => 'HR Administrator',
        3 => 'Recruitment Manager',
        4 => 'Applicant'
    ];
    return $roles[$roleId] ?? 'Unknown';
}

/**
 * Generate random string
 */
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * Sanitize filename for upload
 */
function sanitizeFilename($filename)
{
    // Remove any character that isn't alphanumeric, dash, underscore, or dot
    $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $filename);
    return $filename;
}

/**
 * Format file size
 */
function formatFileSize($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

/**
 * Get time ago format
 */
function timeAgo($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Validate email format
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Check if password is strong
 */
function isStrongPassword($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

/**
 * Generate secure hash
 */
function generateHash($data)
{
    return hash('sha256', $data . date('Y-m-d H:i:s') . rand(1000, 9999));
}

function logger($data, $other = NULL) // Function to log data to a file for debugging purposes
{
    $logData = [
        'data' => $data,
        'other' => $other,
        'timestamp' => date('Y-m-d H:i:s')
    ];

    file_put_contents(
        'c:\\xampp\\htdocs\\HireFlow\\app\\controllers' . '/debug_logs.txt',
        print_r($logData, true) . "\n",
        FILE_APPEND
    );
}