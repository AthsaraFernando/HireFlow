<?php
require_once '../app/core/config.php';

echo "<h2>🎉 Final Database Verification</h2>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
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
    
    echo "<h3>📊 Complete Table Status:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background: #f8f9fa;'><th style='padding: 12px;'>Table Name</th><th style='padding: 12px;'>Status</th><th style='padding: 12px;'>Record Count</th></tr>";
    
    $allTablesExist = true;
    foreach($expectedTables as $table) {
        if(in_array($table, $tables)) {
            // Get record count for this table
            try {
                $countStmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
                $count = $countStmt->fetchColumn();
                echo "<tr><td style='padding: 8px;'>$table</td><td style='color: green; padding: 8px;'>✅ EXISTS</td><td style='padding: 8px;'>$count records</td></tr>";
            } catch(Exception $e) {
                echo "<tr><td style='padding: 8px;'>$table</td><td style='color: green; padding: 8px;'>✅ EXISTS</td><td style='padding: 8px;'>-</td></tr>";
            }
        } else {
            echo "<tr><td style='padding: 8px;'>$table</td><td style='color: red; padding: 8px;'>❌ MISSING</td><td style='padding: 8px;'>-</td></tr>";
            $allTablesExist = false;
        }
    }
    echo "</table>";
    
    echo "<br><div style='padding: 20px; border-radius: 8px; margin: 20px 0;";
    
    if($allTablesExist) {
        echo "background: #d4edda; color: #155724;'>";
        echo "<h3>🎉 PERFECT! Database Setup Complete!</h3>";
        echo "<p><strong>✅ All 9 tables exist and are ready!</strong></p>";
        echo "<p><strong>Total Tables:</strong> " . count($tables) . " / 9</p>";
        echo "<hr style='margin: 15px 0; border: none; border-top: 1px solid #c3e6cb;'>";
        echo "<h4>🚀 Ready for Phase 6: Authentication System</h4>";
        echo "<p>Your HireFlow database is now complete with:</p>";
        echo "<ul>";
        echo "<li>✅ User management (users, roles)</li>";
        echo "<li>✅ Job management (departments, job_postings)</li>";
        echo "<li>✅ Application workflow (applications, interviews)</li>";
        echo "<li>✅ System features (access_logs, notifications, system_settings)</li>";
        echo "</ul>";
    } else {
        echo "background: #f8d7da; color: #721c24;'>";
        echo "<h3>⚠️ Database Setup Incomplete</h3>";
        echo "<p>Some tables are still missing. Please review the table list above.</p>";
    }
    echo "</div>";
    
    // Show existing tables not in our expected list (just for completeness)
    $extraTables = array_diff($tables, $expectedTables);
    if(!empty($extraTables)) {
        echo "<h4>📋 Additional Tables Found:</h4>";
        echo "<ul>";
        foreach($extraTables as $extra) {
            echo "<li>$extra</li>";
        }
        echo "</ul>";
    }
    
    if($allTablesExist) {
        echo "<br><div style='background: #cff4fc; color: #055160; padding: 20px; border-radius: 8px;'>";
        echo "<h4>🎯 What's Next?</h4>";
        echo "<p><strong>Phase 6: Authentication System</strong></p>";
        echo "<p>Now that your database is complete, we can implement:</p>";
        echo "<ol>";
        echo "<li>🔐 <strong>Login/Logout functionality</strong></li>";
        echo "<li>🛡️ <strong>Role-based access control</strong></li>";
        echo "<li>🔒 <strong>Session management</strong></li>";
        echo "<li>👤 <strong>User authentication middleware</strong></li>";
        echo "<li>🚪 <strong>Protected routes</strong></li>";
        echo "</ol>";
        echo "<p><em>This will make your application fully functional with secure user access!</em></p>";
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h4>❌ Database Connection Error</h4>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body { 
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; 
    margin: 20px; 
    background: #f8f9fa;
    line-height: 1.6;
}
table { 
    margin: 10px 0; 
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
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
h2, h3, h4 {
    color: #343a40;
}
ul, ol {
    margin: 10px 0;
    padding-left: 25px;
}
li {
    margin: 5px 0;
}
</style>
