<?php
// Fix the corrupted password hashes once and for all
require_once 'app/core/init.php';

echo "<h2>🔧 FINAL PASSWORD HASH FIX</h2>";

try {
    $db = Database::getInstance();
    
    $correctPassword = 'HireFlow123!';
    
    echo "<p><strong>Fixing password for:</strong> $correctPassword</p>";
    
    // Generate proper bcrypt hash
    $properHash = password_hash($correctPassword, PASSWORD_DEFAULT);
    
    echo "<p><strong>Generated hash length:</strong> " . strlen($properHash) . " characters</p>";
    echo "<p><strong>Hash preview:</strong> " . substr($properHash, 0, 40) . "...</p>";
    
    // Test the hash immediately
    if (password_verify($correctPassword, $properHash)) {
        echo "<p style='color: green;'>✅ Hash verification successful</p>";
    } else {
        echo "<p style='color: red;'>❌ Hash verification failed</p>";
        exit;
    }
    
    // Update all admin users
    $users = ['admin@hireflow.com', 'hr@hireflow.com', 'recruiter@hireflow.com'];
    
    foreach ($users as $email) {
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        $result = $stmt->execute([$properHash, $email]);
        
        if ($result) {
            echo "<p style='color: green;'>✅ Updated password for: $email</p>";
            
            // Verify it was saved correctly
            $checkStmt = $db->prepare("SELECT password, LENGTH(password) as len FROM users WHERE email = ?");
            $checkStmt->execute([$email]);
            $saved = $checkStmt->fetch();
            
            echo "<p>   - Saved hash length: {$saved->len} characters</p>";
            
            if (password_verify($correctPassword, $saved->password)) {
                echo "<p style='color: green;'>   - ✅ Verification successful</p>";
            } else {
                echo "<p style='color: red;'>   - ❌ Verification failed</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Failed to update: $email</p>";
        }
        echo "<br>";
    }
    
    echo "<h3>🎯 Ready to Test</h3>";
    echo "<p><strong>Credentials:</strong></p>";
    echo "<ul>";
    echo "<li>Email: admin@hireflow.com</li>";
    echo "<li>Password: $correctPassword</li>";
    echo "</ul>";
    echo "<p><a href='/HireFlow/public?url=signin' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Login Now</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
