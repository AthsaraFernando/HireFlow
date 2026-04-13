<?php
require_once '../app/core/config.php';

echo "<h2>🔍 Table Status Check</h2>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get current tables
    $stmt = $pdo->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Expected tables
    $expectedTables = [
        'users',
        'roles', 
        'departments',
        'job_postings',
        'applications',
        'interviews',
        'access_logs',
        'notifications',
        'system_settings'
    ];
    
    echo "<h3>📊 Table Status:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f8f9fa;'><th>Table Name</th><th>Status</th></tr>";
    
    $missingTable = null;
    foreach($expectedTables as $table) {
        if(in_array($table, $existingTables)) {
            echo "<tr><td>$table</td><td style='color: green;'>✅ EXISTS</td></tr>";
        } else {
            echo "<tr><td>$table</td><td style='color: red;'>❌ MISSING</td></tr>";
            $missingTable = $table;
        }
    }
    echo "</table>";
    
    echo "<br><p><strong>Total Tables:</strong> " . count($existingTables) . " / 9</p>";
    
    if($missingTable) {
        echo "<br><h3>🔧 Creating Missing Table: $missingTable</h3>";
        
        if($missingTable === 'system_settings') {
            try {
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
                
                $insertSettings = "
                INSERT INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
                ('site_name', 'HireFlow', 'Name of the recruitment system', 1),
                ('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
                ('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
                ('session_timeout', '3600', 'Session timeout in seconds', 1),
                ('email_notifications', 'true', 'Enable/disable email notifications', 1)";
                
                $pdo->exec($insertSettings);
                echo "✅ Default settings added!<br>";
                
            } catch(PDOException $e) {
                echo "❌ Error: " . $e->getMessage() . "<br>";
            }
        } 
        
        if($missingTable === 'notifications') {
            try {
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
                echo "❌ Error: " . $e->getMessage() . "<br>";
            }
        }
        
        echo "<br><div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px;'>";
        echo "<strong>🔄 Please refresh phpMyAdmin to see the new table!</strong>";
        echo "</div>";
    } else {
        echo "<br><div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
        echo "<h4>🎉 PERFECT! All 9 tables exist!</h4>";
        echo "<p>Your database is now complete and ready for the next phase.</p>";
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h4>❌ Database Error</h4>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin: 10px 0; }
th, td { padding: 8px 12px; text-align: left; }
</style>
