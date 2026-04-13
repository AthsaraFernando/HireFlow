<?php
// Test calendar data visualization
require_once '../app/core/init.php';

// Simulate HR Admin login
$_SESSION['USER'] = [
    'id' => 2,
    'role_id' => 2,
    'full_name' => 'HR Admin Test'
];

// Get current week
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime($currentWeekStart . ' +6 days'));

echo "<h1>Calendar Data Test</h1>";
echo "<p><strong>Week:</strong> $currentWeekStart to $currentWeekEnd</p>";
echo "<hr>";

$interviewModel = new Interview();

// Get calendar interviews
$calendar_interviews = $interviewModel->getCalendarInterviews($currentWeekStart, $currentWeekEnd);

echo "<h2>Calendar Interviews</h2>";
if ($calendar_interviews) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Date</th><th>Time</th><th>Candidate</th><th>Job</th><th>Duration</th></tr>";
    foreach ($calendar_interviews as $interview) {
        echo "<tr>";
        echo "<td>{$interview['id']}</td>";
        echo "<td>{$interview['scheduled_date']}</td>";
        echo "<td>{$interview['scheduled_time']}</td>";
        echo "<td>{$interview['candidate_name']}</td>";
        echo "<td>{$interview['job_title']}</td>";
        echo "<td>{$interview['duration_minutes']} min</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No interviews found for this week.</p>";
}

echo "<hr>";
echo "<h2>Interviews by Date (with positioning)</h2>";

$interviews_by_date = [];
if ($calendar_interviews) {
    foreach ($calendar_interviews as $interview) {
        $interviewDate = $interview['scheduled_date'];
        
        if (!isset($interviews_by_date[$interviewDate])) {
            $interviews_by_date[$interviewDate] = [];
        }
        
        $timeObj = new DateTime($interview['scheduled_time']);
        $hour = (int)$timeObj->format('G');
        $minute = (int)$timeObj->format('i');
        $topPosition = ($hour - 8) * 60 + ($minute);
        $duration = $interview['duration_minutes'] ?? 60;
        $height = ($duration / 60) * 60;
        
        $interviews_by_date[$interviewDate][] = [
            'id' => $interview['id'],
            'time' => $interview['scheduled_time'],
            'candidate' => $interview['candidate_name'],
            'job' => $interview['job_title'],
            'top' => max(0, $topPosition),
            'height' => $height
        ];
    }
}

foreach ($interviews_by_date as $date => $interviews) {
    echo "<h3>$date</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Time</th><th>Candidate</th><th>Job</th><th>Top Position</th><th>Height</th></tr>";
    foreach ($interviews as $interview) {
        echo "<tr>";
        echo "<td>{$interview['id']}</td>";
        echo "<td>{$interview['time']}</td>";
        echo "<td>{$interview['candidate']}</td>";
        echo "<td>{$interview['job']}</td>";
        echo "<td style='background: #e3f2fd;'>{$interview['top']}px</td>";
        echo "<td style='background: #e8f5e8;'>{$interview['height']}px</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
