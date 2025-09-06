<?php
// AGGRESSIVE user table clearing
require_once 'app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🚨 AGGRESSIVE TABLE CLEARING</h2>";
    
    // Show current state
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $beforeCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "<p><strong>Users before deletion: {$beforeCount}</strong></p>";
    
    if ($beforeCount > 0) {
        echo "<h3>🔥 Executing Multiple Deletion Methods:</h3>";
        
        // Disable foreign key checks temporarily
        echo "<p>1. Disabling foreign key checks...</p>";
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        
        // Method 1: Delete with foreign keys disabled
        echo "<p>2. Deleting with foreign keys disabled...</p>";
        $result1 = $pdo->exec("DELETE FROM users");
        echo "<p>   - Deleted {$result1} rows</p>";
        
        // Method 2: Truncate table
        echo "<p>3. Truncating table...</p>";
        try {
            $pdo->exec("TRUNCATE TABLE users");
            echo "<p>   - Table truncated successfully</p>";
        } catch (Exception $e) {
            echo "<p>   - Truncate failed: " . $e->getMessage() . "</p>";
        }
        
        // Method 3: Drop and recreate table
        echo "<p>4. Dropping and recreating table...</p>";
        try {
            // Drop the table
            $pdo->exec("DROP TABLE IF EXISTS users");
            echo "<p>   - Table dropped</p>";
            
            // Recreate the table
            $createUserTable = "
            CREATE TABLE users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                full_name VARCHAR(255) NOT NULL,
                role_id INT NOT NULL,
                phone VARCHAR(20),
                address TEXT,
                status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
            )";
            
            $pdo->exec($createUserTable);
            echo "<p>   - Table recreated successfully</p>";
            
        } catch (Exception $e) {
            echo "<p>   - Table recreation failed: " . $e->getMessage() . "</p>";
        }
        
        // Re-enable foreign key checks
        echo "<p>5. Re-enabling foreign key checks...</p>";
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    // Final verification
    echo "<h3>✅ FINAL VERIFICATION:</h3>";
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $afterCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p><strong>Users after deletion: {$afterCount}</strong></p>";
        
        if ($afterCount == 0) {
            echo "<p style='color: green; font-size: 20px; font-weight: bold;'>🎉 SUCCESS! Table is now completely empty!</p>";
            echo "<p style='color: green;'>✅ You can now create your admin account</p>";
            echo "<p>🔗 <a href='admin-setup.php' style='color: #667eea; font-weight: bold; text-decoration: none; padding: 15px 30px; background: #e8f0ff; border-radius: 8px; display: inline-block; margin-top: 15px;'>Create System Administrator Account</a></p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>❌ Still {$afterCount} users remaining</p>";
            echo "<p>You may need to manually delete from phpMyAdmin</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error checking final count: " . $e->getMessage() . "</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
    line-height: 1.6;
}
h2, h3 { color: #333; margin-top: 20px; }
p { margin: 10px 0; padding-left: 10px; }
a:hover { background: #d0e4ff !important; }
</style>
