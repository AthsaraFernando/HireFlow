<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Recruitment Manager</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/assigned-jobs" class="nav-link">
                        <span class="nav-text">Assigned Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link">
                        <span class="nav-text">Shortlist</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link active">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/candidate-evaluation" class="nav-link">
                        <span class="nav-text">Evaluations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/notifications" class="nav-link">
                        <span class="nav-text">Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/profile" class="nav-link">
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
                        <span class="user-role">Recruitment Manager</span>
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
        <p class="page-description">Manage your interview calendar and schedule new interviews</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <button class="btn btn-primary" onclick="scheduleNewInterview()">Schedule New Interview</button>
        </div>
    </div>

    <div class="calendar-view">
        <div class="interviews-list">
            <?php foreach($interviews as $interview): ?>
            <div class="interview-card">
                <div class="interview-time">
                    <div class="date"><?= date('M j', strtotime($interview['date'])) ?></div>
                    <div class="time"><?= date('g:i A', strtotime($interview['time'])) ?></div>
                </div>
                <div class="interview-details">
                    <h3><?= htmlspecialchars($interview['candidate_name']) ?></h3>
                    <p><?= htmlspecialchars($interview['job_title']) ?></p>
                    <span class="interview-type"><?= $interview['type'] ?></span>
                    <span class="duration"><?= $interview['duration'] ?> min</span>
                </div>
                <span class="status-badge <?= $interview['status'] ?>"><?= ucfirst($interview['status']) ?></span>
                <div class="interview-actions">
                    <a href="<?= ROOT ?>/recruitment/conduct-interview/<?= $interview['id'] ?>" class="btn btn-primary">Join Interview</a>
                    <button class="btn btn-outline" onclick="rescheduleInterview(<?= $interview['id'] ?>)">Reschedule</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Interview Scheduling Modal - New Design -->
<div class="interview-modal-overlay" id="interview-modal-overlay">
    <div class="interview-modal-container">
        <div class="interview-modal-header">
            <h3 class="interview-modal-title">Schedule New Interview</h3>
            <button class="interview-modal-close" onclick="closeInterviewModal()">&times;</button>
        </div>
        
        <div class="interview-modal-body">
            <form id="interview-schedule-form">
                <div class="interview-form-section">
                    <label class="interview-form-label">Select Candidate</label>
                    <select class="interview-input" id="candidate-select" required>
                        <option value="">Choose a candidate</option>
                        <?php if(!empty($shortlisted_candidates)): ?>
                            <?php foreach($shortlisted_candidates as $candidate): ?>
                                <option value="<?= $candidate['application_id'] ?>" 
                                        data-applicant-id="<?= $candidate['applicant_id'] ?>"
                                        data-job-id="<?= $candidate['job_id'] ?>">
                                    <?= htmlspecialchars($candidate['candidate_name']) ?> - <?= htmlspecialchars($candidate['job_title']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No shortlisted candidates available</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="interview-form-section">
                    <label class="interview-form-label">Interview Date & Time</label>
                    <input type="datetime-local" class="interview-input" id="interview-datetime" required>
                </div>

                <div class="interview-form-section">
                    <label class="interview-form-label">Duration</label>
                    <div class="interview-duration-pills">
                        <div class="interview-duration-pill" data-duration="30">30 min</div>
                        <div class="interview-duration-pill" data-duration="45">45 min</div>
                        <div class="interview-duration-pill" data-duration="60">60 min</div>
                        <div class="interview-duration-pill" data-duration="90">90 min</div>
                    </div>
                    <input type="hidden" id="selected-duration" required>
                </div>
                
                <div class="interview-form-section">
                    <label class="interview-form-label">Interviewer</label>
                    <select class="interview-input" id="interviewer-select">
                        <option value="">Select Interviewer</option>
                        <option value="Tehan Isum">Tehan Isum - Recruit Manager</option>
                        <option value="Chamali Perera">Chamali Perera - Team Lead</option>
                        <option value="Nuwan Silva">Nuwan Silva - HR Manager</option>
                    </select>
                </div>
            </form>
        </div>
        
        <div class="interview-modal-footer">
            <button class="interview-btn interview-btn-cancel" onclick="closeInterviewModal()">Cancel</button>
            <button class="interview-btn interview-btn-schedule" onclick="submitInterviewSchedule()">Schedule Interview</button>
        </div>
    </div>
</div>

<script>
// Global variables
let selectedCandidateId = null;
let isReschedule = false;

function scheduleNewInterview() {
    // Check if there are shortlisted candidates available
    const candidateSelect = document.getElementById('candidate-select');
    const hasOptions = candidateSelect.options.length > 1; // More than just the placeholder
    
    if (!hasOptions) {
        alert('No shortlisted candidates available for scheduling interviews. Please shortlist candidates first.');
        return;
    }
    
    isReschedule = false;
    selectedCandidateId = null;
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.add('active');
    
    // Update title for new interview
    document.querySelector('.interview-modal-title').textContent = 'Schedule New Interview';
    
    // Set minimum datetime to current time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('interview-datetime').min = now.toISOString().slice(0, 16);
    
    // Reset form
    resetInterviewForm();
}

function rescheduleInterview(interviewId) {
    isReschedule = true;
    selectedCandidateId = interviewId;
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.add('active');
    
    // Update title for reschedule
    document.querySelector('.interview-modal-title').textContent = 'Reschedule Interview';
    
    // Set minimum datetime to current time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('interview-datetime').min = now.toISOString().slice(0, 16);
    
    // Reset form
    resetInterviewForm();
    
    // In real implementation, you would load existing interview data here
    alert('Loading existing interview data for rescheduling...');
}

function closeInterviewModal() {
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.remove('active');
    selectedCandidateId = null;
    isReschedule = false;
}

function resetInterviewForm() {
    // Clear all selections
    document.querySelectorAll('.interview-duration-pill.selected').forEach(pill => {
        pill.classList.remove('selected');
    });
    document.getElementById('selected-duration').value = '';
    
    // Clear form fields
    document.getElementById('candidate-select').value = '';
    document.getElementById('interviewer-select').value = '';
    
    // Set default duration (45 min)
    const defaultDuration = document.querySelector('[data-duration="45"]');
    if (defaultDuration) {
        defaultDuration.click();
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const openModal = document.querySelector('.modal.show');
        if (openModal) {
            openModal.classList.remove('show');
        }
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });
});

// Duration selection
document.addEventListener('DOMContentLoaded', function() {
    const durationPills = document.querySelectorAll('.interview-duration-pill');
    const durationInput = document.getElementById('selected-duration');
    
    durationPills.forEach(pill => {
        pill.addEventListener('click', function() {
            durationPills.forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            durationInput.value = this.dataset.duration;
        });
    });
    
    // Set default duration (45 min)
    if (durationPills.length > 1) {
        durationPills[1].click();
    }
});

function submitInterviewSchedule() {
    const candidate = document.getElementById('candidate-select').value;
    const datetime = document.getElementById('interview-datetime').value;
    const duration = document.getElementById('selected-duration').value;
    
    if (!candidate || !datetime || !duration) {
        alert('Please fill in all required fields');
        return;
    }
    
    alert('Interview scheduled successfully!');
    closeInterviewModal();
    location.reload(); // Refresh to show new interview
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
});</script>

<?php $this->view('components/footer') ?>
