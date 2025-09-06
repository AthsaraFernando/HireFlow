<?php
// Direct hash generation and manual SQL update
$password = 'HireFlow123!';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: $password\n";
echo "Generated hash: $hash\n";
echo "Hash length: " . strlen($hash) . "\n";
echo "Verification test: " . (password_verify($password, $hash) ? 'PASS' : 'FAIL') . "\n";

// SQL command to copy
echo "\nSQL to run in MySQL:\n";
echo "USE hireflow_db;\n";
echo "UPDATE users SET password = '$hash' WHERE email = 'admin@hireflow.com';\n";
echo "UPDATE users SET password = '$hash' WHERE email = 'hr@hireflow.com';\n";
echo "UPDATE users SET password = '$hash' WHERE email = 'recruiter@hireflow.com';\n";
?>
