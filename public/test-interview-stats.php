<?php
// Test interview statistics calculation
require_once '../app/core/init.php';

// Create Interview model instance
$interviewModel = new Interview();

// Calculate current week
$actualCurrentWeekStart = date('Y-m-d', strtotime('monday this week'));
$actualCurrentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

echo "<h1>Interview Statistics Test</h1>";
echo "<p><strong>Current Date:</strong> " . date('Y-m-d') . " (" . date('l, F j, Y') . ")</p>";
echo "<p><strong>Current Week:</strong> $actualCurrentWeekStart to $actualCurrentWeekEnd</p>";
echo "<hr>";

// Get statistics
$stats = $interviewModel->getInterviewStats($actualCurrentWeekStart, $actualCurrentWeekEnd);

echo "<h2>Statistics Results:</h2>";
echo "<ul>";
echo "<li><strong>Total Interviews:</strong> " . ($stats['total_interviews'] ?? 'N/A') . "</li>";
echo "<li><strong>Today:</strong> " . ($stats['today_interviews'] ?? 'N/A') . "</li>";
echo "<li><strong>This Week:</strong> " . ($stats['week_interviews'] ?? 'N/A') . "</li>";
echo "<li><strong>Pending:</strong> " . ($stats['pending_interviews'] ?? 'N/A') . "</li>";
echo "<li><strong>Completed:</strong> " . ($stats['completed_interviews'] ?? 'N/A') . "</li>";
echo "<li><strong>Average Rating:</strong> " . number_format($stats['avg_rating'] ?? 0, 1) . "</li>";
echo "</ul>";

echo "<hr>";
echo "<h2>Pending Interviews (Details):</h2>";
$today = date('Y-m-d');
$pendingQuery = "SELECT id, scheduled_date, scheduled_time, status 
                 FROM interviews 
                 WHERE status IN ('Scheduled', 'Pending') AND scheduled_date >= ?
                 ORDER BY scheduled_date, scheduled_time";
$pending = $interviewModel->query($pendingQuery, [$today]);

if ($pending) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Date</th><th>Time</th><th>Status</th></tr>";
    foreach ($pending as $interview) {
        echo "<tr>";
        echo "<td>{$interview['id']}</td>";
        echo "<td>{$interview['scheduled_date']}</td>";
        echo "<td>{$interview['scheduled_time']}</td>";
        echo "<td>{$interview['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No pending interviews found.</p>";
}
?>
