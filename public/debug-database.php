<?php
// Debug Database Connection and Table Creation
require_once '../app/core/config.php';

echo "<h2>🔍 Database Debug Information</h2>";
echo "<hr>";

try {
    // Test basic connection
    echo "<h3>1. Testing Database Connection...</h3>";
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connection successful!<br><br>";
    
    // Show current tables
    echo "<h3>2. Current Tables in Database:</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p><strong>Found " . count($tables) . " tables:</strong></p>";
    echo "<ul>";
    foreach($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul><br>";
    
    // Check if missing tables exist
    echo "<h3>3. Checking for Missing Tables:</h3>";
    $missingTables = [];
    
    if(!in_array('notifications', $tables)) {
        $missingTables[] = 'notifications';
        echo "❌ notifications table missing<br>";
    } else {
        echo "✅ notifications table exists<br>";
    }
    
    if(!in_array('system_settings', $tables)) {
        $missingTables[] = 'system_settings';
        echo "❌ system_settings table missing<br>";
    } else {
        echo "✅ system_settings table exists<br>";
    }
    
    if(empty($missingTables)) {
        echo "<p style='color: green;'><strong>All tables exist! No action needed.</strong></p>";
    } else {
        echo "<br><h3>4. Creating Missing Tables...</h3>";
        
        // Create notifications table if missing
        if(in_array('notifications', $missingTables)) {
            try {
                echo "Creating notifications table...<br>";
                $createNotifications = "
                CREATE TABLE notifications (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    title VARCHAR(200) NOT NULL,
                    message TEXT NOT NULL,
                    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
                    is_read BOOLEAN DEFAULT FALSE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    read_at TIMESTAMP NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id)
                )";
                
                $pdo->exec($createNotifications);
                echo "✅ notifications table created!<br>";
                
                // Add sample data
                $insertNotifications = "
                INSERT INTO notifications (user_id, title, message, type) VALUES
                (4, 'Application Submitted', 'Your application for Senior Software Engineer position has been submitted successfully.', 'success'),
                (4, 'Application Update', 'Your application for Senior Software Engineer has been shortlisted for interview.', 'info'),
                (7, 'Interview Scheduled', 'Your interview for Junior Data Analyst position has been scheduled for September 3rd.', 'info'),
                (2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info'),
                (3, 'Interview Reminder', 'You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.', 'warning')";
                
                $pdo->exec($insertNotifications);
                echo "✅ Sample notifications added!<br>";
                
            } catch(PDOException $e) {
                echo "❌ Error creating notifications table: " . $e->getMessage() . "<br>";
            }
        }
        
        // Create system_settings table if missing
        if(in_array('system_settings', $missingTables)) {
            try {
                echo "Creating system_settings table...<br>";
                $createSettings = "
                CREATE TABLE system_settings (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    setting_key VARCHAR(100) NOT NULL UNIQUE,
                    setting_value TEXT,
                    description TEXT,
                    updated_by INT,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (updated_by) REFERENCES users(id)
                )";
                
                $pdo->exec($createSettings);
                echo "✅ system_settings table created!<br>";
                
                // Add sample data
                $insertSettings = "
                INSERT INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
                ('site_name', 'HireFlow', 'Name of the recruitment system', 1),
                ('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
                ('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
                ('session_timeout', '3600', 'Session timeout in seconds', 1),
                ('email_notifications', 'true', 'Enable/disable email notifications', 1)";
                
                $pdo->exec($insertSettings);
                echo "✅ Default system settings added!<br>";
                
            } catch(PDOException $e) {
                echo "❌ Error creating system_settings table: " . $e->getMessage() . "<br>";
            }
        }
        
        // Verify tables were created
        echo "<br><h3>5. Final Verification:</h3>";
        $stmt = $pdo->query("SHOW TABLES");
        $newTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Total tables now: " . count($newTables) . "</strong></p>";
        
        if(count($newTables) >= 9) {
            echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
            echo "<h4>🎉 SUCCESS! All tables created!</h4>";
            echo "<p>Please refresh phpMyAdmin to see the new tables.</p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
            echo "<h4>⚠️ Still missing tables</h4>";
            echo "<p>Some tables may not have been created due to foreign key constraints or other issues.</p>";
            echo "</div>";
        }
    }
    
    echo "<br><h3>6. Configuration Check:</h3>";
    echo "Database Host: " . DB_HOST . "<br>";
    echo "Database Name: " . DB_NAME . "<br>";
    echo "Database User: " . DB_USER . "<br>";
    echo "Database Pass: " . (empty(DB_PASS) ? '(empty)' : '***') . "<br>";
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h4>❌ Database Connection Failed!</h4>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Possible causes:</strong></p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL service not running</li>";
    echo "<li>Database 'hireflow_db' doesn't exist</li>";
    echo "<li>Incorrect credentials in config.php</li>";
    echo "</ul>";
    echo "</div>";
}
?>
