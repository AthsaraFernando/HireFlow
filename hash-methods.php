<?php
// Alternative hash generation method
$password = 'HireFlow123!';

// Method 1: Standard password_hash
$hash1 = password_hash($password, PASSWORD_BCRYPT);
echo "Method 1 (PASSWORD_BCRYPT): $hash1 (Length: " . strlen($hash1) . ")\n";

// Method 2: With specific cost
$hash2 = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
echo "Method 2 (cost=10): $hash2 (Length: " . strlen($hash2) . ")\n";

// Method 3: PASSWORD_DEFAULT
$hash3 = password_hash($password, PASSWORD_DEFAULT);
echo "Method 3 (PASSWORD_DEFAULT): $hash3 (Length: " . strlen($hash3) . ")\n";

// Test all three
echo "\nVerification tests:\n";
echo "Method 1: " . (password_verify($password, $hash1) ? 'PASS' : 'FAIL') . "\n";
echo "Method 2: " . (password_verify($password, $hash2) ? 'PASS' : 'FAIL') . "\n";
echo "Method 3: " . (password_verify($password, $hash3) ? 'PASS' : 'FAIL') . "\n";

echo "\n=== RECOMMENDED HASH ===\n";
echo $hash2;
echo "\n========================\n";
?>
