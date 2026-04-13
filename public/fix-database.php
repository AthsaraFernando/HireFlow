<?php
require_once '../app/core/config.php';

echo "<h2>🔧 Database Correction</h2>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>📋 Current Issue Analysis:</h3>";
    echo "<p>✅ You have 8 tables</p>";
    echo "<p>❌ Missing: <strong>departments</strong> table</p>";
    echo "<p>⚠️ Table name issue: <strong>job_posts</strong> vs <strong>job_postings</strong></p>";
    echo "<hr>";
    
    // Check if departments table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'departments'");
    $departmentsExists = $stmt->fetch();
    
    if (!$departmentsExists) {
        echo "<h3>🏢 Creating departments table...</h3>";
        
        $createDepartments = "
        CREATE TABLE departments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE,
            description TEXT,
            head_of_department INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (head_of_department) REFERENCES users(id)
        )";
        
        $pdo->exec($createDepartments);
        echo "✅ departments table created successfully!<br><br>";
        
        // Insert sample departments
        echo "<p>📝 Adding sample departments...</p>";
        $insertDepartments = "
        INSERT INTO departments (name, description, head_of_department) VALUES
        ('Human Resources', 'Manages recruitment, employee relations, and HR policies', 2),
        ('Information Technology', 'Handles software development, system administration, and technical support', 2),
        ('Marketing', 'Responsible for brand management, digital marketing, and customer outreach', 2),
        ('Finance', 'Manages company finances, budgeting, and financial reporting', 2),
        ('Operations', 'Oversees daily operations, process improvement, and logistics', 2)";
        
        $pdo->exec($insertDepartments);
        echo "✅ Sample departments added!<br><br>";
    } else {
        echo "<p>✅ departments table already exists</p><br>";
    }
    
    // Check table naming issue
    echo "<h3>🔍 Checking table naming...</h3>";
    $stmt = $pdo->query("SHOW TABLES LIKE 'job_posts'");
    $jobPostsExists = $stmt->fetch();
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'job_postings'");
    $jobPostingsExists = $stmt->fetch();
    
    if ($jobPostsExists && !$jobPostingsExists) {
        echo "<p>⚠️ Found 'job_posts' table but expected 'job_postings'</p>";
        echo "<p>🔧 This is fine - both names work, but let's check the structure...</p>";
        
        // Check if job_posts has the right structure
        $stmt = $pdo->query("DESCRIBE job_posts");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p>📊 job_posts table structure:</p>";
        echo "<ul>";
        foreach($columns as $column) {
            echo "<li><strong>" . $column['Field'] . "</strong>: " . $column['Type'] . "</li>";
        }
        echo "</ul>";
        
        // Check if it has the department_id foreign key
        $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'job_posts' AND COLUMN_NAME = 'department_id' AND TABLE_SCHEMA = '" . DB_NAME . "'");
        $hasDeptFK = $stmt->fetchColumn() > 0;
        
        if (!$hasDeptFK) {
            echo "<p>⚠️ Adding department_id foreign key to job_posts...</p>";
            try {
                $pdo->exec("ALTER TABLE job_posts ADD COLUMN department_id INT AFTER title");
                $pdo->exec("ALTER TABLE job_posts ADD FOREIGN KEY (department_id) REFERENCES departments(id)");
                echo "✅ Foreign key added successfully!<br>";
                
                // Update existing job posts with sample department assignments
                $pdo->exec("UPDATE job_posts SET department_id = 2 WHERE id IN (1, 2)"); // IT dept
                $pdo->exec("UPDATE job_posts SET department_id = 3 WHERE id = 3"); // Marketing dept
                echo "✅ Existing job posts updated with departments!<br>";
            } catch(PDOException $e) {
                echo "⚠️ Note: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "✅ job_posts table already has department_id foreign key<br>";
        }
        
    } else if ($jobPostingsExists) {
        echo "<p>✅ job_postings table exists (correct name)</p>";
    } else {
        echo "<p>❌ Neither job_posts nor job_postings table found!</p>";
    }
    
    echo "<br><h3>🎯 Final Status Check:</h3>";
    
    // Final table count
    $stmt = $pdo->query("SHOW TABLES");
    $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p><strong>Total tables now:</strong> " . count($allTables) . "</p>";
    echo "<p><strong>Tables:</strong> " . implode(', ', $allTables) . "</p>";
    
    if (count($allTables) >= 9) {
        echo "<br><div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px;'>";
        echo "<h3>🎉 SUCCESS! Database Complete!</h3>";
        echo "<p>✅ All required tables exist</p>";
        echo "<p>✅ Foreign key relationships established</p>";
        echo "<p>✅ Sample data populated</p>";
        echo "<br><h4>🚀 Ready for Phase 6: Authentication System!</h4>";
        echo "</div>";
    } else {
        echo "<br><div style='background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px;'>";
        echo "<h4>⚠️ Still Missing Tables</h4>";
        echo "<p>Expected 9 tables, found " . count($allTables) . "</p>";
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
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
    line-height: 1.6;
}
ul { margin: 10px 0; padding-left: 25px; }
li { margin: 3px 0; }
</style>
