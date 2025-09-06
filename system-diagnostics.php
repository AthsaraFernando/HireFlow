<?php
// Comprehensive fix for all authentication and routing issues
require_once 'app/core/config.php';

session_start();

echo "<h1>🔧 HireFlow System Fixes</h1>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>1. 🗄️ Database Schema Fixes</h2>";
    
    // Check and add last_login column
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('last_login', $columns)) {
        echo "<p>➕ Adding missing last_login column...</p>";
        $pdo->exec("ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL AFTER status");
        echo "<p>✅ last_login column added</p>";
    } else {
        echo "<p>✅ last_login column exists</p>";
    }
    
    echo "<h2>2. 🧹 Session Management</h2>";
    
    // Show current session status
    echo "<p>Session ID: " . session_id() . "</p>";
    echo "<p>Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "Active" : "Inactive") . "</p>";
    
    if (isset($_SESSION['USER'])) {
        echo "<div style='background: #fff3cd; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
        echo "<strong>⚠️ User Currently Logged In:</strong><br>";
        echo "Email: " . ($_SESSION['USER']['email'] ?? 'Unknown') . "<br>";
        echo "Role: " . ($_SESSION['USER']['role_name'] ?? 'Unknown') . "<br>";
        echo "Login Time: " . ($_SESSION['LOGIN_TIME'] ?? 'Unknown');
        echo "</div>";
        
        if (isset($_GET['logout'])) {
            echo "<p>🚪 Forcing logout...</p>";
            unset($_SESSION['USER']);
            unset($_SESSION['USER_ID']);
            unset($_SESSION['USER_ROLE']);
            unset($_SESSION['LOGIN_TIME']);
            echo "<p>✅ Session cleared</p>";
            echo "<script>setTimeout(() => window.location.href = 'public?url=signin', 2000);</script>";
        } else {
            echo "<p><a href='?logout=1' style='background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;'>Force Logout</a></p>";
        }
    } else {
        echo "<p>✅ No active session</p>";
    }
    
    echo "<h2>3. 🔍 System Admin Routes Check</h2>";
    
    // Check if system admin controllers exist
    $controllers = [
        'Dashboard' => 'app/controllers/systemadmin/Dashboard.php',
        'Usermanage' => 'app/controllers/systemadmin/Usermanage.php',
        'Accesslogs' => 'app/controllers/systemadmin/Accesslogs.php',
        'Viewdata' => 'app/controllers/systemadmin/Viewdata.php'
    ];
    
    foreach ($controllers as $name => $path) {
        if (file_exists($path)) {
            echo "<p>✅ {$name} controller exists</p>";
        } else {
            echo "<p>❌ {$name} controller missing at {$path}</p>";
        }
    }
    
    echo "<h2>4. 🎯 View Files Check</h2>";
    
    // Check if system admin views exist
    $views = [
        'dashboard' => 'app/views/systemadmin/dashboard.view.php',
        'usermanage' => 'app/views/systemadmin/usermanage.view.php',
        'accesslogs' => 'app/views/systemadmin/accesslogs.view.php',
        'viewdata' => 'app/views/systemadmin/viewdata.view.php'
    ];
    
    foreach ($views as $name => $path) {
        if (file_exists($path)) {
            echo "<p>✅ {$name} view exists</p>";
        } else {
            echo "<p>❌ {$name} view missing at {$path}</p>";
        }
    }
    
    echo "<h2>5. 🚀 Quick Actions</h2>";
    echo "<div style='margin: 20px 0;'>";
    echo "<a href='public?url=signin' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-right: 10px;'>Go to Login</a>";
    echo "<a href='public?url=signout' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-right: 10px;'>Test Logout</a>";
    echo "<a href='admin-setup.php' style='background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>Admin Setup</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<strong>❌ Database Error:</strong> " . $e->getMessage();
    echo "</div>";
}
?>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
    line-height: 1.6;
}
h1, h2 { color: #333; }
p { margin: 8px 0; }
a { display: inline-block; }
a:hover { opacity: 0.8; }
</style>
