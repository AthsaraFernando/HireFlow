<?php
// Database verification script
require_once '../app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>HireFlow Database Verification</h2>";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>Current Tables (" . count($tables) . "):</h3>";
    echo "<ul>";
    foreach($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Check required fields in users table
    echo "<h3>Users Table Structure:</h3>";
    $stmt = $pdo->query("DESCRIBE users");
    $userFields = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach($userFields as $field) {
        echo "<tr>";
        echo "<td>{$field['Field']}</td>";
        echo "<td>{$field['Type']}</td>";
        echo "<td>{$field['Null']}</td>";
        echo "<td>{$field['Key']}</td>";
        echo "<td>{$field['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check required fields in job_posts table
    echo "<h3>Job Posts Table Structure:</h3>";
    $stmt = $pdo->query("DESCRIBE job_posts");
    $jobFields = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach($jobFields as $field) {
        echo "<tr>";
        echo "<td>{$field['Field']}</td>";
        echo "<td>{$field['Type']}</td>";
        echo "<td>{$field['Null']}</td>";
        echo "<td>{$field['Key']}</td>";
        echo "<td>{$field['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Verify required fields according to DATABASE.md
    echo "<h3>Verification Results:</h3>";
    
    $requiredTables = [
        'roles', 'users', 'job_posts', 'applications', 
        'interviews', 'feedback', 'notifications', 
        'access_logs', 'system_settings'
    ];
    
    $missingTables = [];
    foreach($requiredTables as $table) {
        if(!in_array($table, $tables)) {
            $missingTables[] = $table;
        }
    }
    
    if(empty($missingTables)) {
        echo "<p style='color: green;'>✅ All required tables present!</p>";
    } else {
        echo "<p style='color: red;'>❌ Missing tables: " . implode(', ', $missingTables) . "</p>";
    }
    
    // Check if users table has all required fields
    $userFieldNames = array_column($userFields, 'Field');
    $requiredUserFields = [
        'id', 'full_name', 'email', 'password', 'phone', 'address',
        'role_id', 'status', 'profile_picture', 'last_login', 
        'created_at', 'updated_at'
    ];
    
    $missingUserFields = [];
    foreach($requiredUserFields as $field) {
        if(!in_array($field, $userFieldNames)) {
            $missingUserFields[] = $field;
        }
    }
    
    if(empty($missingUserFields)) {
        echo "<p style='color: green;'>✅ Users table has all required fields!</p>";
    } else {
        echo "<p style='color: red;'>❌ Users table missing fields: " . implode(', ', $missingUserFields) . "</p>";
    }
    
    // Check if job_posts table has all required fields
    $jobFieldNames = array_column($jobFields, 'Field');
    $requiredJobFields = [
        'id', 'hr_id', 'title', 'description', 'requirements', 
        'responsibilities', 'department', 'location', 'salary_range',
        'employment_type', 'experience_level', 'deadline', 'status', 
        'applications_count', 'created_at', 'updated_at'
    ];
    
    $missingJobFields = [];
    foreach($requiredJobFields as $field) {
        if(!in_array($field, $jobFieldNames)) {
            $missingJobFields[] = $field;
        }
    }
    
    if(empty($missingJobFields)) {
        echo "<p style='color: green;'>✅ Job posts table has all required fields!</p>";
    } else {
        echo "<p style='color: red;'>❌ Job posts table missing fields: " . implode(', ', $missingJobFields) . "</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database connection failed: " . $e->getMessage() . "</p>";
}
?>
