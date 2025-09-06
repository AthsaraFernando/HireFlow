<?php
// Password Diagnostic Script
require_once 'app/core/init.php';

echo "<h2>🔍 Password Diagnostic Test</h2>";
echo "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px;'>";

try {
    $db = Database::getInstance();
    
    // Test password
    $testPassword = 'HireFlow123!';
    $testEmail = 'admin@hireflow.com';
    
    echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>Testing Credentials:</h3>";
    echo "<p><strong>Email:</strong> $testEmail</p>";
    echo "<p><strong>Password:</strong> $testPassword</p>";
    echo "</div>";
    
    // Get user from database
    $stmt = $db->prepare("SELECT id, email, password, full_name FROM users WHERE email = ?");
    $stmt->execute([$testEmail]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
        echo "✅ User found in database: " . $user->full_name;
        echo "</div>";
        
        echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>Password Analysis:</h4>";
        echo "<p><strong>Stored hash:</strong> <code>" . htmlspecialchars($user->password) . "</code></p>";
        echo "<p><strong>Hash length:</strong> " . strlen($user->password) . " characters</p>";
        echo "<p><strong>Expected length:</strong> 60 characters (for bcrypt)</p>";
        echo "</div>";
        
        // Test password verification
        $verifyResult = password_verify($testPassword, $user->password);
        
        if ($verifyResult) {
            echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "✅ <strong>PASSWORD VERIFICATION SUCCESSFUL!</strong>";
            echo "<p>The password should work for login.</p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "❌ <strong>PASSWORD VERIFICATION FAILED!</strong>";
            echo "<p>This explains why login isn't working.</p>";
            echo "</div>";
            
            // Try to fix it
            echo "<h4>🔧 Attempting to fix the password...</h4>";
            $newHash = password_hash($testPassword, PASSWORD_DEFAULT);
            
            $updateStmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
            $updateResult = $updateStmt->execute([$newHash, $testEmail]);
            
            if ($updateResult) {
                echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
                echo "✅ Password updated with new hash";
                echo "</div>";
                
                // Test again
                $verifyNew = password_verify($testPassword, $newHash);
                if ($verifyNew) {
                    echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
                    echo "✅ New password verification successful!";
                    echo "</div>";
                } else {
                    echo "<div style='background: #f8d7da; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
                    echo "❌ New password verification still failing!";
                    echo "</div>";
                }
            }
        }
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "❌ User not found in database!";
        echo "</div>";
    }
    
    // Test the User model's authenticate method
    echo "<h3>🔧 Testing User Model Authentication</h3>";
    
    $userModel = new User();
    
    // Check if emailExists method works
    $emailExists = $userModel->emailExists($testEmail);
    
    if ($emailExists) {
        echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
        echo "✅ User model confirms email exists";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 10px; border-radius: 5px; margin: 5px 0;'>";
        echo "❌ User model says email doesn't exist";
        echo "</div>";
    }
    
    // Test signin process simulation
    echo "<h3>🔐 Simulating Login Process</h3>";
    
    $loginData = [
        'email' => $testEmail,
        'password' => $testPassword
    ];
    
    if ($userModel->validateLogin($loginData)) {
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "✅ <strong>LOGIN VALIDATION SUCCESSFUL!</strong>";
        echo "<p>The login should work now.</p>";
        echo "<p><a href='/HireFlow/public?url=signin'>Try logging in now</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
        echo "❌ <strong>LOGIN VALIDATION FAILED!</strong>";
        echo "<p><strong>Errors:</strong></p>";
        echo "<ul>";
        foreach ($userModel->errors as $field => $error) {
            echo "<li><strong>$field:</strong> $error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "❌ Error: " . htmlspecialchars($e->getMessage());
    echo "</div>";
}

echo "</div>";
?>
