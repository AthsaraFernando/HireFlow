<?php
/**
 * HireFlow Database Setup Script
 * 
 * This script creates the complete database schema for HireFlow
 * Run this once after setting up your XAMPP environment
 * 
 * @author HireFlow Development Team
 * @version 1.0
 */

require_once '../app/core/config.php';

// Set content type and disable timeout for long operations
header('Content-Type: text/html; charset=UTF-8');
set_time_limit(300); // 5 minutes max

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireFlow Database Setup</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .step {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            background: #f8f9fa;
        }
        .success {
            border-left-color: #27ae60;
            background: #d4edda;
            color: #155724;
        }
        .error {
            border-left-color: #e74c3c;
            background: #f8d7da;
            color: #721c24;
        }
        .warning {
            border-left-color: #f39c12;
            background: #fff3cd;
            color: #856404;
        }
        .table-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        .table-item {
            background: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }
        .exists { background: #d4edda; color: #155724; }
        .created { background: #cff4fc; color: #055160; }
        h1, h2, h3 { margin-top: 0; }
        .footer {
            background: #34495e;
            color: white;
            padding: 20px 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 HireFlow Database Setup</h1>
            <p>Complete database schema initialization</p>
        </div>
        
        <div class="content">
            <?php
            try {
                // Test database connection
                echo "<div class='step'>";
                echo "<h3>🔗 Step 1: Testing Database Connection</h3>";
                
                $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                echo "<p>✅ Connected to database: <strong>" . DB_NAME . "</strong></p>";
                echo "<p>✅ Host: " . DB_HOST . "</p>";
                echo "<p>✅ User: " . DB_USER . "</p>";
                echo "</div>";
                
                // Check existing tables
                echo "<div class='step'>";
                echo "<h3>📊 Step 2: Checking Existing Tables</h3>";
                
                $stmt = $pdo->query("SHOW TABLES");
                $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                echo "<p>Found <strong>" . count($existingTables) . "</strong> existing tables:</p>";
                if (!empty($existingTables)) {
                    echo "<div class='table-list'>";
                    foreach ($existingTables as $table) {
                        echo "<div class='table-item exists'>✅ $table</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p><em>No existing tables found.</em></p>";
                }
                echo "</div>";
                
                // Define all tables and their creation SQL
                $tables = [
                    'roles' => "
                        CREATE TABLE IF NOT EXISTS roles (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(50) NOT NULL UNIQUE,
                            description TEXT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                        )",
                    
                    'departments' => "
                        CREATE TABLE IF NOT EXISTS departments (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100) NOT NULL UNIQUE,
                            description TEXT,
                            head_of_department INT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        )",
                    
                    'users' => "
                        CREATE TABLE IF NOT EXISTS users (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(50) NOT NULL UNIQUE,
                            email VARCHAR(100) NOT NULL UNIQUE,
                            password VARCHAR(255) NOT NULL,
                            first_name VARCHAR(50) NOT NULL,
                            last_name VARCHAR(50) NOT NULL,
                            role_id INT NOT NULL,
                            phone VARCHAR(20),
                            is_active BOOLEAN DEFAULT TRUE,
                            last_login TIMESTAMP NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            FOREIGN KEY (role_id) REFERENCES roles(id)
                        )",
                    
                    'job_posts' => "
                        CREATE TABLE IF NOT EXISTS job_posts (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            title VARCHAR(200) NOT NULL,
                            department_id INT,
                            description TEXT NOT NULL,
                            requirements TEXT,
                            salary_range VARCHAR(100),
                            location VARCHAR(100),
                            employment_type ENUM('full-time', 'part-time', 'contract', 'internship') DEFAULT 'full-time',
                            status ENUM('active', 'closed', 'draft') DEFAULT 'active',
                            posted_by INT NOT NULL,
                            posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            deadline DATE,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            FOREIGN KEY (department_id) REFERENCES departments(id),
                            FOREIGN KEY (posted_by) REFERENCES users(id)
                        )",
                    
                    'applications' => "
                        CREATE TABLE IF NOT EXISTS applications (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            job_post_id INT NOT NULL,
                            applicant_id INT NOT NULL,
                            cover_letter TEXT,
                            resume_path VARCHAR(255),
                            status ENUM('pending', 'shortlisted', 'rejected', 'hired') DEFAULT 'pending',
                            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            reviewed_by INT,
                            reviewed_at TIMESTAMP NULL,
                            notes TEXT,
                            FOREIGN KEY (job_post_id) REFERENCES job_posts(id),
                            FOREIGN KEY (applicant_id) REFERENCES users(id),
                            FOREIGN KEY (reviewed_by) REFERENCES users(id)
                        )",
                    
                    'interviews' => "
                        CREATE TABLE IF NOT EXISTS interviews (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            application_id INT NOT NULL,
                            interviewer_id INT NOT NULL,
                            scheduled_at DATETIME NOT NULL,
                            location VARCHAR(200),
                            interview_type ENUM('phone', 'video', 'in-person') DEFAULT 'in-person',
                            status ENUM('scheduled', 'completed', 'cancelled', 'no-show') DEFAULT 'scheduled',
                            feedback TEXT,
                            rating INT CHECK (rating >= 1 AND rating <= 5),
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            FOREIGN KEY (application_id) REFERENCES applications(id),
                            FOREIGN KEY (interviewer_id) REFERENCES users(id)
                        )",
                    
                    'access_logs' => "
                        CREATE TABLE IF NOT EXISTS access_logs (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id INT,
                            action VARCHAR(100) NOT NULL,
                            ip_address VARCHAR(45),
                            user_agent TEXT,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (user_id) REFERENCES users(id)
                        )",
                    
                    'notifications' => "
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
                        )",
                    
                    'system_settings' => "
                        CREATE TABLE IF NOT EXISTS system_settings (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            setting_key VARCHAR(100) NOT NULL UNIQUE,
                            setting_value TEXT,
                            description TEXT,
                            updated_by INT,
                            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            FOREIGN KEY (updated_by) REFERENCES users(id)
                        )"
                ];
                
                // Create tables
                echo "<div class='step'>";
                echo "<h3>🔨 Step 3: Creating Database Tables</h3>";
                
                $createdCount = 0;
                $existedCount = 0;
                
                foreach ($tables as $tableName => $sql) {
                    try {
                        $pdo->exec($sql);
                        if (in_array($tableName, $existingTables)) {
                            echo "<p>✅ Table <strong>$tableName</strong> already existed</p>";
                            $existedCount++;
                        } else {
                            echo "<p>🆕 Table <strong>$tableName</strong> created successfully</p>";
                            $createdCount++;
                        }
                    } catch (PDOException $e) {
                        echo "<p>❌ Error creating table <strong>$tableName</strong>: " . $e->getMessage() . "</p>";
                    }
                }
                
                echo "<div class='success'>";
                echo "<p><strong>Summary:</strong> $createdCount tables created, $existedCount tables already existed</p>";
                echo "</div>";
                echo "</div>";
                
                // Add foreign key constraints that were missed
                echo "<div class='step'>";
                echo "<h3>🔗 Step 4: Adding Foreign Key Constraints</h3>";
                
                try {
                    $pdo->exec("ALTER TABLE departments ADD FOREIGN KEY (head_of_department) REFERENCES users(id)");
                    echo "<p>✅ Added foreign key: departments.head_of_department → users.id</p>";
                } catch (PDOException $e) {
                    echo "<p>ℹ️ Foreign key departments.head_of_department already exists</p>";
                }
                echo "</div>";
                
                // Insert sample data
                echo "<div class='step'>";
                echo "<h3>📝 Step 5: Inserting Sample Data</h3>";
                
                // Sample roles
                $pdo->exec("INSERT IGNORE INTO roles (name, description) VALUES
                    ('System Administrator', 'Full system access and user management'),
                    ('HR Administrator', 'Manages recruitment process and employee data'),
                    ('Recruitment Manager', 'Oversees job postings and candidate screening'),
                    ('Applicant', 'Job seekers applying for positions')");
                echo "<p>✅ Sample roles inserted</p>";
                
                // Sample departments
                $pdo->exec("INSERT IGNORE INTO departments (name, description) VALUES
                    ('Human Resources', 'Manages recruitment, employee relations, and HR policies'),
                    ('Information Technology', 'Handles software development, system administration, and technical support'),
                    ('Marketing', 'Responsible for brand management, digital marketing, and customer outreach'),
                    ('Finance', 'Manages company finances, budgeting, and financial reporting'),
                    ('Operations', 'Oversees daily operations, process improvement, and logistics')");
                echo "<p>✅ Sample departments inserted</p>";
                
                // Sample users (with hashed passwords)
                $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
                $pdo->exec("INSERT IGNORE INTO users (username, email, password, first_name, last_name, role_id, phone) VALUES
                    ('admin', 'admin@hireflow.com', '$hashedPassword', 'System', 'Administrator', 1, '+1234567890'),
                    ('hr_admin', 'hr@hireflow.com', '$hashedPassword', 'Sarah', 'Johnson', 2, '+1234567891'),
                    ('recruiter', 'recruiter@hireflow.com', '$hashedPassword', 'Michael', 'Chen', 3, '+1234567892'),
                    ('john_doe', 'john.doe@email.com', '$hashedPassword', 'John', 'Doe', 4, '+1234567893'),
                    ('jane_smith', 'jane.smith@email.com', '$hashedPassword', 'Jane', 'Smith', 4, '+1234567894'),
                    ('alex_wilson', 'alex.wilson@email.com', '$hashedPassword', 'Alex', 'Wilson', 4, '+1234567895'),
                    ('priya_j', 'priya.j@email.com', '$hashedPassword', 'Priya', 'Jayasinghe', 4, '+1234567896')");
                echo "<p>✅ Sample users inserted (default password: password123)</p>";
                
                // Sample job posts
                $pdo->exec("INSERT IGNORE INTO job_posts (title, department_id, description, requirements, salary_range, location, posted_by, deadline) VALUES
                    ('Senior Software Engineer', 2, 'We are looking for an experienced software engineer to join our growing development team.', 'Bachelor\\'s degree in Computer Science, 5+ years experience, proficiency in PHP, JavaScript, and MySQL.', '$80,000 - $120,000', 'New York, NY', 2, '2025-09-30'),
                    ('Junior Data Analyst', 2, 'Entry-level position for a data analyst to support our business intelligence initiatives.', 'Bachelor\\'s degree in Statistics/Mathematics, knowledge of SQL and Excel, analytical mindset.', '$45,000 - $65,000', 'Remote', 3, '2025-09-15'),
                    ('Marketing Specialist', 3, 'Join our marketing team to develop and execute digital marketing campaigns.', 'Bachelor\\'s degree in Marketing, experience with social media, content creation skills.', '$50,000 - $70,000', 'Los Angeles, CA', 2, '2025-09-20')");
                echo "<p>✅ Sample job posts inserted</p>";
                
                // Sample applications
                $pdo->exec("INSERT IGNORE INTO applications (job_post_id, applicant_id, cover_letter, status) VALUES
                    (1, 4, 'I am excited to apply for the Senior Software Engineer position. With over 6 years of experience in full-stack development...', 'shortlisted'),
                    (2, 7, 'I am writing to express my interest in the Junior Data Analyst position. My academic background in statistics...', 'pending'),
                    (3, 5, 'I would like to apply for the Marketing Specialist role. My passion for digital marketing and experience...', 'pending')");
                echo "<p>✅ Sample applications inserted</p>";
                
                // Sample interviews
                $pdo->exec("INSERT IGNORE INTO interviews (application_id, interviewer_id, scheduled_at, location, interview_type, status) VALUES
                    (1, 3, '2025-09-05 14:00:00', 'Conference Room A', 'in-person', 'scheduled'),
                    (2, 2, '2025-09-03 10:00:00', 'Zoom Meeting', 'video', 'scheduled')");
                echo "<p>✅ Sample interviews inserted</p>";
                
                // Sample notifications
                $pdo->exec("INSERT IGNORE INTO notifications (user_id, title, message, type) VALUES
                    (4, 'Application Submitted', 'Your application for Senior Software Engineer has been submitted successfully.', 'success'),
                    (4, 'Interview Scheduled', 'Your interview has been scheduled for September 5th at 2:00 PM.', 'info'),
                    (7, 'Application Received', 'Thank you for applying to the Junior Data Analyst position.', 'info'),
                    (2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info')");
                echo "<p>✅ Sample notifications inserted</p>";
                
                // Sample system settings
                $pdo->exec("INSERT IGNORE INTO system_settings (setting_key, setting_value, description, updated_by) VALUES
                    ('site_name', 'HireFlow', 'Name of the recruitment system', 1),
                    ('max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1),
                    ('allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1),
                    ('session_timeout', '3600', 'Session timeout in seconds', 1),
                    ('email_notifications', 'true', 'Enable/disable email notifications', 1),
                    ('maintenance_mode', 'false', 'Enable/disable maintenance mode', 1),
                    ('registration_enabled', 'true', 'Allow new user registrations', 1),
                    ('default_items_per_page', '10', 'Default number of items per page', 1)");
                echo "<p>✅ System settings inserted</p>";
                
                echo "</div>";
                
                // Final verification
                echo "<div class='step success'>";
                echo "<h3>🎯 Step 6: Final Verification</h3>";
                
                $stmt = $pdo->query("SHOW TABLES");
                $finalTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                echo "<p><strong>Database setup completed successfully!</strong></p>";
                echo "<p><strong>Total tables created:</strong> " . count($finalTables) . "</p>";
                
                echo "<div class='table-list'>";
                foreach ($finalTables as $table) {
                    // Get record count
                    $countStmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
                    $count = $countStmt->fetchColumn();
                    echo "<div class='table-item created'>✅ $table ($count records)</div>";
                }
                echo "</div>";
                echo "</div>";
                
            } catch (PDOException $e) {
                echo "<div class='step error'>";
                echo "<h3>❌ Database Connection Failed</h3>";
                echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
                echo "<h4>Common Solutions:</h4>";
                echo "<ul>";
                echo "<li>Make sure XAMPP is running and MySQL service is started</li>";
                echo "<li>Create the database 'hireflow_db' in phpMyAdmin</li>";
                echo "<li>Check your database credentials in app/core/config.php</li>";
                echo "<li>Ensure your database user has proper permissions</li>";
                echo "</ul>";
                echo "</div>";
            }
            ?>
        </div>
        
        <div class="footer">
            <h3>🎉 Setup Complete!</h3>
            <p>Your HireFlow database is ready. You can now start using the application.</p>
            <p><strong>Default Login:</strong> admin / password123</p>
            <p><em>Remember to change default passwords in production!</em></p>
        </div>
    </div>
</body>
</html>
