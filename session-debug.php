<?php
session_start();

echo "<h2>🔍 Session Debug Information</h2>";

echo "<h3>Current Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Session Status:</h3>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

if (isset($_SESSION['USER'])) {
    echo "<h3>⚠️ User is currently logged in:</h3>";
    echo "<pre>";
    print_r($_SESSION['USER']);
    echo "</pre>";
    
    echo "<p><a href='#' onclick='clearSession()' style='background: red; color: white; padding: 10px; text-decoration: none; border-radius: 5px;'>Force Clear Session</a></p>";
} else {
    echo "<h3>✅ No user logged in</h3>";
}

if (isset($_GET['clear'])) {
    session_destroy();
    session_start();
    echo "<p style='color: green; font-weight: bold;'>✅ Session cleared! Refresh to see changes.</p>";
}

echo "<h3>🔗 Quick Actions:</h3>";
echo "<p><a href='?clear=1'>Clear Session</a></p>";
echo "<p><a href='public?url=signin'>Go to Login</a></p>";
echo "<p><a href='public?url=signout'>Logout</a></p>";
?>

<script>
function clearSession() {
    if (confirm('Clear the current session?')) {
        window.location.href = '?clear=1';
    }
}
</script>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
a { display: inline-block; margin: 5px; padding: 8px 15px; background: #007cba; color: white; text-decoration: none; border-radius: 3px; }
a:hover { background: #005a87; }
</style>
