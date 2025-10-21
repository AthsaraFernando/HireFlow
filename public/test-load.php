<?php
// Simple test to check what's working
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br><br>";

// Test 1: Check if config file exists
echo "<h3>Test 1: Config file</h3>";
if (file_exists("../app/core/config.php")) {
    echo "✓ config.php exists<br>";
    require "../app/core/config.php";
    echo "✓ config.php loaded successfully<br>";
    echo "DB_NAME: " . DB_NAME . "<br>";
    echo "ROOT: " . ROOT . "<br>";
} else {
    echo "✗ config.php not found<br>";
}

// Test 2: Check database connection
echo "<h3>Test 2: Database Connection</h3>";
try {
    $string = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
    $pdo = new PDO($string, DB_USER, DB_PASS);
    echo "✓ Database connection successful<br>";
} catch (PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "<br>";
}

// Test 3: Check if core files exist
echo "<h3>Test 3: Core Files</h3>";
$coreFiles = [
    'functions.php',
    'Database.php', 
    'Model.php',
    'Controller.php',
    'Auth.php',
    'App.php'
];

foreach ($coreFiles as $file) {
    $path = "../app/core/" . $file;
    if (file_exists($path)) {
        echo "✓ $file exists<br>";
    } else {
        echo "✗ $file NOT found<br>";
    }
}

// Test 4: Try requiring init.php
echo "<h3>Test 4: Loading init.php</h3>";
try {
    require "../app/core/init.php";
    echo "✓ init.php loaded successfully<br>";
} catch (Exception $e) {
    echo "✗ Error loading init.php: " . $e->getMessage() . "<br>";
}

echo "<h3>Test 5: Check if classes are available</h3>";
echo "App class exists: " . (class_exists('App') ? '✓ Yes' : '✗ No') . "<br>";
echo "Auth class exists: " . (class_exists('Auth') ? '✓ Yes' : '✗ No') . "<br>";
echo "Database trait exists: " . (trait_exists('Database') ? '✓ Yes' : '✗ No') . "<br>";

echo "<br><h3>All tests completed!</h3>";
