<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', $_SERVER['SERVER_NAME'] === 'localhost' ? 'root' : '');
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