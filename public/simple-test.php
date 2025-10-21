<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing step by step...<br><br>";

// Step 1
echo "Step 1: Loading config...<br>";
require "../app/core/config.php";
echo "✓ Config loaded<br><br>";

// Step 2
echo "Step 2: Loading functions...<br>";
require "../app/core/functions.php";
echo "✓ Functions loaded<br><br>";

// Step 3
echo "Step 3: Loading Database...<br>";
require "../app/core/Database.php";
echo "✓ Database loaded<br><br>";

// Step 4
echo "Step 4: Loading Model...<br>";
require "../app/core/Model.php";
echo "✓ Model loaded<br><br>";

// Step 5
echo "Step 5: Loading Controller...<br>";
require "../app/core/Controller.php";
echo "✓ Controller loaded<br><br>";

// Step 6
echo "Step 6: Loading Auth...<br>";
require "../app/core/Auth.php";
echo "✓ Auth loaded<br><br>";

// Step 7
echo "Step 7: Loading App...<br>";
require "../app/core/App.php";
echo "✓ App loaded<br><br>";

echo "<strong>All files loaded successfully!</strong>";
