<?php
// Clean hardcoded users from database
require_once 'app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🧹 Cleaning Hardcoded Users</h2>";
    
    // Check current users
    $stmt = $pdo->query("SELECT email, full_name FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Current Users:</h3>";
    foreach ($users as $user) {
        echo "<p>- {$user['email']} ({$user['full_name']})</p>";
    }
    
    // Delete hardcoded accounts
    $stmt = $pdo->prepare("DELETE FROM users WHERE email IN ('admin@hireflow.com', 'test@hireflow.com', 'hr@hireflow.com', 'recruiter@hireflow.com')");
    $deletedCount = $stmt->execute();
    
    echo "<h3>✅ Cleanup Complete</h3>";
    echo "<p>Deleted hardcoded accounts</p>";
    
    // Check remaining users
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Remaining users: {$count['count']}</p>";
    
    // Show remaining users
    $stmt = $pdo->query("SELECT email, full_name FROM users");
    $remainingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($remainingUsers) > 0) {
        echo "<h3>Remaining Users:</h3>";
        foreach ($remainingUsers as $user) {
            echo "<p>- {$user['email']} ({$user['full_name']})</p>";
        }
    } else {
        echo "<p>✅ No hardcoded users remaining. Ready for fresh setup!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2 { color: #333; }
p { margin: 5px 0; }
</style>
