<?php
// Clear users table and reset admin setup
require_once 'app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🧹 Clearing Users Table</h2>";
    
    // Clear all users
    $stmt = $pdo->exec("DELETE FROM users");
    echo "<p>✅ Cleared all users from table</p>";
    
    // Check count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Current user count: {$count['count']}</p>";
    
    echo "<p>🔗 <a href='admin-setup.php'>Create System Administrator</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2 { color: #333; }
p { margin: 5px 0; }
a { color: #667eea; text-decoration: none; font-weight: bold; }
</style>
