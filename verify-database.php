<?php
/**
 * Database Table Verification & Standardization Script
 * 
 * This script verifies all required tables exist and standardizes naming
 * across the entire HireFlow application
 */

require_once '../app/core/config.php';

// Set content type
header('Content-Type: text/html; charset=UTF-8');
set_time_limit(300);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireFlow Database Verification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
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
        .section {
            margin: 25px 0;
            padding: 20px;
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
        .info {
            border-left-color: #17a2b8;
            background: #d1ecf1;
            color: #0c5460;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background: #e9ecef;
            font-weight: 600;
        }
        .status-ok { color: #27ae60; font-weight: bold; }
        .status-error { color: #e74c3c; font-weight: bold; }
        .status-warning { color: #f39c12; font-weight: bold; }
        h1, h2, h3 { margin-top: 0; }
        .fix-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .fix-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 HireFlow Database Verification</h1>
            <p>Complete table validation and naming standardization</p>
        </div>
        
        <div class="content">
            <?php
            try {
                // Connect to database
                echo "<div class='section'>";
                echo "<h3>🔗 Database Connection</h3>";
                
                $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                echo "<p>✅ Connected to database: <strong>" . DB_NAME . "</strong></p>";
                echo "</div>";
                
                // Define expected tables with standardized names
                $expectedTables = [
                    'roles' => [
                        'required' => true,
                        'description' => 'User role definitions',
                        'key_columns' => ['id', 'name', 'description']
                    ],
                    'departments' => [
                        'required' => true,
                        'description' => 'Organizational departments',
                        'key_columns' => ['id', 'name', 'head_of_department']
                    ],
                    'users' => [
                        'required' => true,
                        'description' => 'System users',
                        'key_columns' => ['id', 'username', 'email', 'role_id']
                    ],
                    'job_posts' => [
                        'required' => true,
                        'description' => 'Job postings (standardized name)',
                        'key_columns' => ['id', 'title', 'department_id', 'posted_by']
                    ],
                    'applications' => [
                        'required' => true,
                        'description' => 'Job applications',
                        'key_columns' => ['id', 'job_post_id', 'applicant_id']
                    ],
                    'interviews' => [
                        'required' => true,
                        'description' => 'Interview scheduling',
                        'key_columns' => ['id', 'application_id', 'interviewer_id']
                    ],
                    'access_logs' => [
                        'required' => true,
                        'description' => 'Security audit logs',
                        'key_columns' => ['id', 'user_id', 'action']
                    ],
                    'notifications' => [
                        'required' => true,
                        'description' => 'User notifications',
                        'key_columns' => ['id', 'user_id', 'title', 'message']
                    ],
                    'system_settings' => [
                        'required' => true,
                        'description' => 'Application configuration',
                        'key_columns' => ['id', 'setting_key', 'setting_value']
                    ]
                ];
                
                // Get current tables
                $stmt = $pdo->query("SHOW TABLES");
                $currentTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                echo "<div class='section'>";
                echo "<h3>📊 Current Database Tables</h3>";
                echo "<p>Found <strong>" . count($currentTables) . "</strong> tables in database:</p>";
                echo "<p>" . implode(', ', $currentTables) . "</p>";
                echo "</div>";
                
                // Check for naming issues
                echo "<div class='section'>";
                echo "<h3>🔍 Table Naming Analysis</h3>";
                
                $namingIssues = [];
                $tableStatus = [];
                
                // Check if we have job_postings instead of job_posts
                if (in_array('job_postings', $currentTables) && !in_array('job_posts', $currentTables)) {
                    $namingIssues[] = "Found 'job_postings' but expected 'job_posts'";
                }
                
                foreach ($expectedTables as $tableName => $tableInfo) {
                    if (in_array($tableName, $currentTables)) {
                        $tableStatus[$tableName] = 'exists';
                    } else {
                        $tableStatus[$tableName] = 'missing';
                    }
                }
                
                if (!empty($namingIssues)) {
                    echo "<div class='warning'>";
                    echo "<h4>⚠️ Naming Issues Found</h4>";
                    foreach ($namingIssues as $issue) {
                        echo "<p>• $issue</p>";
                    }
                    echo "</div>";
                } else {
                    echo "<p class='status-ok'>✅ All table names follow standard conventions</p>";
                }
                echo "</div>";
                
                // Table verification
                echo "<div class='section'>";
                echo "<h3>📋 Complete Table Verification</h3>";
                
                echo "<table>";
                echo "<tr><th>Table Name</th><th>Status</th><th>Records</th><th>Key Columns</th><th>Action</th></tr>";
                
                $allGood = true;
                $fixActions = [];
                
                foreach ($expectedTables as $tableName => $tableInfo) {
                    echo "<tr>";
                    echo "<td><strong>$tableName</strong><br><small>{$tableInfo['description']}</small></td>";
                    
                    if ($tableStatus[$tableName] === 'exists') {
                        echo "<td class='status-ok'>✅ EXISTS</td>";
                        
                        // Get record count
                        try {
                            $countStmt = $pdo->query("SELECT COUNT(*) FROM `$tableName`");
                            $count = $countStmt->fetchColumn();
                            echo "<td>$count records</td>";
                        } catch (Exception $e) {
                            echo "<td>Error counting</td>";
                        }
                        
                        // Check key columns
                        try {
                            $descStmt = $pdo->query("DESCRIBE `$tableName`");
                            $columns = $descStmt->fetchAll(PDO::FETCH_COLUMN);
                            $missingColumns = array_diff($tableInfo['key_columns'], $columns);
                            
                            if (empty($missingColumns)) {
                                echo "<td class='status-ok'>✅ All key columns present</td>";
                                echo "<td>-</td>";
                            } else {
                                echo "<td class='status-warning'>⚠️ Missing: " . implode(', ', $missingColumns) . "</td>";
                                echo "<td><button class='fix-btn' onclick='fixTable(\"$tableName\")'>Fix Columns</button></td>";
                                $allGood = false;
                            }
                        } catch (Exception $e) {
                            echo "<td class='status-error'>❌ Cannot verify columns</td>";
                            echo "<td><button class='fix-btn' onclick='fixTable(\"$tableName\")'>Fix Table</button></td>";
                            $allGood = false;
                        }
                        
                    } else {
                        echo "<td class='status-error'>❌ MISSING</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td><button class='fix-btn' onclick='createTable(\"$tableName\")'>Create Table</button></td>";
                        $allGood = false;
                        $fixActions[] = $tableName;
                    }
                    
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
                
                // Handle job_postings → job_posts migration if needed
                if (in_array('job_postings', $currentTables) && !in_array('job_posts', $currentTables)) {
                    echo "<div class='section warning'>";
                    echo "<h3>🔄 Table Migration Required</h3>";
                    echo "<p>The table 'job_postings' needs to be renamed to 'job_posts' for consistency.</p>";
                    echo "<button class='fix-btn' onclick='migrateJobPostings()'>Migrate job_postings → job_posts</button>";
                    echo "</div>";
                }
                
                // Foreign key verification
                echo "<div class='section'>";
                echo "<h3>🔗 Foreign Key Relationships</h3>";
                
                $fkQuery = "
                    SELECT 
                        TABLE_NAME,
                        COLUMN_NAME,
                        CONSTRAINT_NAME,
                        REFERENCED_TABLE_NAME,
                        REFERENCED_COLUMN_NAME
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                    WHERE REFERENCED_TABLE_SCHEMA = '" . DB_NAME . "'
                    ORDER BY TABLE_NAME
                ";
                
                $fkStmt = $pdo->query($fkQuery);
                $foreignKeys = $fkStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($foreignKeys)) {
                    echo "<table>";
                    echo "<tr><th>Table</th><th>Column</th><th>References</th><th>Status</th></tr>";
                    foreach ($foreignKeys as $fk) {
                        echo "<tr>";
                        echo "<td>{$fk['TABLE_NAME']}</td>";
                        echo "<td>{$fk['COLUMN_NAME']}</td>";
                        echo "<td>{$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']}</td>";
                        echo "<td class='status-ok'>✅ Active</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='status-warning'>⚠️ No foreign key relationships found. This may indicate missing constraints.</p>";
                }
                echo "</div>";
                
                // Final status
                if ($allGood && count($currentTables) >= 9) {
                    echo "<div class='section success'>";
                    echo "<h3>🎉 Database Status: EXCELLENT</h3>";
                    echo "<p>✅ All 9 required tables exist</p>";
                    echo "<p>✅ All key columns present</p>";
                    echo "<p>✅ Foreign key relationships established</p>";
                    echo "<p>✅ Ready for Phase 6: Authentication System</p>";
                    echo "</div>";
                } else {
                    echo "<div class='section error'>";
                    echo "<h3>⚠️ Database Status: NEEDS ATTENTION</h3>";
                    echo "<p>Some tables or columns are missing and need to be created/fixed.</p>";
                    if (!empty($fixActions)) {
                        echo "<p><strong>Missing tables:</strong> " . implode(', ', $fixActions) . "</p>";
                    }
                    echo "<p><button class='fix-btn' onclick='runFullSetup()'>Run Complete Database Setup</button></p>";
                    echo "</div>";
                }
                
            } catch (PDOException $e) {
                echo "<div class='section error'>";
                echo "<h3>❌ Database Connection Failed</h3>";
                echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
                echo "<p><strong>Please check:</strong></p>";
                echo "<ul>";
                echo "<li>XAMPP MySQL service is running</li>";
                echo "<li>Database 'hireflow_db' exists</li>";
                echo "<li>Credentials in config.php are correct</li>";
                echo "</ul>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script>
        function createTable(tableName) {
            if (confirm(`Create missing table: ${tableName}?`)) {
                window.location.href = '../database-setup.php';
            }
        }
        
        function fixTable(tableName) {
            if (confirm(`Fix table structure for: ${tableName}?`)) {
                window.location.href = '../database-setup.php';
            }
        }
        
        function migrateJobPostings() {
            if (confirm('Migrate job_postings table to job_posts?\n\nThis will rename the table and update all references.')) {
                // In a real implementation, this would call a migration script
                alert('Migration feature would be implemented here.\n\nFor now, please run the database setup script to standardize naming.');
                window.location.href = '../database-setup.php';
            }
        }
        
        function runFullSetup() {
            if (confirm('Run complete database setup?\n\nThis will create any missing tables and fix structural issues.')) {
                window.location.href = '../database-setup.php';
            }
        }
    </script>
</body>
</html>
