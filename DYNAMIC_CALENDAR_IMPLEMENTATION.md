# Dynamic Interview Calendar Implementation

## Overview
The interview calendar has been updated to dynamically display interviews from the database with full support for role-based interviewer assignments and interview stages.

## Features Implemented

### 1. Dynamic Week Calendar View
- **Automatic Data Rendering**: Interviews are automatically populated from the `interviews` table
- **Smart Positioning**: Interview blocks are positioned based on scheduled time (8 AM = top)
- **Duration-Based Height**: Block height reflects actual interview duration
- **Color-Coded Stages**: Different colors for each interview stage:
  - Screening: `#6366f1` (Indigo)
  - Technical: `#8b5cf6` (Purple)
  - Managerial: `#a855f7` (Light Purple)
  - HR Review: `#7c3aed` (Dark Purple)
  - Final: `#6d28d9` (Deep Purple)

### 2. Week Navigation
- **Previous/Next Buttons**: Navigate through weeks using arrow buttons
- **URL-Based State**: Week selection persists via `?week_start=YYYY-MM-DD` parameter
- **Dynamic Title**: Calendar title updates to show current week range

### 3. Interview Display Features
- **Candidate Name**: Displayed prominently on each block
- **Job Title**: Shows position being interviewed for
- **Time**: Interview start time
- **Stage Badge**: Small badge showing interview stage (Screening, Technical, etc.)
- **Hover Effects**: Enhanced visual feedback with shadow and scale
- **Click Handler**: Click to view interview details

### 4. Database Integration
- **New Columns Used**:
  - `interview_stage` - Type of interview (Screening, Technical, Managerial, HR Review, Final)
  - `interviewer_role` - Role assignment (HR Admin, Recruitment Manager, etc.)
  - `duration_minutes` - Used to calculate block height
  - `scheduled_date` - Date filtering for week view
  - `scheduled_time` - Positioning calculation

### 5. Dynamic List View
- **Card-Based Layout**: Shows all interviews in expandable cards
- **Complete Details**: Displays candidate, interviewer, stage, role, location
- **Status Badges**: Visual indicators for interview status
- **Action Buttons**: Edit, View Details, Reschedule, Cancel

## Files Modified

### Controller: `/app/controllers/hradmin/InterviewSchedule.php`
```php
// Week calculation and navigation support
$currentWeekStart = isset($_GET['week_start']) ? $_GET['week_start'] : date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime($currentWeekStart . ' +6 days'));

// Week days generation for headers
$data['week_days'] = []; // Array of days with names, numbers, dates

// Interviews organized by date
$data['interviews_by_date'] = []; // Grouped by date with positioning
```

### Model: `/app/models/Interview.php`
```php
// Updated query to include new columns
SELECT i.interview_stage, i.interviewer_role, i.duration_minutes ...

// New helper methods
getInterviewerRoles() - Returns available roles
getInterviewStages() - Returns available stages
getInterviewersByRole($role) - Filters interviewers by role
getRecommendedRole($stage) - Suggests role based on stage
```

### View: `/app/views/hradmin/interview-schedule.view.php`
```php
// Dynamic calendar rendering
<?php foreach ($week_days as $day): ?>
    <div class="day-column <?= $day['is_today'] ? 'today' : '' ?>">
        <?php 
        $dayInterviews = $interviews_by_date[$day['date']] ?? [];
        foreach ($dayInterviews as $interview): ?>
            <div class="interview-block" style="top: <?= $interview['top_position'] ?>px; height: <?= $interview['height'] ?>px;">
            ...
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
```

## Usage

### Viewing Interviews
1. Navigate to **HR Admin → Interviews**
2. Calendar displays current week by default
3. Use ← → arrows to navigate weeks
4. Switch between Week/Day/List views using toggle buttons

### Scheduling with Roles
1. Click "Schedule Interview" button
2. Select Interview Stage (e.g., "Technical")
3. System automatically recommends appropriate role (e.g., "Recruitment Manager")
4. Choose specific interviewer from filtered list
5. Interview appears on calendar with stage-specific color

### Calendar Interaction
- **Click on interview block**: View detailed information
- **Hover**: See enhanced visual feedback
- **Today's column**: Highlighted with gradient background

## Technical Details

### Position Calculation
```php
// Top position: Hours since 8 AM × 60px + minutes
$hour = (int)$timeObj->format('G');
$minute = (int)$timeObj->format('i');
$topPosition = ($hour - 8) * 60 + ($minute);

// Height: Duration in hours × 60px
$height = ($duration / 60) * 60;
```

### Week Navigation
```javascript
function nextWeek() {
    const currentStart = '<?= $current_week_start ?>';
    const nextStart = new Date(currentStart);
    nextStart.setDate(nextStart.getDate() + 7);
    window.location.href = '<?= ROOT ?>/hradmin/interview-schedule?week_start=' + nextStart.toISOString().split('T')[0];
}
```

## Database Requirements

### Migration Applied
- File: `Database-Backup/add_interview_roles_migration.sql`
- Adds: `interview_stage` and `interviewer_role` columns
- Status: ✅ Successfully applied

### Sample Data Needed
For testing, ensure you have:
- Applications with status = 'Shortlisted'
- Active users with role_id 2 (HR Admin) or 3 (Recruitment Manager)
- Interview records with valid dates and times

## Future Enhancements
- Real-time updates via AJAX (no page reload)
- Drag-and-drop rescheduling
- Conflict detection (overlapping interviews)
- Email notifications when interviews are scheduled
- Video conferencing integration
- Interview feedback directly from calendar

## Troubleshooting

### No interviews showing?
1. Check database has interview records
2. Verify `scheduled_date` falls within current week
3. Ensure `status` is not 'Canceled'

### Wrong positioning?
- Interview times before 8 AM or after 5 PM may not display correctly
- Extend time slots if needed

### Navigation not working?
- Check JavaScript console for errors
- Verify `ROOT` constant is defined correctly
