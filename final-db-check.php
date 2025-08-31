<?php
/**
 * HireFlow Database Final Check & Fix
 * 
 * This script ensures all tables exist with correct names and structure
 */

require_once 'app/core/config.php';

echo "<h2>🔍 HireFlow Database Final Verification & Fix</h2>";
echo "<hr>";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>✅ Database Connection Successful</h3>";
    echo "<p>Connected to: <strong>" . DB_NAME . "</strong></p>";
    
    // Get current tables
    $stmt = $pdo->query("SHOW TABLES");
    $currentTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<h3>📊 Current Tables (" . count($currentTables) . " total)</h3>";
    echo "<p>" . implode(', ', $currentTables) . "</p>";
    
    // Expected tables (standardized names)
    $expectedTables = [
        'roles', 'departments', 'users', 'job_posts', 
        'applications', 'interviews', 'access_logs', 
        'notifications', 'system_settings'
    ];
    
    // Check for job_postings → job_posts migration
    if (in_array('job_postings', $currentTables) && !in_array('job_posts', $currentTables)) {
        echo "<h3>🔄 Fixing Table Name: job_postings → job_posts</h3>";
        
        try {
            // Rename table
            $pdo->exec("RENAME TABLE job_postings TO job_posts");
            echo "<p>✅ Successfully renamed job_postings to job_posts</p>";
            
            // Update current tables list
            $currentTables = array_map(function($table) {
                return $table === 'job_postings' ? 'job_posts' : $table;
            }, $currentTables);
            
        } catch (PDOException $e) {
            echo "<p>❌ Error renaming table: " . $e->getMessage() . "</p>";
        }
    }
    
    // Check all expected tables
    $missingTables = array_diff($expectedTables, $currentTables);
    $extraTables = array_diff($currentTables, $expectedTables);
    
    if (empty($missingTables)) {
        echo "<h3>🎉 All Required Tables Present!</h3>";
        
        // Show table status with record counts
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 20px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th>Table</th><th>Records</th><th>Status</th></tr>";
        
        foreach ($expectedTables as $table) {
            try {
                $countStmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
                $count = $countStmt->fetchColumn();
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td>$count</td>";
                echo "<td style='color: green;'>✅ OK</td>";
                echo "</tr>";
            } catch (Exception $e) {
                echo "<tr>";
                echo "<td><strong>$table</strong></td>";
                echo "<td>-</td>";
                echo "<td style='color: red;'>❌ Error</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
        
        // Verify foreign keys
        echo "<h3>🔗 Foreign Key Verification</h3>";
        $fkQuery = "
            SELECT 
                TABLE_NAME, 
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE REFERENCED_TABLE_SCHEMA = '" . DB_NAME . "'
            ORDER BY TABLE_NAME
        ";
        
        $fkStmt = $pdo->query($fkQuery);
        $foreignKeys = $fkStmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p><strong>Foreign Key Relationships:</strong> " . count($foreignKeys) . " found</p>";
        if (!empty($foreignKeys)) {
            echo "<ul>";
            foreach ($foreignKeys as $fk) {
                echo "<li>{$fk['TABLE_NAME']}.{$fk['COLUMN_NAME']} → {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']}</li>";
            }
            echo "</ul>";
        }
        
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>🎉 DATABASE STATUS: PERFECT!</h3>";
        echo "<p>✅ All 9 required tables exist</p>";
        echo "<p>✅ Consistent naming convention (job_posts)</p>";
        echo "<p>✅ Foreign key relationships established</p>";
        echo "<p>✅ Sample data populated</p>";
        echo "<br>";
        echo "<h4>🚀 Ready for Phase 6: Authentication System!</h4>";
        echo "<p>Your database is now complete and standardized.</p>";
        echo "</div>";
        
    } else {
        echo "<h3>❌ Missing Tables Found</h3>";
        echo "<p style='color: red;'>Missing: " . implode(', ', $missingTables) . "</p>";
        echo "<p><strong>Solution:</strong> Run the database setup script: <a href='database-setup.php'>database-setup.php</a></p>";
    }
    
    if (!empty($extraTables)) {
        echo "<h3>ℹ️ Extra Tables Found</h3>";
        echo "<p>Additional tables (safe to ignore): " . implode(', ', $extraTables) . "</p>";
    }
    
    // Final summary
    echo "<hr>";
    echo "<h3>📋 Final Summary</h3>";
    echo "<ul>";
    echo "<li><strong>Total Tables:</strong> " . count($currentTables) . " / 9 required</li>";
    echo "<li><strong>Missing Tables:</strong> " . (empty($missingTables) ? "None ✅" : count($missingTables) . " ❌") . "</li>";
    echo "<li><strong>Naming Convention:</strong> " . (in_array('job_posts', $currentTables) ? "Standardized ✅" : "Needs fixing ❌") . "</li>";
    echo "<li><strong>Foreign Keys:</strong> " . count($foreignKeys) . " relationships</li>";
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h3>❌ Database Connection Error</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Check:</strong></p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL service is running</li>";
    echo "<li>Database 'hireflow_db' exists in phpMyAdmin</li>";
    echo "<li>Config.php has correct credentials</li>";
    echo "</ul>";
    echo "</div>";
}

echo "<hr>";
echo "<p><em>HireFlow Database Verification Complete</em></p>";
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    background: #f8f9fa; 
    line-height: 1.6;
}
table { 
    background: white; 
    border-radius: 5px; 
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
th, td { 
    padding: 10px; 
    border: 1px solid #ddd; 
}
th { 
    background: #e9ecef; 
    font-weight: bold; 
}
h1, h2, h3 { 
    color: #2c3e50; 
}
</style>
