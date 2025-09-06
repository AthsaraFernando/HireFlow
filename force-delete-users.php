<?php
// Force delete all users from the database
require_once 'app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🗑️ Force Deleting All Users</h2>";
    
    // First, let's see what's currently in the table
    echo "<h3>Current Users in Database:</h3>";
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Email</th><th>Full Name</th><th>Role ID</th><th>Status</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['full_name']}</td>";
            echo "<td>{$user['role_id']}</td>";
            echo "<td>{$user['status']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Force delete with multiple methods
        echo "<h3>🔥 Executing Force Delete...</h3>";
        
        // Method 1: Simple DELETE
        $result1 = $pdo->exec("DELETE FROM users");
        echo "<p>Method 1 (DELETE): Affected {$result1} rows</p>";
        
        // Method 2: TRUNCATE (resets auto-increment)
        $result2 = $pdo->exec("TRUNCATE TABLE users");
        echo "<p>Method 2 (TRUNCATE): Executed</p>";
        
        // Method 3: Drop and recreate if needed
        $result3 = $pdo->exec("DELETE FROM users WHERE 1=1");
        echo "<p>Method 3 (DELETE WHERE 1=1): Affected {$result3} rows</p>";
        
    } else {
        echo "<p>No users found in the database.</p>";
    }
    
    // Final verification
    echo "<h3>✅ Final Verification:</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $finalCount = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p><strong>Final user count: {$finalCount['count']}</strong></p>";
    
    if ($finalCount['count'] == 0) {
        echo "<p style='color: green; font-size: 18px; font-weight: bold;'>🎉 SUCCESS! All users have been deleted!</p>";
        echo "<p>🔗 <a href='admin-setup.php' style='color: #667eea; font-weight: bold; text-decoration: none; padding: 10px 20px; background: #e8f0ff; border-radius: 5px; display: inline-block;'>Create System Administrator</a></p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>⚠️ Some users may still remain. Check phpMyAdmin manually.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database Error: " . $e->getMessage() . "</p>";
    echo "<p>Connection details being used:</p>";
    echo "<ul>";
    echo "<li>Host: " . DB_HOST . "</li>";
    echo "<li>Database: " . DB_NAME . "</li>";
    echo "<li>User: " . DB_USER . "</li>";
    echo "</ul>";
}
?>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
}
h2, h3 { color: #333; margin-top: 20px; }
p { margin: 8px 0; }
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background: #f1f3f4; }
a:hover { background: #d0e4ff !important; }
</style>
