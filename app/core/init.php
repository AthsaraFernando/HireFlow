<?php

// Start secure session
if (session_status() === PHP_SESSION_NONE) {
    // Secure session configuration
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes
    
    session_start();
    
    // Regenerate session ID periodically for security
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    } elseif (time() - $_SESSION['created'] > 1800) { // 30 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

// Autoload models and core classes
spl_autoload_register(function ($className) {
    $modelPath = "../app/models/" . ucfirst($className) . ".php";
    $corePath = "../app/core/" . ucfirst($className) . ".php";
    
    if (file_exists($modelPath)) {
        require $modelPath;
    } elseif (file_exists($corePath)) {
        require $corePath;
    }
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'Auth.php';
require 'App.php';