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
                                    <!-- Interview slots will be inserted here by JavaScript -->
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

<style>
/* Enhanced CSS Grid Calendar Styles */
.dashboard-content {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
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
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
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
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
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
    height: 550px;
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
window.interviewsData = [
    <?php foreach ($calendar_interviews as $interview): ?>
    {
        id: <?= $interview['id'] ?>,
        candidateName: '<?= htmlspecialchars($interview['candidate_name'], ENT_QUOTES) ?>',
        candidateEmail: '<?= htmlspecialchars($interview['candidate_email'], ENT_QUOTES) ?>',
        candidatePhone: '<?= htmlspecialchars($interview['candidate_phone'] ?? '', ENT_QUOTES) ?>',
        jobTitle: '<?= htmlspecialchars($interview['job_title'], ENT_QUOTES) ?>',
        department: '<?= htmlspecialchars($interview['department_name'] ?? '', ENT_QUOTES) ?>',
        interviewerName: '<?= htmlspecialchars($interview['interviewer_name'] ?? 'TBD', ENT_QUOTES) ?>',
        interviewerEmail: '<?= htmlspecialchars($interview['interviewer_email'] ?? '', ENT_QUOTES) ?>',
        scheduledDate: '<?= $interview['scheduled_date'] ?>',
        scheduledTime: '<?= $interview['scheduled_time'] ?>',
        duration: <?= $interview['duration_minutes'] ?? 60 ?>,
        interviewType: '<?= htmlspecialchars($interview['interview_type'], ENT_QUOTES) ?>',
        interviewStage: '<?= htmlspecialchars($interview['interview_stage'] ?? 'Screening', ENT_QUOTES) ?>',
        location: '<?= htmlspecialchars($interview['location'] ?? '', ENT_QUOTES) ?>',
        meetingLink: '<?= htmlspecialchars($interview['meeting_link'] ?? '', ENT_QUOTES) ?>',
        status: '<?= htmlspecialchars($interview['status'], ENT_QUOTES) ?>',
        notes: '<?= htmlspecialchars($interview['notes'] ?? '', ENT_QUOTES) ?>'
    },
    <?php endforeach; ?>
];
<?php else: ?>
window.interviewsData = [];
<?php endif; ?>

window.currentWeekStart = '<?= $current_week_start ?? date('Y-m-d') ?>';
window.ROOT = '<?= ROOT ?>';
</script>

<!-- Include enhanced interview calendar JavaScript -->
<script src="<?= ROOT ?>/public/assets/js/interview-calendar.js"></script>

</body>
<?php $this->view('components/footer') ?>