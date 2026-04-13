<?php
require_once '../app/core/config.php';

echo "<h2>🔧 Creating system_settings Table</h2>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p>📋 Creating system_settings table...</p>";
    
    // Create system_settings table
    $createSettings = "
    CREATE TABLE IF NOT EXISTS system_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        description TEXT,
        updated_by INT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (updated_by) REFERENCES users(id)
    )";
    
    $pdo->exec($createSettings);
    echo "✅ system_settings table created successfully!<br><br>";
    
    echo "<p>📝 Adding default system settings...</p>";
    
    // Insert default system settings
    $insertSettings = "
    INSERT INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
    ('site_name', 'HireFlow', 'Name of the recruitment system', 1),
    ('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
    ('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
    ('session_timeout', '3600', 'Session timeout in seconds', 1),
    ('email_notifications', 'true', 'Enable/disable email notifications', 1),
    ('maintenance_mode', 'false', 'Enable/disable maintenance mode', 1),
    ('registration_enabled', 'true', 'Allow new user registrations', 1),
    ('default_items_per_page', '10', 'Default number of items per page in listings', 1)";
    
    $pdo->exec($insertSettings);
    echo "✅ Default system settings added successfully!<br><br>";
    
    // Verify the table was created
    $stmt = $pdo->query("SHOW TABLES LIKE 'system_settings'");
    $tableExists = $stmt->fetch();
    
    if($tableExists) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>🎉 SUCCESS!</h3>";
        echo "<p><strong>system_settings table has been created successfully!</strong></p>";
        echo "<p>✅ Table structure created</p>";
        echo "<p>✅ Default settings added</p>";
        echo "<p>✅ Foreign key relationship established</p>";
        echo "</div>";
        
        // Show the settings that were added
        echo "<h3>📊 Default Settings Added:</h3>";
        $stmt = $pdo->query("SELECT setting_key, setting_value, description FROM system_settings ORDER BY id");
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
        echo "<tr style='background: #f8f9fa;'><th>Setting Key</th><th>Value</th><th>Description</th></tr>";
        foreach($settings as $setting) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($setting['setting_key']) . "</td>";
            echo "<td>" . htmlspecialchars($setting['setting_value']) . "</td>";
            echo "<td>" . htmlspecialchars($setting['description']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<br><div style='background: #cff4fc; color: #055160; padding: 15px; border-radius: 5px;'>";
        echo "<strong>🔄 Next Steps:</strong><br>";
        echo "1. Refresh phpMyAdmin to see the new table<br>";
        echo "2. You should now have all 9 tables<br>";
        echo "3. Ready to proceed to Phase 6: Authentication System!";
        echo "</div>";
        
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
        echo "<h4>❌ Table Creation Failed</h4>";
        echo "<p>The table may not have been created properly.</p>";
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h4>❌ Database Error</h4>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Possible solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure XAMPP MySQL is running</li>";
    echo "<li>Check if the 'users' table exists (for foreign key)</li>";
    echo "<li>Verify database permissions</li>";
    echo "</ul>";
    echo "</div>";
}
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
}
table { 
    margin: 10px 0; 
    background: white;
}
th, td { 
    padding: 8px 12px; 
    text-align: left; 
    border: 1px solid #ddd;
}
th {
    background: #e9ecef;
    font-weight: bold;
}
</style>
