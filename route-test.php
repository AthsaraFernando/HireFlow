<?php
echo "<h2>🔍 Route Testing</h2>";

// Test routes
$testRoutes = [
    'systemadmin/dashboard',
    'systemadmin/usermanage', 
    'systemadmin/accesslogs',
    'systemadmin/viewdata'
];

foreach ($testRoutes as $route) {
    $url = "http://localhost/HireFlow/public?url=" . $route;
    echo "<p><a href='$url' target='_blank'>Test: $route</a></p>";
}

echo "<h3>Direct Controller Test</h3>";
$controllers = [
    'Dashboard' => 'app/controllers/systemadmin/Dashboard.php',
    'Usermanage' => 'app/controllers/systemadmin/Usermanage.php',
    'Accesslogs' => 'app/controllers/systemadmin/Accesslogs.php',
    'Viewdata' => 'app/controllers/systemadmin/Viewdata.php'
];

foreach ($controllers as $name => $path) {
    if (file_exists($path)) {
        echo "<p>✅ $name controller exists</p>";
    } else {
        echo "<p>❌ $name controller missing</p>";
    }
}

// Debug URL parsing
echo "<h3>URL Parsing Test</h3>";
$testUrl = "systemadmin/usermanage";
$URL = explode("/", trim($testUrl, "/"));
echo "<p>URL array: " . print_r($URL, true) . "</p>";
echo "<p>Folder: " . $URL[0] . "</p>";
echo "<p>Controller: " . (isset($URL[1]) ? $URL[1] : 'none') . "</p>";

// Test convertUrlToClassName function
function convertUrlToClassName($url) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $url)));
}

echo "<p>Converted 'usermanage': " . convertUrlToClassName('usermanage') . "</p>";
echo "<p>Expected file: app/controllers/systemadmin/Usermanage.php</p>";

?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
