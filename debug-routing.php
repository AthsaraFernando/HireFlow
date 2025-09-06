<?php
// Debug routing
$URL = $_GET['url'] ?? 'home';
$URL = explode("/", trim($URL, "/"));

echo "<h2>🔍 Routing Debug</h2>";
echo "<p><strong>Original URL:</strong> " . ($_GET['url'] ?? 'home') . "</p>";
echo "<p><strong>URL Array:</strong> " . print_r($URL, true) . "</p>";

if (isset($URL[0])) {
    echo "<p><strong>Folder:</strong> " . $URL[0] . "</p>";
}
if (isset($URL[1])) {
    echo "<p><strong>Controller Name:</strong> " . $URL[1] . "</p>";
    
    // Convert URL to class name
    function convertUrlToClassName($url) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $url)));
    }
    
    $controllerName = convertUrlToClassName($URL[1]);
    echo "<p><strong>Converted Class Name:</strong> " . $controllerName . "</p>";
    
    $fileName = "app/controllers/" . $URL[0] . "/" . $controllerName . ".php";
    echo "<p><strong>Expected File:</strong> " . $fileName . "</p>";
    
    if (file_exists($fileName)) {
        echo "<p style='color: green;'>✅ Controller file exists!</p>";
        
        // Try to include and instantiate
        try {
            require_once $fileName;
            if (class_exists($controllerName)) {
                echo "<p style='color: green;'>✅ Class $controllerName exists!</p>";
                $controller = new $controllerName();
                echo "<p style='color: green;'>✅ Controller instantiated successfully!</p>";
                
                if (method_exists($controller, 'index')) {
                    echo "<p style='color: green;'>✅ index() method exists!</p>";
                } else {
                    echo "<p style='color: red;'>❌ index() method missing!</p>";
                }
            } else {
                echo "<p style='color: red;'>❌ Class $controllerName not found!</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Controller file not found!</p>";
        
        // Check if file exists with different casing
        $variations = [
            "app/controllers/" . $URL[0] . "/" . ucfirst($URL[1]) . ".php",
            "app/controllers/" . $URL[0] . "/" . strtolower($URL[1]) . ".php",
            "app/controllers/" . $URL[0] . "/" . $URL[1] . ".php"
        ];
        
        foreach ($variations as $variation) {
            if (file_exists($variation)) {
                echo "<p style='color: orange;'>🔄 Found variation: $variation</p>";
            }
        }
    }
}

echo "<h3>📁 Available Controllers in systemadmin/:</h3>";
$files = scandir('app/controllers/systemadmin/');
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "<p>- $file</p>";
    }
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
</style>
