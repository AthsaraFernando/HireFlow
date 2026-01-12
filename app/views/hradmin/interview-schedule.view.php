<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">HR Admin</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/create-job" class="nav-link">
                        <span class="nav-text">Create Job</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link">
                        <span class="nav-text">Job Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicants & Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/interview-schedule" class="nav-link active">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/profile" class="nav-link">
                        <span class="nav-text">My Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn">
                <span>Logout</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <
                </button>
                <h1 class="page-title">Interview Schedule</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">Interview Schedule</h1>
                        <p class="hero-description">Schedule and manage interviews with top candidates. Coordinate with your team and track interview progress.</p>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="stat-number"><?= $interviews_today ?? '0' ?></span>
                                <span class="stat-label">Today</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $interviews_this_week ?? '0' ?></span>
                                <span class="stat-label">This Week</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $interviews_pending ?? '0' ?></span>
                                <span class="stat-label">Pending</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <button class="btn btn-primary" onclick="scheduleNewInterview()">
                            <i class="icon-calendar-plus"></i>Schedule Interview
                        </button>
                        <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="btn btn-outline">
                            <i class="icon-applications"></i>View Applications
                        </a>
                    </div>
                </div>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach($errors as $error): ?>
                            <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <p><?php echo $success ?></p>
        </div>
    <?php endif; ?>

    <!-- Interview Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?= $total_interviews ?? '45' ?></div>
            <div class="stat-label">Total Interviews</div>
            <div class="stat-change positive">This month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $upcoming_interviews ?? '12' ?></div>
            <div class="stat-label">Upcoming</div>
            <div class="stat-change positive">Next 7 days</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $completed_interviews ?? '28' ?></div>
            <div class="stat-label">Completed</div>
            <div class="stat-change positive">This month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $avg_rating ?? '4.2' ?></div>
            <div class="stat-label">Avg Rating</div>
            <div class="stat-change positive">Post-interview</div>
        </div>
    </div>

    <!-- Calendar and Schedule View -->
    <div class="schedule-container">
        <!-- Calendar Navigation -->
        <div class="calendar-header">
            <div class="calendar-nav">
                <button class="nav-btn" onclick="previousWeek()">
                    ←
                </button>
                <h3 class="calendar-title"><?= $week_title ?? 'This Week' ?></h3>
                <button class="nav-btn" onclick="nextWeek()">
                    →
                </button>
            </div>
            <div class="view-toggles">
                <button class="view-toggle active" onclick="setCalendarView('week')">Week</button>
                <button class="view-toggle" onclick="setCalendarView('day')">Day</button>
                <button class="view-toggle" onclick="setCalendarView('list')">List</button>
            </div>
        </div>

        <!-- Weekly Calendar View -->
        <div id="weekView" class="calendar-grid">
            <div class="time-column">
                <div class="time-slot">8:00 AM</div>
                <div class="time-slot">9:00 AM</div>
                <div class="time-slot">10:00 AM</div>
                <div class="time-slot">11:00 AM</div>
                <div class="time-slot">12:00 PM</div>
                <div class="time-slot">1:00 PM</div>
                <div class="time-slot">2:00 PM</div>
                <div class="time-slot">3:00 PM</div>
                <div class="time-slot">4:00 PM</div>
                <div class="time-slot">5:00 PM</div>
            </div>
            
            <?php if (!empty($week_days)): ?>
                <?php foreach ($week_days as $day): ?>
                    <!-- <?= $day['day_name'] ?> -->
                    <div class="day-column <?= $day['is_today'] ? 'today' : '' ?> <?= $day['is_weekend'] ? 'weekend' : '' ?>">
                        <div class="day-header">
                            <div class="day-name"><?= $day['day_name'] ?></div>
                            <div class="day-date"><?= $day['day_number'] ?></div>
                        </div>
                        <div class="day-slots">
                            <?php 
                            $dayInterviews = $interviews_by_date[$day['date']] ?? [];
                            if (!empty($dayInterviews)): 
                                foreach ($dayInterviews as $interview): 
                                    $statusClass = strtolower($interview['status']);
                                    $stageColor = match($interview['interview_stage']) {
                                        'Screening' => '#6366f1',
                                        'Technical' => '#8b5cf6',
                                        'Managerial' => '#a855f7',
                                        'HR Review' => '#7c3aed',
                                        'Final' => '#6d28d9',
                                        default => '#6366f1'
                                    };
                            ?>
                            <div class="interview-block status-<?= $statusClass ?>" 
                                 style="top: <?= $interview['top_position'] ?>px; height: <?= $interview['height'] ?>px; background: <?= $stageColor ?>;"
                                 onclick="viewInterviewDetails(<?= $interview['id'] ?>)"
                                 title="<?= htmlspecialchars($interview['interview_stage']) ?> - <?= htmlspecialchars($interview['interviewer_role']) ?>">
                                <div class="interview-info">
                                    <div class="interview-time"><?= htmlspecialchars($interview['display_time']) ?></div>
                                    <div class="interview-candidate"><?= htmlspecialchars($interview['candidate_name']) ?></div>
                                    <div class="interview-position"><?= htmlspecialchars($interview['job_title']) ?></div>
                                    <div class="interview-stage-badge"><?= htmlspecialchars($interview['interview_stage']) ?></div>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- List View (Hidden by default) -->
        <div id="listView" class="interview-list" style="display: none;">
            <?php if (!empty($interviews)): ?>
                <?php foreach ($interviews as $interview): 
                    $statusClass = strtolower($interview['status']);
                    $statusLabel = $interview['status'];
                    $interviewDateTime = date('F j, Y', strtotime($interview['date']));
                    $endTime = date('g:i A', strtotime($interview['time']) + ($interview['duration_minutes'] ?? 60) * 60);
                ?>
                <div class="interview-card">
                    <div class="interview-header">
                        <div class="interview-datetime">
                            <div class="interview-date"><?= $interviewDateTime ?></div>
                            <div class="interview-time"><?= $interview['time'] ?> - <?= $endTime ?></div>
                        </div>
                        <div class="interview-status">
                            <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span>
                        </div>
                    </div>
                    <div class="interview-details">
                        <div class="candidate-section">
                            <h4><?= htmlspecialchars($interview['applicant_name']) ?></h4>
                            <p><strong>Applying for:</strong> <?= htmlspecialchars($interview['position']) ?></p>
                            <p><strong>Interview Stage:</strong> <?= htmlspecialchars($interview['interview_stage'] ?? 'N/A') ?></p>
                            <p><strong>Interview Type:</strong> <?= htmlspecialchars($interview['type']) ?></p>
                        </div>
                        <div class="interview-meta">
                            <div class="interviewer">
                                <strong>Interviewer:</strong> <?= htmlspecialchars($interview['interviewer']) ?>
                            </div>
                            <div class="role">
                                <strong>Role:</strong> <?= htmlspecialchars($interview['interviewer_role'] ?? 'N/A') ?>
                            </div>
                            <div class="location">
                                <strong>Location:</strong> <?= htmlspecialchars($interview['location']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="interview-actions">
                        <button class="btn btn-outline btn-sm" onclick="editInterview(<?= $interview['id'] ?>)">Edit</button>
                        <button class="btn btn-primary btn-sm" onclick="joinInterview(<?= $interview['id'] ?>)">View Details</button>
                        <button class="btn btn-secondary btn-sm" onclick="reschedule(<?= $interview['id'] ?>)">Reschedule</button>
                        <button class="btn btn-danger btn-sm" onclick="cancelInterview(<?= $interview['id'] ?>)">Cancel</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No interviews scheduled for this period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upcoming Interviews Summary -->
    <div class="summary-section">
        <h3>Today's Interviews</h3>
        <div class="today-interviews">
            <div class="today-item">
                <div class="time">10:00 AM</div>
                <div class="details">
                    <div class="candidate">John Smith</div>
                    <div class="position">Senior Software Developer</div>
                    <div class="interviewer">with Sarah Johnson</div>
                </div>
                <div class="actions">
                    <button class="btn btn-sm btn-primary" onclick="joinInterview(1)">Join</button>
                </div>
            </div>
            <div class="today-item">
                <div class="time">2:00 PM</div>
                <div class="details">
                    <div class="candidate">Sarah Johnson</div>
                    <div class="position">UI/UX Designer</div>
                    <div class="interviewer">with Mike Wilson</div>
                </div>
                <div class="actions">
                    <button class="btn btn-sm btn-outline" onclick="prepareInterview(2)">Prepare</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Interview Modal -->
<div id="scheduleModal" class="modal" style="display: none;">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>Schedule New Interview</h3>
            <button class="modal-close" onclick="closeScheduleModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form class="schedule-form" method="POST" action="<?= ROOT ?>/hradmin/interview-schedule">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Candidate</label>
                        <select name="application_id" class="form-select" required>
                            <option value="">Select Candidate</option>
                            <?php if(!empty($available_candidates)): ?>
                                <?php foreach($available_candidates as $candidate): ?>
                                    <option value="<?= $candidate['application_id'] ?>" title="Status: <?= htmlspecialchars($candidate['application_status']) ?> | Applied: <?= htmlspecialchars($candidate['applied_date']) ?>">
                                        <?= htmlspecialchars($candidate['candidate_name']) ?> - <?= htmlspecialchars($candidate['job_title']) ?> (<?= htmlspecialchars($candidate['application_status']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No candidates available for interview</option>
                            <?php endif; ?>
                        </select>
                        <?php if(empty($available_candidates)): ?>
                            <small class="form-help text-muted">
                                No candidates found. Make sure there are applications with status: Applied, Under Review, or Shortlisted.
                            </small>
                        <?php else: ?>
                            <small class="form-help text-muted">
                                Showing <?= count($available_candidates) ?> candidate(s) available for interview scheduling.
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Interview Stage</label>
                        <select name="interview_stage" class="form-select" required onchange="updateRecommendedRole(this.value)">
                            <option value="">Select Interview Stage</option>
                            <?php if(!empty($interview_stages)): ?>
                                <?php foreach($interview_stages as $stage => $description): ?>
                                    <option value="<?= $stage ?>" title="<?= htmlspecialchars($description) ?>">
                                        <?= htmlspecialchars($stage) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interviewer Role</label>
                        <select name="interviewer_role" class="form-select" required onchange="filterInterviewers(this.value)">
                            <option value="">Select Interviewer Role</option>
                            <?php if(!empty($interviewer_roles)): ?>
                                <?php foreach($interviewer_roles as $role => $description): ?>
                                    <option value="<?= $role ?>" title="<?= htmlspecialchars($description) ?>">
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interviewer</label>
                        <select name="interviewer_id" class="form-select" required>
                            <option value="">Select Interviewer</option>
                            <?php if(!empty($interviewers_by_role)): ?>
                                <?php foreach($interviewers_by_role as $interviewer): ?>
                                    <option value="<?= $interviewer['id'] ?>" data-role="<?= htmlspecialchars($interviewer['user_role']) ?>">
                                        <?= htmlspecialchars($interviewer['full_name']) ?> (<?= htmlspecialchars($interviewer['user_role']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interview Date</label>
                        <input type="date" name="scheduled_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="scheduled_time" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Duration (minutes)</label>
                        <select name="duration_minutes" class="form-select">
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60" selected>1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interview Type</label>
                        <select name="interview_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Phone">Phone Screen</option>
                            <option value="Video">Video Interview</option>
                            <option value="In-Person">In-Person</option>
                            <option value="Technical">Technical Interview</option>
                            <option value="Panel">Panel Interview</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-input" placeholder="Conference Room A, Office Building, etc.">
                    </div>
                    <div class="form-group">
                        <label>Meeting Link (Optional)</label>
                        <input type="url" name="meeting_link" class="form-input" placeholder="https://zoom.us/j/123456789 or other meeting link">
                    </div>
                    <div class="form-group full-width">
                        <label>Notes</label>
                        <textarea name="notes" class="form-textarea" rows="3" placeholder="Interview agenda, special instructions, etc."></textarea>
                    </div>
                    <input type="hidden" name="status" value="Scheduled">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeScheduleModal()">Cancel</button>
            <button class="btn btn-primary" onclick="document.querySelector('.schedule-form').submit()">Schedule Interview</button>
        </div>
    </div>
</div>

<style>
.schedule-container {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.calendar-nav {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-btn {
    padding: 0.5rem;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
}

.nav-btn:hover {
    background: #f8f9fa;
}

.calendar-title {
    margin: 0;
    color: #2c3e50;
    font-size: 1.25rem;
}

.view-toggles {
    display: flex;
    gap: 0.25rem;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.25rem;
}

.view-toggle {
    padding: 0.5rem 1rem;
    border: none;
    background: none;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.view-toggle.active {
    background: #4e31aa;
    color: white;
}

.calendar-grid {
    display: grid;
    grid-template-columns: 80px repeat(5, 1fr);
    gap: 1px;
    background: #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.time-column {
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
}

.time-slot {
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    color: #6c757d;
    border-bottom: 1px solid #e9ecef;
}

.day-column {
    background: white;
    position: relative;
}

.day-header {
    background: #f8f9fa;
    padding: 0.75rem;
    text-align: center;
    border-bottom: 1px solid #e9ecef;
}

.day-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.875rem;
}

.day-date {
    font-size: 1.25rem;
    color: #4e31aa;
    font-weight: 700;
}

.day-slots {
    height: 600px;
    position: relative;
}

.interview-block {
    position: absolute;
    left: 4px;
    right: 4px;
    background: #4e31aa;
    color: white;
    border-radius: 6px;
    padding: 6px;
    cursor: pointer;
    transition: all 0.2s;
    overflow: visible;
    min-height: 50px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.interview-block:hover {
    background: #3d2688;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 10;
}

.interview-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.interview-time {
    font-size: 0.75rem;
    font-weight: 600;
}

.interview-candidate {
    font-size: 0.875rem;
    font-weight: 600;
    white-space: normal;
    line-height: 1.2;
    margin-bottom: 2px;
    color: white;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.interview-position {
    font-size: 0.75rem;
    font-weight: 400;
    white-space: normal;
    line-height: 1.1;
    margin-bottom: 3px;
    color: rgba(255,255,255,0.95);
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.interview-stage-badge {
    font-size: 0.65rem;
    background: rgba(255,255,255,0.25);
    padding: 1px 4px;
    border-radius: 3px;
    display: inline-block;
    width: fit-content;
    color: white;
    font-weight: 500;
    border: 1px solid rgba(255,255,255,0.1);
}

.day-column.today .day-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.day-column.weekend {
    background-color: #fafafa;
}

.day-column.weekend .day-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #6c757d;
}

.day-column.weekend.today .day-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.interview-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.interview-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
    background: white;
}

.interview-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.interview-date {
    font-weight: 600;
    color: #2c3e50;
}

.interview-time {
    color: #6c757d;
    font-size: 0.875rem;
}

.interview-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.candidate-section h4 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.candidate-section p {
    margin: 0.25rem 0;
    color: #6c757d;
    font-size: 0.875rem;
}

.interview-meta > div {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.interview-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.summary-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.summary-section h3 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
}

.today-interviews {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.today-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.today-item .time {
    font-weight: 600;
    color: #4e31aa;
    min-width: 80px;
}

.today-item .details {
    flex: 1;
}

.today-item .candidate {
    font-weight: 600;
    color: #2c3e50;
}

.today-item .position {
    color: #6c757d;
    font-size: 0.875rem;
}

.today-item .interviewer {
    color: #6c757d;
    font-size: 0.875rem;
}

.schedule-form .form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.schedule-form .full-width {
    grid-column: span 2;
}

.modal-content.large {
    max-width: 800px;
}

/* Icon styles - removed emojis */

/* Responsive design */
@media (max-width: 768px) {
    .calendar-grid {
        grid-template-columns: 60px 1fr;
    }
    
    .day-column {
        display: none;
    }
    
    .day-column:first-of-type {
        display: block;
    }
    
    .calendar-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .interview-details {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .today-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .schedule-form .form-grid {
        grid-template-columns: 1fr;
    }
    
    .schedule-form .full-width {
        grid-column: span 1;
    }
}
</style>

/* Modern HR Admin Design System */
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 2rem;
    }

    .hero-section {
        background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 50%, #667eea 100%);
        color: white;
        padding: 3rem 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        pointer-events: none;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .hero-description {
        font-size: 1.125rem;
        opacity: 1;
        margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.95);
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .interview-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 2rem;
    }

    .interview-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* Icons */
    .icon-calendar-plus::before { content: '📅'; }
    .icon-applications::before { content: '📋'; }

    @media (max-width: 768px) {
        .hero-section { flex-direction: column; text-align: center; }
        .dashboard-content { padding: 1rem; }
    }
</style>

<script>
function scheduleNewInterview() {
    document.getElementById('scheduleModal').style.display = 'flex';
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').style.display = 'none';
}

function saveInterview() {
    alert('Interview scheduled successfully!');
    closeScheduleModal();
    location.reload();
}

function setCalendarView(view) {
    const weekView = document.getElementById('weekView');
    const listView = document.getElementById('listView');
    const toggles = document.querySelectorAll('.view-toggle');
    
    toggles.forEach(t => t.classList.remove('active'));
    
    if (view === 'week') {
        weekView.style.display = 'grid';
        listView.style.display = 'none';
        toggles[0].classList.add('active');
    } else if (view === 'list') {
        weekView.style.display = 'none';
        listView.style.display = 'flex';
        toggles[2].classList.add('active');
    }
}

function previousWeek() {
    const currentStart = '<?= $current_week_start ?? date('Y-m-d', strtotime('monday this week')) ?>';
    const previousStart = new Date(currentStart);
    previousStart.setDate(previousStart.getDate() - 7);
    const dateStr = previousStart.toISOString().split('T')[0];
    window.location.href = '<?= ROOT ?>/hradmin/interview-schedule?week_start=' + dateStr;
}

function nextWeek() {
    const currentStart = '<?= $current_week_start ?? date('Y-m-d', strtotime('monday this week')) ?>';
    const nextStart = new Date(currentStart);
    nextStart.setDate(nextStart.getDate() + 7);
    const dateStr = nextStart.toISOString().split('T')[0];
    window.location.href = '<?= ROOT ?>/hradmin/interview-schedule?week_start=' + dateStr;
}

function viewInterviewDetails(interviewId) {
    // Open detailed view modal or navigate to details page
    alert('Interview ID: ' + interviewId + '\nDetailed view coming soon...');
    // window.location.href = '<?= ROOT ?>/hradmin/interview-details/' + interviewId;
}

function editInterview(id) {
    alert(`Editing interview ${id}`);
    // Open edit modal
}

function joinInterview(id) {
    alert(`Joining interview ${id}`);
    // Open interview platform
}

function reschedule(id) {
    alert(`Rescheduling interview ${id}`);
    // Open reschedule modal
}

function cancelInterview(id) {
    if (confirm('Are you sure you want to cancel this interview?')) {
        alert(`Interview ${id} cancelled`);
        location.reload();
    }
}

function prepareInterview(id) {
    alert(`Opening interview preparation for interview ${id}`);
    // Open preparation materials
}

// Close modal when clicking outside
document.getElementById('scheduleModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeScheduleModal();
    }
});

// Auto-refresh every 30 seconds to update interview status
setInterval(() => {
    console.log('Checking for interview updates...');
}, 30000);

// Role-based interviewer assignment functions
const stageRoleRecommendations = {
    'Screening': 'HR Admin',
    'Technical': 'Recruitment Manager',
    'Managerial': 'Recruitment Manager', 
    'HR Review': 'HR Admin',
    'Final': 'Recruitment Manager'
};

function updateRecommendedRole(stage) {
    const roleSelect = document.querySelector('select[name="interviewer_role"]');
    const recommendedRole = stageRoleRecommendations[stage];
    
    if (recommendedRole && roleSelect) {
        // Set the recommended role
        roleSelect.value = recommendedRole;
        
        // Trigger the interviewer filter
        filterInterviewers(recommendedRole);
        
        // Add visual indicator for recommendation
        roleSelect.style.backgroundColor = '#e8f5e8';
        setTimeout(() => {
            roleSelect.style.backgroundColor = '';
        }, 2000);
    }
}

function filterInterviewers(selectedRole) {
    const interviewerSelect = document.querySelector('select[name="interviewer_id"]');
    const allOptions = interviewerSelect.querySelectorAll('option[data-role]');
    
    // First, hide all interviewer options except the default one
    allOptions.forEach(option => {
        option.style.display = 'none';
    });
    
    // Show only interviewers that match the selected role or show all for certain roles
    if (selectedRole === 'HR Admin') {
        allOptions.forEach(option => {
            if (option.getAttribute('data-role') === 'HR Admin') {
                option.style.display = 'block';
            }
        });
    } else if (selectedRole === 'Recruitment Manager') {
        allOptions.forEach(option => {
            if (option.getAttribute('data-role') === 'Recruitment Manager') {
                option.style.display = 'block';
            }
        });
    } else {
        // For Hiring Manager, Technical Lead, Panel - show all available interviewers
        allOptions.forEach(option => {
            option.style.display = 'block';
        });
    }
    
    // Reset the interviewer selection
    interviewerSelect.value = '';
    
    // If only one option is available, auto-select it
    const visibleOptions = Array.from(allOptions).filter(option => 
        option.style.display !== 'none' && option.value !== ''
    );
    
    if (visibleOptions.length === 1) {
        interviewerSelect.value = visibleOptions[0].value;
    }
}

// Sidebar toggle functionality
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});

document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
    if (e.target.textContent.trim() === ">") {
        e.target.textContent = "<";
    } else {
        e.target.textContent = ">";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
