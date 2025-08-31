<?php
// Create Missing Tables for HireFlow Database
require_once '../app/core/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🚀 Creating Missing Tables for HireFlow</h2>";
    echo "<hr>";
    
    // Create notifications table
    echo "<h3>Creating notifications table...</h3>";
    $createNotifications = "
    CREATE TABLE IF NOT EXISTS notifications (
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
    echo "✅ notifications table created successfully!<br>";
    
    // Insert sample notifications
    echo "<h3>Adding sample notifications...</h3>";
    $insertNotifications = "
    INSERT IGNORE INTO notifications (user_id, title, message, type) VALUES
    (4, 'Application Submitted', 'Your application for Senior Software Engineer position has been submitted successfully.', 'success'),
    (4, 'Application Update', 'Your application for Senior Software Engineer has been shortlisted for interview.', 'info'),
    (7, 'Interview Scheduled', 'Your interview for Junior Data Analyst position has been scheduled for September 3rd.', 'info'),
    (2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info'),
    (3, 'Interview Reminder', 'You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.', 'warning')";
    
    $pdo->exec($insertNotifications);
    echo "✅ Sample notifications added successfully!<br>";
    
    // Create system_settings table
    echo "<h3>Creating system_settings table...</h3>";
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
    echo "✅ system_settings table created successfully!<br>";
    
    // Insert default system settings
    echo "<h3>Adding default system settings...</h3>";
    $insertSettings = "
    INSERT IGNORE INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
    ('site_name', 'HireFlow', 'Name of the recruitment system', 1),
    ('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
    ('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
    ('session_timeout', '3600', 'Session timeout in seconds', 1),
    ('email_notifications', 'true', 'Enable/disable email notifications', 1)";
    
    $pdo->exec($insertSettings);
    echo "✅ Default system settings added successfully!<br>";
    
    // Verify all tables now exist
    echo "<hr>";
    echo "<h3>📊 Database Verification</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p><strong>Total Tables Found: " . count($tables) . "</strong></p>";
    echo "<ul>";
    foreach($tables as $table) {
        echo "<li>✅ $table</li>";
    }
    echo "</ul>";
    
    if(count($tables) >= 9) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h4>🎉 SUCCESS! All tables created successfully!</h4>";
        echo "<p>Your HireFlow database now has all " . count($tables) . " required tables.</p>";
        echo "</div>";
    }
    
    // Show record counts
    echo "<h3>📈 Record Counts</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f8f9fa;'><th>Table</th><th>Records</th></tr>";
    
    foreach($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<tr><td>$table</td><td>$count</td></tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<div style='background: #e7f3ff; color: #004085; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h4>🚀 Next Steps:</h4>";
    echo "<ul>";
    echo "<li>✅ Database setup complete with all 9 tables</li>";
    echo "<li>✅ Sample data loaded for testing</li>";
    echo "<li>🎯 Ready to proceed with authentication system development</li>";
    echo "<li>🔗 Test your setup: <a href='../check-database.php'>Database Verification</a></li>";
    echo "</ul>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h4>❌ Error occurred:</h4>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p><strong>Possible solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Make sure XAMPP MySQL service is running</li>";
    echo "<li>Verify database 'hireflow_db' exists</li>";
    echo "<li>Check if basic tables (users, roles) exist first</li>";
    echo "</ul>";
    echo "</div>";
}
?>
