<?php
if (!function_exists('hireflow_env')) {
    function hireflow_env($key, $default = null)
    {
        $value = getenv($key);
        return $value !== false && $value !== '' ? $value : $default;
    }
}

$document_root = strtolower($_SERVER['DOCUMENT_ROOT'] ?? '');
$is_mamp = strpos($document_root, '/applications/mamp') !== false;
$is_xampp = strpos($document_root, 'xampp') !== false;

define('DB_HOST', hireflow_env('DB_HOST', 'localhost'));
define('DB_PORT', (int) hireflow_env('DB_PORT', $is_mamp ? 8889 : 3306));
define('DB_USER', hireflow_env('DB_USER', 'root'));
define('DB_PASS', hireflow_env('DB_PASS', $is_mamp ? 'root' : ''));
define('DB_NAME', 'hireflow_db');
define('DB_DRIVER', '');

$request_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
    ? 'https'
    : 'http';

$request_host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');
$script_dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

define('ROOT', $request_scheme . '://' . $request_host . $script_dir);

define('APP_NAME', 'My Website');

// true means show errors
define('DEBUG', true);