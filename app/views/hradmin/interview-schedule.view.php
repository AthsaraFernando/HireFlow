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
    <div class="header-section">
        <h1 class="page-title">Interview Schedule</h1>
        <p class="page-description">Schedule and manage interviews with candidates</p>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="scheduleNewInterview()">
                Schedule Interview
            </button>
            <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="btn btn-secondary">
                View Applications
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
                <h3 class="calendar-title">January 15-21, 2024</h3>
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
            
            <!-- Monday -->
            <div class="day-column">
                <div class="day-header">
                    <div class="day-name">Mon</div>
                    <div class="day-date">15</div>
                </div>
                <div class="day-slots">
                    <div class="interview-block" style="top: 120px; height: 60px;">
                        <div class="interview-info">
                            <div class="interview-time">10:00 AM</div>
                            <div class="interview-candidate">John Smith</div>
                            <div class="interview-position">Senior Developer</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tuesday -->
            <div class="day-column">
                <div class="day-header">
                    <div class="day-name">Tue</div>
                    <div class="day-date">16</div>
                </div>
                <div class="day-slots">
                    <div class="interview-block" style="top: 180px; height: 60px;">
                        <div class="interview-info">
                            <div class="interview-time">2:00 PM</div>
                            <div class="interview-candidate">Sarah Johnson</div>
                            <div class="interview-position">UI/UX Designer</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Wednesday -->
            <div class="day-column">
                <div class="day-header">
                    <div class="day-name">Wed</div>
                    <div class="day-date">17</div>
                </div>
                <div class="day-slots">
                    <div class="interview-block" style="top: 90px; height: 60px;">
                        <div class="interview-info">
                            <div class="interview-time">11:00 AM</div>
                            <div class="interview-candidate">Mike Wilson</div>
                            <div class="interview-position">Project Manager</div>
                        </div>
                    </div>
                    <div class="interview-block" style="top: 240px; height: 60px;">
                        <div class="interview-info">
                            <div class="interview-time">3:00 PM</div>
                            <div class="interview-candidate">Emily Chen</div>
                            <div class="interview-position">Marketing Manager</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thursday -->
            <div class="day-column">
                <div class="day-header">
                    <div class="day-name">Thu</div>
                    <div class="day-date">18</div>
                </div>
                <div class="day-slots"></div>
            </div>
            
            <!-- Friday -->
            <div class="day-column">
                <div class="day-header">
                    <div class="day-name">Fri</div>
                    <div class="day-date">19</div>
                </div>
                <div class="day-slots">
                    <div class="interview-block" style="top: 150px; height: 60px;">
                        <div class="interview-info">
                            <div class="interview-time">1:00 PM</div>
                            <div class="interview-candidate">David Brown</div>
                            <div class="interview-position">Data Analyst</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List View (Hidden by default) -->
        <div id="listView" class="interview-list" style="display: none;">
            <div class="interview-card">
                <div class="interview-header">
                    <div class="interview-datetime">
                        <div class="interview-date">January 15, 2024</div>
                        <div class="interview-time">10:00 AM - 11:00 AM</div>
                    </div>
                    <div class="interview-status">
                        <span class="status-badge upcoming">Upcoming</span>
                    </div>
                </div>
                <div class="interview-details">
                    <div class="candidate-section">
                        <h4>John Smith</h4>
                        <p>Applying for: Senior Software Developer</p>
                        <p>Email: john.smith@email.com</p>
                        <p>Phone: +1 (555) 123-4567</p>
                    </div>
                    <div class="interview-meta">
                        <div class="interviewer">
                            <strong>Interviewer:</strong> Sarah Johnson
                        </div>
                        <div class="location">
                            <strong>Location:</strong> Conference Room A / Zoom
                        </div>
                        <div class="type">
                            <strong>Type:</strong> Technical Interview
                        </div>
                    </div>
                </div>
                <div class="interview-actions">
                    <button class="btn btn-outline btn-sm" onclick="editInterview(1)">Edit</button>
                    <button class="btn btn-primary btn-sm" onclick="joinInterview(1)">Join</button>
                    <button class="btn btn-secondary btn-sm" onclick="reschedule(1)">Reschedule</button>
                    <button class="btn btn-danger btn-sm" onclick="cancelInterview(1)">Cancel</button>
                </div>
            </div>

            <div class="interview-card">
                <div class="interview-header">
                    <div class="interview-datetime">
                        <div class="interview-date">January 16, 2024</div>
                        <div class="interview-time">2:00 PM - 3:00 PM</div>
                    </div>
                    <div class="interview-status">
                        <span class="status-badge upcoming">Upcoming</span>
                    </div>
                </div>
                <div class="interview-details">
                    <div class="candidate-section">
                        <h4>Sarah Johnson</h4>
                        <p>Applying for: UI/UX Designer</p>
                        <p>Email: sarah.johnson@email.com</p>
                        <p>Phone: +1 (555) 234-5678</p>
                    </div>
                    <div class="interview-meta">
                        <div class="interviewer">
                            <strong>Interviewer:</strong> Mike Wilson
                        </div>
                        <div class="location">
                            <strong>Location:</strong> Design Studio / Zoom
                        </div>
                        <div class="type">
                            <strong>Type:</strong> Portfolio Review
                        </div>
                    </div>
                </div>
                <div class="interview-actions">
                    <button class="btn btn-outline btn-sm" onclick="editInterview(2)">Edit</button>
                    <button class="btn btn-primary btn-sm" onclick="joinInterview(2)">Join</button>
                    <button class="btn btn-secondary btn-sm" onclick="reschedule(2)">Reschedule</button>
                    <button class="btn btn-danger btn-sm" onclick="cancelInterview(2)">Cancel</button>
                </div>
            </div>
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
            <form class="schedule-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Candidate</label>
                        <select class="form-select" required>
                            <option value="">Select Candidate</option>
                            <option value="1">John Smith - Senior Software Developer</option>
                            <option value="2">Sarah Johnson - UI/UX Designer</option>
                            <option value="3">Mike Wilson - Project Manager</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interviewer</label>
                        <select class="form-select" required>
                            <option value="">Select Interviewer</option>
                            <option value="1">Sarah Johnson - Engineering Manager</option>
                            <option value="2">Mike Wilson - Design Lead</option>
                            <option value="3">Emily Chen - HR Manager</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interview Date</label>
                        <input type="date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Duration (minutes)</label>
                        <select class="form-select">
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60" selected>1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Interview Type</label>
                        <select class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="phone">Phone Screen</option>
                            <option value="video">Video Interview</option>
                            <option value="in-person">In-Person</option>
                            <option value="technical">Technical Interview</option>
                            <option value="panel">Panel Interview</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location / Meeting Link</label>
                        <input type="text" class="form-input" placeholder="Conference Room A or Zoom link">
                    </div>
                    <div class="form-group full-width">
                        <label>Notes</label>
                        <textarea class="form-textarea" rows="3" placeholder="Interview agenda, special instructions, etc."></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeScheduleModal()">Cancel</button>
            <button class="btn btn-primary" onclick="saveInterview()">Schedule Interview</button>
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
    border-radius: 4px;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.2s;
}

.interview-block:hover {
    background: #3d2688;
    transform: scale(1.02);
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
    font-weight: 500;
}

.interview-position {
    font-size: 0.75rem;
    opacity: 0.9;
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
    alert('Loading previous week...');
    // Implement week navigation
}

function nextWeek() {
    alert('Loading next week...');
    // Implement week navigation
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
