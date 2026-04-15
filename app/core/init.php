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
    $coresPath = "../app/cores/" . ucfirst($className) . ".php";
    
    if (file_exists($modelPath)) {
        require $modelPath;
    } elseif (file_exists($corePath)) {
        require $corePath;
    } elseif (file_exists($coresPath)) {
        require $coresPath;
    }
});

// Use __DIR__ to ensure we load project files, not system files

// Load shared applicant trait explicitly because traits must be available
// before controller classes that `use` them are parsed.
$applicantTraitPath = dirname(__DIR__) . '/core/ApplicantBaseTrait.php';
if (file_exists($applicantTraitPath)) {
    require_once $applicantTraitPath;
}

// Load Composer autoloader (for PHPMailer and other vendor packages)
$composerAutoload = dirname(__DIR__, 2) . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/Model.php';
require __DIR__ . '/Controller.php';
require __DIR__ . '/Auth.php';
require __DIR__ . '/App.php';