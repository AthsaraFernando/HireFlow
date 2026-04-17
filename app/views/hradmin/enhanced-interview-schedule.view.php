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
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
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
                <button class="sidebar-toggle" id="sidebarToggle">≡</button>
                <h1 class="page-title">Interview Calendar</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn">🔔</button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name"><?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">👤</div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Success/Error Messages -->
            <?php if(!empty($success)): ?>
                <div class="alert alert-success">
                    <span>✓</span> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach($errors as $error): ?>
                        <div><span>✗</span> <?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $interviews_today ?? '0' ?></div>
                        <div class="stat-label">Today</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $interviews_week ?? '0' ?></div>
                        <div class="stat-label">This Week</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⏱️</div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $interviews_pending ?? '0' ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-content">
                        <div class="stat-value"><?= $interviews_completed ?? '0' ?></div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
            </div>

            <!-- Calendar Controls -->
            <div class="calendar-controls">
                <div class="calendar-navigation">
                    <button class="nav-btn" onclick="navigateWeek(-1)">←</button>
                    <h2 class="calendar-title" id="calendarTitle"><?= $week_title ?? 'This Week' ?></h2>
                    <button class="nav-btn" onclick="navigateWeek(1)">→</button>
                    <button class="btn btn-secondary" onclick="goToToday()">Today</button>
                </div>
                <div class="calendar-actions">
                    <button class="btn btn-primary" onclick="scheduleNewInterview()">
                        ➕ New Interview
                    </button>
                    <div class="view-toggles">
                        <button class="view-toggle active" data-view="week">Week</button>
                        <button class="view-toggle" data-view="day">Day</button>
                    </div>
                </div>
            </div>

            <!-- Enhanced CSS Grid Calendar -->
            <div class="calendar-container">
                <div class="calendar-grid" id="calendarGrid">
                    <!-- Time column -->
                    <div class="time-column">
                        <div class="time-header"></div>
                        <div class="time-slot">08:00</div>
                        <div class="time-slot">09:00</div>
                        <div class="time-slot">10:00</div>
                        <div class="time-slot">11:00</div>
                        <div class="time-slot">12:00</div>
                        <div class="time-slot">13:00</div>
                        <div class="time-slot">14:00</div>
                        <div class="time-slot">15:00</div>
                        <div class="time-slot">16:00</div>
                        <div class="time-slot">17:00</div>
                        <div class="time-slot">18:00</div>
                    </div>

                    <!-- Day columns -->
                    <?php if (!empty($week_days)): ?>
                        <?php foreach ($week_days as $day): ?>
                            <div class="day-column <?= $day['is_today'] ? 'today' : '' ?>" 
                                 data-date="<?= $day['date'] ?>">
                                <div class="day-header">
                                    <div class="day-name"><?= $day['day_name'] ?></div>
                                    <div class="day-date"><?= $day['day_number'] ?></div>
                                </div>
                                <div class="day-content">
                                    <!-- Interview blocks -->
                                    <?php if (!empty($interviews_by_date[$day['date']])): ?>
                                        <?php foreach ($interviews_by_date[$day['date']] as $interview): ?>
                                            <div class="interview-block" 
                                                 style="top: <?= $interview['top_position'] ?>px; height: <?= $interview['height'] ?>px;"
                                                 onclick="showInterviewDetails(<?= $interview['id'] ?>)"
                                                 data-id="<?= $interview['id'] ?>"
                                                 data-status="<?= $interview['status'] ?>"
                                                 title="<?= htmlspecialchars($interview['candidate_name']) ?> - <?= htmlspecialchars($interview['job_title']) ?>">
                                                <div class="interview-time"><?= $interview['display_time'] ?></div>
                                                <div class="interview-title"><?= htmlspecialchars($interview['job_title']) ?></div>
                                                <div class="interview-candidate"><?= htmlspecialchars($interview['candidate_name']) ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Interview Details Modal -->
    <div class="modal-overlay" id="interviewModal" style="display: none;">
        <div class="interview-modal">
            <div class="modal-header">
                <h3 id="modalTitle">Interview Details</h3>
                <button class="modal-close" onclick="closeInterviewModal()">✕</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be inserted by JavaScript -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="editInterview()">Edit</button>
                <button class="btn btn-danger" onclick="cancelInterview()">Cancel</button>
                <button class="btn btn-primary" onclick="joinInterview()">Join</button>
            </div>
        </div>
    </div>

    <!-- Schedule New Interview Modal -->
    <div class="modal-overlay" id="scheduleModal" style="display: none;">
        <div class="interview-modal">
            <div class="modal-header">
                <h3>Schedule New Interview</h3>
                <button class="modal-close" onclick="closeScheduleModal()">✕</button>
            </div>
            <div class="modal-body">
                <form id="scheduleInterviewForm" method="POST" action="<?= ROOT ?>/hradmin/interview-schedule">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Candidate *</label>
                            <select name="application_id" class="form-select" required>
                                <option value="">Select Candidate</option>
                                <?php if(!empty($available_candidates)): ?>
                                    <?php foreach($available_candidates as $candidate): ?>
                                        <option value="<?= $candidate['application_id'] ?>">
                                            <?= htmlspecialchars($candidate['candidate_name']) ?> - <?= htmlspecialchars($candidate['job_title']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Interview Stage *</label>
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
                            <label>Interviewer Role *</label>
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
                            <label>Interviewer *</label>
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
                            <label>Interview Date *</label>
                            <input type="date" name="scheduled_date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Start Time *</label>
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
                            <label>Interview Type *</label>
                            <select name="interview_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="Phone">Phone Screen</option>
                                <option value="Video">Video Interview</option>
                                <option value="In-Person">In-Person</option>
                                <option value="Technical">Technical Interview</option>
                                <option value="Panel">Panel Interview</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label>Location</label>
                            <input type="text" name="location" class="form-input" placeholder="Conference Room A, Office Building, etc.">
                        </div>
                        <div class="form-group full-width">
                            <label>Meeting Link (Optional)</label>
                            <input type="url" name="meeting_link" class="form-input" placeholder="https://zoom.us/j/123456789">
                        </div>
                        <div class="form-group full-width">
                            <label>Notes</label>
                            <textarea name="notes" class="form-textarea" rows="3" placeholder="Interview agenda, special instructions, etc."></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="Scheduled">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeScheduleModal()">Cancel</button>
                <button class="btn btn-primary" onclick="submitScheduleForm()">Schedule Interview</button>
            </div>
        </div>
    </div>

<style>
/* Enhanced CSS Grid Calendar Styles */
.dashboard-content {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideIn 0.3s ease-out;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert span {
    font-weight: bold;
    font-size: 1.2em;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.stats-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:nth-child(1) {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card:nth-child(2) {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card:nth-child(3) {
    background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);
}

.stat-card:nth-child(4) {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.stat-icon {
    font-size: 2.5rem;
    margin-right: 15px;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.calendar-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.calendar-navigation {
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-btn {
    background: #f8f9fa;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem;
    transition: background 0.3s;
}

.nav-btn:hover {
    background: #e9ecef;
}

.calendar-title {
    margin: 0;
    color: #2c3e50;
    font-weight: 600;
}

.calendar-actions {
    display: flex;
    gap: 15px;
    align-items: center;
}

.view-toggles {
    display: flex;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
}

.view-toggle {
    padding: 8px 16px;
    border: none;
    background: transparent;
    cursor: pointer;
    transition: all 0.3s;
}

.view-toggle.active {
    background: #4e31aa;
    color: white;
}

.calendar-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.calendar-grid {
    display: grid;
    grid-template-columns: 80px repeat(7, 1fr);
    min-height: 600px;
}

.time-column {
    background: #f8f9fa;
    border-right: 2px solid #e9ecef;
}

.time-header {
    height: 60px;
    border-bottom: 2px solid #e9ecef;
}

.time-slot {
    height: 60px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 4px;
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
    border-bottom: 1px solid #e9ecef;
}

.day-column {
    border-right: 1px solid #e9ecef;
    position: relative;
}

.day-column.today {
    background: rgba(78, 49, 170, 0.02);
}

.day-header {
    height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-bottom: 2px solid #e9ecef;
    background: #ffffff;
    position: relative;
    z-index: 2;
}

.day-column.today .day-header {
    background: rgba(78, 49, 170, 0.1);
}

.day-name {
    font-size: 0.8rem;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 1px;
}

.day-date {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
}

.day-column.today .day-date {
    color: #4e31aa;
}

.day-content {
    position: relative;
    height: 660px; /* 11 time slots * 60px */
    min-height: 660px;
    background-image: repeating-linear-gradient(
        to bottom,
        transparent 0px,
        transparent 59px,
        #e9ecef 59px,
        #e9ecef 60px
    );
}

.interview-block {
    position: absolute;
    left: 4px;
    right: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 6px;
    padding: 6px 10px;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    overflow: hidden;
    border-left: 4px solid #4e31aa;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.interview-block:hover {
    transform: translateX(2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    z-index: 10;
}

.interview-block[data-status="Completed"] {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-left-color: #28a745;
}

.interview-block[data-status="Canceled"] {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-left-color: #dc3545;
    opacity: 0.7;
}

.interview-time {
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 0;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.interview-title {
    display: none;
}

.interview-candidate {
    display: none;
}

/* Current time indicator */
.current-time-line {
    position: absolute;
    left: 0;
    right: 0;
    height: 2px;
    background: rgba(255, 107, 53, 0.7);
    z-index: 5;
    pointer-events: none;
}

.current-time-line::before {
    content: '';
    position: absolute;
    left: 0;
    top: -3px;
    width: 8px;
    height: 8px;
    background: #ff6b35;
    border-radius: 50%;
    box-shadow: 0 0 4px rgba(255, 107, 53, 0.5);
}

.interview-block {
    position: absolute;
    left: 4px;
    right: 4px;
    border-radius: 8px;
    padding: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    min-height: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    font-size: 0.75rem;
    color: white;
    font-weight: 500;
}

.interview-block:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    z-index: 10;
}

.interview-block.screening { background: linear-gradient(135deg, #667eea, #764ba2); }
.interview-block.technical { background: linear-gradient(135deg, #f093fb, #f5576c); }
.interview-block.managerial { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.interview-block.hr-review { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.interview-block.final { background: linear-gradient(135deg, #fa709a, #fee140); }

.interview-time {
    font-weight: 600;
    margin-bottom: 2px;
}

.interview-candidate {
    font-weight: 700;
    margin-bottom: 1px;
}

.interview-position {
    opacity: 0.9;
    font-size: 0.65rem;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.interview-modal {
    background: white;
    border-radius: 15px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    transform: scale(0.7);
    transition: transform 0.3s ease;
}

.modal-overlay.show .interview-modal {
    transform: scale(1);
}

.modal-header {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: background 0.3s;
}

.modal-close:hover {
    background: rgba(255,255,255,0.2);
}

.modal-body {
    padding: 25px;
    max-height: 400px;
    overflow-y: auto;
}

.modal-footer {
    display: flex;
    gap: 10px;
    padding: 20px;
    background: #f8f9fa;
    justify-content: flex-end;
}

.interview-detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.detail-group {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.detail-label {
    font-size: 0.8rem;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 5px;
}

.detail-value {
    font-weight: 600;
    color: #2c3e50;
}

/* Button Styles */
.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-outline {
    background: transparent;
    color: #4e31aa;
    border: 2px solid #4e31aa;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .calendar-grid {
        grid-template-columns: 60px repeat(7, 1fr);
    }
    
    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .calendar-controls {
        flex-direction: column;
        gap: 15px;
    }
    
    .interview-block {
        font-size: 0.65rem;
        padding: 4px;
    }
    
    .interview-title,
    .interview-candidate {
        display: none;
    }
    
    .interview-time {
        font-size: 0.65rem;
    }
    
    .day-header {
        height: 50px;
    }
    
    .day-date {
        font-size: 1.1rem;
    }
}

/* Current time indicator */
.current-time-line {
    position: absolute;
    left: 0;
    right: 0;
    height: 2px;
    background: #dc3545;
    z-index: 100;
    box-shadow: 0 0 8px rgba(220, 53, 69, 0.5);
}

.current-time-line::before {
    content: '';
    position: absolute;
    left: -4px;
    top: -3px;
    width: 8px;
    height: 8px;
    background: #dc3545;
    border-radius: 50%;
}

/* Additional styles for enhanced functionality */
.stage-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stage-badge.screening { background: linear-gradient(135deg, #667eea, #764ba2); }
.stage-badge.technical { background: linear-gradient(135deg, #f093fb, #f5576c); }
.stage-badge.managerial { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.stage-badge.hr-review { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.stage-badge.final { background: linear-gradient(135deg, #fa709a, #fee140); }

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-badge.scheduled {
    background: #e3f2fd;
    color: #1565c0;
}

.status-badge.completed {
    background: #e8f5e8;
    color: #2e7d32;
}

.status-badge.cancelled {
    background: #ffebee;
    color: #c62828;
}

.status-badge.pending {
    background: #fff3e0;
    color: #ef6c00;
}

/* Interview Details Modal Styles */
.interview-details {
    max-height: 70vh;
    overflow-y: auto;
}

.detail-section {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.detail-section:last-child {
    border-bottom: none;
}

.detail-section h4 {
    color: #4e31aa;
    font-size: 1rem;
    margin-bottom: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-row {
    display: flex;
    margin-bottom: 12px;
    align-items: flex-start;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    min-width: 140px;
    font-size: 0.9rem;
}

.detail-value {
    color: #2c3e50;
    flex: 1;
    font-size: 0.9rem;
}

.interview-notes {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    color: #495057;
    line-height: 1.6;
    margin: 0;
}

.meeting-link {
    color: #4e31aa;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.meeting-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

/* Form Styles */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: span 2;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.form-input, .form-select, .form-textarea {
    padding: 10px 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #667eea;
}

.form-textarea {
    resize: vertical;
    font-family: inherit;
}

.contact-section, .location-section, .meeting-section, .notes-section {
    margin-top: 25px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.contact-section h4, .location-section h4, .meeting-section h4, .notes-section h4 {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}

.meeting-link {
    display: inline-block;
    padding: 10px 15px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: transform 0.3s ease;
}

.meeting-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.interview-tooltip {
    position: absolute;
    background: #2c3e50;
    color: white;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    z-index: 1001;
    pointer-events: none;
    max-width: 200px;
    line-height: 1.4;
}

.interview-tooltip::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 15px;
    border: 8px solid transparent;
    border-right-color: #2c3e50;
}

/* Loading states */
.calendar-loading {
    position: relative;
}

.calendar-loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    z-index: 100;
}

.calendar-loading::after {
    content: '⏳ Loading interviews...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    z-index: 101;
    font-weight: 600;
    color: #667eea;
}

/* Sidebar collapsed state */
.sidebar.collapsed {
    width: 60px;
}

.sidebar.collapsed .brand-title,
.sidebar.collapsed .brand-subtitle,
.sidebar.collapsed .nav-text {
    display: none;
}

.main-content.expanded {
    margin-left: 60px;
}

/* Animation improvements */
.interview-block {
    animation: slideInUp 0.3s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-overlay.show .interview-modal {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.8) translateY(-50px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Focus styles for accessibility */
.interview-block:focus {
    outline: 3px solid #667eea;
    outline-offset: 2px;
}

.modal-close:focus,
.btn:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .sidebar, .header-right, .calendar-controls, .modal-overlay {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
    }
    
    .calendar-container {
        box-shadow: none;
        border: 1px solid #ccc;
    }
    
    .interview-block {
        box-shadow: none;
        border: 1px solid #333;
        background: #f0f0f0 !important;
        color: #333 !important;
    }
}
</style>

<script>
// Initialize calendar with interview data
<?php if (!empty($calendar_interviews)): ?>
<?php
$js_interviews = [];
foreach ($calendar_interviews as $interview) {
    $js_interviews[] = "{\n        id: {$interview['id']},\n        candidateName: '" . htmlspecialchars($interview['candidate_name'], ENT_QUOTES) . "',\n        candidateEmail: '" . htmlspecialchars($interview['candidate_email'], ENT_QUOTES) . "',\n        candidatePhone: '" . htmlspecialchars($interview['candidate_phone'] ?? '', ENT_QUOTES) . "',\n        jobTitle: '" . htmlspecialchars($interview['job_title'], ENT_QUOTES) . "',\n        department: '" . htmlspecialchars($interview['department_name'] ?? '', ENT_QUOTES) . "',\n        interviewerName: '" . htmlspecialchars($interview['interviewer_name'] ?? 'TBD', ENT_QUOTES) . "',\n        interviewerEmail: '" . htmlspecialchars($interview['interviewer_email'] ?? '', ENT_QUOTES) . "',\n        scheduledDate: '" . $interview['scheduled_date'] . "',\n        scheduledTime: '" . $interview['scheduled_time'] . "',\n        duration: " . ($interview['duration_minutes'] ?? 60) . ",\n        interviewType: '" . htmlspecialchars($interview['interview_type'], ENT_QUOTES) . "',\n        interviewStage: '" . htmlspecialchars($interview['interview_stage'] ?? 'Screening', ENT_QUOTES) . "',\n        location: '" . htmlspecialchars($interview['location'] ?? '', ENT_QUOTES) . "',\n        meetingLink: '" . htmlspecialchars($interview['meeting_link'] ?? '', ENT_QUOTES) . "',\n        status: '" . htmlspecialchars($interview['status'], ENT_QUOTES) . "',\n        notes: '" . htmlspecialchars($interview['notes'] ?? '', ENT_QUOTES) . "'\n    }";
}
?>
window.interviewsData = [
    <?= implode(",\n", $js_interviews) ?>
];
<?php else: ?>
window.interviewsData = [];
<?php endif; ?>

window.currentWeekStart = '<?= $current_week_start ?? date('Y-m-d') ?>';
window.ROOT = '<?= ROOT ?>';

// Show current time indicator (optional - can be enabled if needed)
function showCurrentTimeLine() {
    // Disabled to avoid visual clutter
    // Uncomment below to enable current time indicator
    /*
    const now = new Date();
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();
    
    // Only show if current time is within business hours (8 AM - 6 PM)
    if (currentHour >= 8 && currentHour < 19) {
        const topPosition = ((currentHour - 8) * 60) + currentMinute;
        
        // Find today's column
        const todayColumn = document.querySelector('.day-column.today .day-content');
        if (todayColumn) {
            // Remove existing time line if any
            const existingLine = todayColumn.querySelector('.current-time-line');
            if (existingLine) {
                existingLine.remove();
            }
            
            // Create and add new time line
            const timeLine = document.createElement('div');
            timeLine.className = 'current-time-line';
            timeLine.style.top = topPosition + 'px';
            todayColumn.appendChild(timeLine);
        }
    }
    */
}

// Disabled - uncomment to enable
// showCurrentTimeLine();
// setInterval(showCurrentTimeLine, 60000);

// Modal functions
function scheduleNewInterview() {
    const modal = document.getElementById('scheduleModal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function closeScheduleModal() {
    const modal = document.getElementById('scheduleModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.getElementById('scheduleInterviewForm').reset();
    }, 300);
}

// Show interview details in modal
function showInterviewDetails(interviewId) {
    const interview = window.interviewsData.find(i => i.id === interviewId);
    if (!interview) {
        console.error('Interview not found:', interviewId);
        return;
    }
    
    const modal = document.getElementById('interviewModal');
    const modalBody = document.getElementById('modalBody');
    const modalTitle = document.getElementById('modalTitle');
    
    // Set modal title
    modalTitle.textContent = `Interview Details - ${interview.jobTitle}`;
    
    // Build modal content
    const timeStr = new Date('2000-01-01 ' + interview.scheduledTime).toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit' 
    });
    
    modalBody.innerHTML = `
        <div class="interview-details">
            <div class="detail-section">
                <h4>Candidate Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">${interview.candidateName}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">${interview.candidateEmail}</span>
                </div>
                ${interview.candidatePhone ? `
                    <div class="detail-row">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value">${interview.candidatePhone}</span>
                    </div>
                ` : ''}
            </div>
            
            <div class="detail-section">
                <h4>Position Details</h4>
                <div class="detail-row">
                    <span class="detail-label">Job Title:</span>
                    <span class="detail-value">${interview.jobTitle}</span>
                </div>
                ${interview.department ? `
                    <div class="detail-row">
                        <span class="detail-label">Department:</span>
                        <span class="detail-value">${interview.department}</span>
                    </div>
                ` : ''}
            </div>
            
            <div class="detail-section">
                <h4>Interview Schedule</h4>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">${new Date(interview.scheduledDate).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">${timeStr}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value">${interview.duration} minutes</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Type:</span>
                    <span class="detail-value">${interview.interviewType}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stage:</span>
                    <span class="detail-value">${interview.interviewStage}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value"><span class="status-badge status-${interview.status.toLowerCase()}">${interview.status}</span></span>
                </div>
            </div>
            
            <div class="detail-section">
                <h4>Interviewer</h4>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">${interview.interviewerName}</span>
                </div>
                ${interview.interviewerEmail ? `
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">${interview.interviewerEmail}</span>
                    </div>
                ` : ''}
            </div>
            
            <div class="detail-section">
                <h4>Location</h4>
                ${interview.location ? `
                    <div class="detail-row">
                        <span class="detail-label">Location:</span>
                        <span class="detail-value">${interview.location}</span>
                    </div>
                ` : ''}
                ${interview.meetingLink ? `
                    <div class="detail-row">
                        <span class="detail-label">Meeting Link:</span>
                        <span class="detail-value"><a href="${interview.meetingLink}" target="_blank" class="meeting-link">Join Meeting →</a></span>
                    </div>
                ` : ''}
            </div>
            
            ${interview.notes ? `
                <div class="detail-section">
                    <h4>Notes</h4>
                    <p class="interview-notes">${interview.notes}</p>
                </div>
            ` : ''}
        </div>
    `;
    
    // Store current interview ID for edit/cancel actions
    modal.dataset.interviewId = interviewId;
    
    // Show modal
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function submitScheduleForm() {
    const form = document.getElementById('scheduleInterviewForm');
    if (form.checkValidity()) {
        form.submit();
    } else {
        form.reportValidity();
    }
}

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
}

function closeInterviewModal() {
    const modal = document.getElementById('interviewModal');
    modal.classList.remove('show');
    setTimeout(() => modal.style.display = 'none', 300);
}

// Modal action functions
function editInterview() {
    const modal = document.getElementById('interviewModal');
    const interviewId = modal.dataset.interviewId;
    if (interviewId) {
        window.location.href = `${window.ROOT}/hradmin/edit-interview/${interviewId}`;
    }
}

function cancelInterview() {
    const modal = document.getElementById('interviewModal');
    const interviewId = modal.dataset.interviewId;
    
    if (interviewId && confirm('Are you sure you want to cancel this interview?')) {
        // Submit cancellation request
        fetch(`${window.ROOT}/hradmin/cancel-interview/${interviewId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Interview cancelled successfully');
                location.reload();
            } else {
                alert('Failed to cancel interview: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while cancelling the interview');
        });
    }
}

function joinInterview() {
    const modal = document.getElementById('interviewModal');
    const interviewId = modal.dataset.interviewId;
    const interview = window.interviewsData.find(i => i.id == interviewId);
    
    if (interview && interview.meetingLink) {
        window.open(interview.meetingLink, '_blank');
    } else {
        alert('No meeting link available for this interview');
    }
}

// Week navigation functions
function navigateWeek(direction) {
    const currentStart = new Date(window.currentWeekStart);
    currentStart.setDate(currentStart.getDate() + (direction * 7));
    
    const year = currentStart.getFullYear();
    const month = String(currentStart.getMonth() + 1).padStart(2, '0');
    const day = String(currentStart.getDate()).padStart(2, '0');
    const newWeekStart = `${year}-${month}-${day}`;
    
    window.location.href = `${window.ROOT}/hradmin/interview-schedule?week_start=${newWeekStart}`;
}

function goToToday() {
    window.location.href = `${window.ROOT}/hradmin/interview-schedule`;
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeScheduleModal();
        closeInterviewModal();
    }
});

// Keyboard accessibility
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeScheduleModal();
        closeInterviewModal();
    }
});
</script>

<!-- Include enhanced interview calendar JavaScript -->
<script src="<?= ROOT ?>/public/assets/js/interview-calendar.js"></script>

</body>
<?php $this->view('components/footer') ?>