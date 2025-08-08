<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'hireflow_db');
    define('DB_DRIVER', '');
    define('ROOT', 'http://localhost/HireFlow/public');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'hireflow_db');
    define('DB_DRIVER', '');
    define('ROOT', 'https://www.yourwebsite.com');
}

define('APP_NAME', 'My Website');

// true means show errors
define('DEBUG', true);