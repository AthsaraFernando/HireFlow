<?php
// Clear all users from the users table
require_once 'app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🧹 Clearing Users Table</h2>";
    
    // Show current users before deletion
    $stmt = $pdo->query("SELECT email, full_name, role_id FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "<h3>Current Users (to be deleted):</h3>";
        foreach ($users as $user) {
            echo "<p>- {$user['email']} ({$user['full_name']}) - Role ID: {$user['role_id']}</p>";
        }
    } else {
        echo "<p>No users found in table.</p>";
    }
    
    // Clear all users
    $deletedCount = $pdo->exec("DELETE FROM users");
    echo "<h3>✅ Deletion Complete</h3>";
    echo "<p>Deleted {$deletedCount} user(s)</p>";
    
    // Verify table is empty
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Current user count: {$count['count']}</p>";
    
    if ($count['count'] == 0) {
        echo "<p style='color: green; font-weight: bold;'>✅ Users table is now empty and ready for fresh setup!</p>";
        echo "<p>🔗 <a href='admin-setup.php' style='color: #667eea; font-weight: bold;'>Create Your System Administrator Account</a></p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
}
h2, h3 { color: #333; }
p { margin: 8px 0; }
a { 
    color: #667eea; 
    text-decoration: none; 
    font-weight: bold; 
    padding: 10px 20px;
    background: #e8f0ff;
    border-radius: 5px;
    display: inline-block;
    margin-top: 10px;
}
a:hover { background: #d0e4ff; }
</style>
