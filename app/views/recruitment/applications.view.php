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
                    <a href="<?= ROOT ?>/recruitment/applications" class="nav-link active">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link">
                        <span class="nav-text">Shortlist</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link">
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
                <h1 class="page-title">Review Applications</h1>
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
    <!-- Header Section -->
    <div class="header-section">
        <h1 class="page-title">Review Applications</h1>
        <p class="page-description">Evaluate and manage candidate applications</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Dashboard
            </a>
            <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="btn btn-primary">
                <i class="icon-users"></i>View Shortlist
            </a>
            <a href="<?= ROOT ?>/recruitment/assigned-jobs" class="btn btn-outline">
                <i class="icon-jobs"></i>My Jobs
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

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-container">
            <div class="filter-group">
                <label for="job-filter">Job Position:</label>
                <select id="job-filter" class="filter-select">
                    <?php foreach($jobs as $job): ?>
                        <option value="<?= $job['id'] ?>" <?= $selected_job == $job['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($job['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="status-filter">Status:</label>
                <select id="status-filter" class="filter-select">
                    <?php foreach($statuses as $status): ?>
                        <option value="<?= strtolower(str_replace(' ', '_', $status)) ?>"><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="score-filter">Min Match Score:</label>
                <select id="score-filter" class="filter-select">
                    <option value="0">All Scores</option>
                    <option value="90">90%+</option>
                    <option value="80">80%+</option>
                    <option value="70">70%+</option>
                    <option value="60">60%+</option>
                </select>
            </div>
            <div class="filter-group">
                <input type="text" id="search-applications" placeholder="Search candidates..." class="search-input">
            </div>
            <button class="btn btn-outline" onclick="clearFilters()">Clear Filters</button>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-card">
            <div class="summary-value"><?= count($applications) ?></div>
            <div class="summary-label">Total Applications</div>
        </div>
        <div class="summary-card pending">
            <div class="summary-value"><?= count(array_filter($applications, fn($app) => $app['status'] === 'pending')) ?></div>
            <div class="summary-label">Pending Review</div>
        </div>
        <div class="summary-card warning">
            <div class="summary-value"><?= count(array_filter($applications, fn($app) => $app['status'] === 'under_review')) ?></div>
            <div class="summary-label">Under Review</div>
        </div>
        <div class="summary-card success">
            <div class="summary-value"><?= count(array_filter($applications, fn($app) => $app['status'] === 'shortlisted')) ?></div>
            <div class="summary-label">Shortlisted</div>
        </div>
    </div>

    <!-- Applications List -->
    <div class="applications-container">
        <?php foreach($applications as $application): ?>
        <div class="application-card" 
             data-status="<?= str_replace(' ', '_', $application['status']) ?>" 
             data-score="<?= $application['match_score'] ?>"
             data-job="<?= $application['job_id'] ?>">
            
            <div class="application-header">
                <div class="candidate-info">
                    <div class="candidate-avatar"><?= strtoupper(substr($application['candidate_name'], 0, 2)) ?></div>
                    <div class="candidate-details">
                        <h3 class="candidate-name"><?= htmlspecialchars($application['candidate_name']) ?></h3>
                        <p class="candidate-position">Applied for: <?= htmlspecialchars($application['job_title']) ?></p>
                        <div class="candidate-contact">
                            <span class="contact-item"><?= htmlspecialchars($application['email']) ?></span>
                            <span class="contact-item"><?= htmlspecialchars($application['phone']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="application-meta">
                    <div class="match-score">
                        <div class="score-circle <?= $application['match_score'] >= 90 ? 'excellent' : ($application['match_score'] >= 80 ? 'good' : 'average') ?>">
                            <?= $application['match_score'] ?>%
                        </div>
                        <span class="score-label">Match</span>
                    </div>
                    <div class="application-date">
                        Applied: <?= date('M j, Y', strtotime($application['application_date'])) ?>
                    </div>
                    <span class="status-badge <?= str_replace(' ', '-', $application['status']) ?>">
                        <?= ucwords(str_replace('_', ' ', $application['status'])) ?>
                    </span>
                </div>
            </div>

            <div class="application-content">
                <div class="content-section">
                    <h4>Experience & Background</h4>
                    <div class="experience-grid">
                        <div class="exp-item">
                            <strong>Experience:</strong> <?= $application['experience_years'] ?> years
                        </div>
                        <div class="exp-item">
                            <strong>Current Company:</strong> <?= htmlspecialchars($application['current_company']) ?>
                        </div>
                        <div class="exp-item">
                            <strong>Location:</strong> <?= htmlspecialchars($application['location']) ?>
                        </div>
                        <div class="exp-item">
                            <strong>Education:</strong> <?= htmlspecialchars($application['education']) ?>
                        </div>
                    </div>
                </div>

                <div class="content-section">
                    <h4>Skills</h4>
                    <div class="skills-container">
                        <?php foreach($application['skills'] as $skill): ?>
                            <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="content-section">
                    <h4>Cover Letter Preview</h4>
                    <p class="cover-letter-preview"><?= htmlspecialchars(substr($application['cover_letter'], 0, 200)) ?>...</p>
                </div>
            </div>

            <div class="application-actions">
                <div class="action-group primary-actions">
                    <button class="btn btn-success" onclick="shortlistCandidate(<?= $application['id'] ?>)">
                        <i class="icon-check"></i>Shortlist
                    </button>
                    <button class="btn btn-warning" onclick="scheduleInterview(<?= $application['id'] ?>)">
                        <i class="icon-calendar"></i>Schedule Interview
                    </button>
                    <a href="<?= ROOT ?>/recruitment/applications/view/<?= $application['id'] ?>" class="btn btn-outline">
                        <i class="icon-eye"></i>View Full Application
                    </a>
                </div>
                
                <div class="action-group secondary-actions">
                    <a href="<?= $application['resume_url'] ?>" target="_blank" class="btn btn-secondary">
                        <i class="icon-download"></i>Download Resume
                    </a>
                    <button class="btn btn-danger" onclick="rejectApplication(<?= $application['id'] ?>)">
                        <i class="icon-close"></i>Reject
                    </button>
                </div>
            </div>

            <div class="application-notes">
                <h5>Recruiter Notes</h5>
                <textarea class="notes-input" placeholder="Add your evaluation notes..." rows="2"></textarea>
                <button class="btn btn-sm btn-outline" onclick="saveNotes(<?= $application['id'] ?>)">Save Notes</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="empty-state" style="display: none;">
        <div class="empty-icon">📄</div>
        <h3>No applications found</h3>
        <p>No applications match your current filters. Try adjusting your search criteria.</p>
        <button class="btn btn-outline" onclick="clearFilters()">Clear Filters</button>
    </div>
</div>

<!-- Action Modals -->
<div class="interview-modal-overlay" id="interview-modal-overlay">
    <div class="interview-modal-container">
        <div class="interview-modal-header">
            <h3 class="interview-modal-title">Schedule Interview</h3>
            <button class="interview-modal-close" onclick="closeInterviewModal()">&times;</button>
        </div>
        
        <div class="interview-modal-body">
            <form id="interview-schedule-form">
                <div class="interview-form-section">
                    <label class="interview-form-label">Interview Date & Time</label>
                    <input type="datetime-local" class="interview-input" id="interview-datetime" required>
                </div>
                
                <div class="interview-form-section">
                    <label class="interview-form-label">Interview Type</label>
                    <div class="interview-type-grid">
                        <div class="interview-type-card" data-type="phone">
                            <span class="interview-type-icon">📞</span>
                            <div class="interview-type-label">Phone</div>
                        </div>
                        <div class="interview-type-card" data-type="video">
                            <span class="interview-type-icon">💻</span>
                            <div class="interview-type-label">Video</div>
                        </div>
                        <div class="interview-type-card" data-type="person">
                            <span class="interview-type-icon">🏢</span>
                            <div class="interview-type-label">In-Person</div>
                        </div>
                        <div class="interview-type-card" data-type="technical">
                            <span class="interview-type-icon">⚡</span>
                            <div class="interview-type-label">Technical</div>
                        </div>
                    </div>
                    <input type="hidden" id="selected-interview-type" required>
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
                        <option value="john-doe">John Doe - Senior Developer</option>
                        <option value="jane-smith">Jane Smith - Team Lead</option>
                        <option value="mike-wilson">Mike Wilson - HR Manager</option>
                    </select>
                </div>
                
                <div class="interview-form-section">
                    <label class="interview-form-label">Notes (Optional)</label>
                    <textarea class="interview-input" rows="3" placeholder="Additional notes or special requirements..."></textarea>
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
// Filter functionality
function filterApplications() {
    const jobFilter = document.getElementById('job-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    const scoreFilter = parseInt(document.getElementById('score-filter').value);
    const searchTerm = document.getElementById('search-applications').value.toLowerCase();
    
    const applicationCards = document.querySelectorAll('.application-card');
    let visibleCount = 0;
    
    applicationCards.forEach(card => {
        const status = card.dataset.status;
        const score = parseInt(card.dataset.score);
        const job = card.dataset.job;
        const name = card.querySelector('.candidate-name').textContent.toLowerCase();
        
        const matchesJob = jobFilter === 'all' || job == jobFilter;
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        const matchesScore = score >= scoreFilter;
        const matchesSearch = searchTerm === '' || name.includes(searchTerm);
        
        if (matchesJob && matchesStatus && matchesScore && matchesSearch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    const emptyState = document.getElementById('empty-state');
    if (visibleCount === 0) {
        emptyState.style.display = 'block';
    } else {
        emptyState.style.display = 'none';
    }
}

function clearFilters() {
    document.getElementById('job-filter').value = 'all';
    document.getElementById('status-filter').value = 'all';
    document.getElementById('score-filter').value = '0';
    document.getElementById('search-applications').value = '';
    filterApplications();
}

// Action functions
function shortlistCandidate(applicationId) {
    if (confirm('Add this candidate to the shortlist?')) {
        // AJAX call to shortlist candidate
        alert('Candidate added to shortlist successfully!');
        // Update UI
        location.reload();
    }
}

function rejectApplication(applicationId) {
    if (confirm('Are you sure you want to reject this application?')) {
        // AJAX call to reject application
        alert('Application rejected successfully!');
        // Update UI
        location.reload();
    }
}

function scheduleInterview(applicationId) {
    selectedCandidateId = applicationId;
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.add('active');
    
    // Set minimum datetime to current time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('interview-datetime').min = now.toISOString().slice(0, 16);
    
    // Reset form
    resetInterviewForm();
}

// Global variables
let selectedCandidateId = null;

function closeInterviewModal() {
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.remove('active');
    selectedCandidateId = null;
}

function resetInterviewForm() {
    // Clear all selections
    document.querySelectorAll('.interview-type-card.selected').forEach(card => {
        card.classList.remove('selected');
    });
    document.querySelectorAll('.interview-duration-pill.selected').forEach(pill => {
        pill.classList.remove('selected');
    });
    document.getElementById('selected-interview-type').value = '';
    document.getElementById('selected-duration').value = '';
    
    // Set default duration (45 min)
    const defaultDuration = document.querySelector('[data-duration="45"]');
    if (defaultDuration) {
        defaultDuration.click();
    }
}

// Event listeners for interview scheduling
document.addEventListener('DOMContentLoaded', function() {
    // Interview type selection
    document.querySelectorAll('.interview-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.interview-type-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('selected-interview-type').value = this.dataset.type;
        });
    });
    
    // Duration selection
    document.querySelectorAll('.interview-duration-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.interview-duration-pill').forEach(p => p.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('selected-duration').value = this.dataset.duration;
        });
    });
});

// Close modal when clicking outside
document.getElementById('interview-modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInterviewModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const overlay = document.getElementById('interview-modal-overlay');
        if (overlay.classList.contains('active')) {
            closeInterviewModal();
        }
    }
});

function submitInterviewSchedule() {
    const datetime = document.getElementById('interview-datetime').value;
    const type = document.getElementById('selected-interview-type').value;
    const duration = document.getElementById('selected-duration').value;
    const interviewer = document.getElementById('interviewer-select').value;
    
    if (!datetime || !type || !duration) {
        alert('Please fill in all required fields');
        return;
    }
    
    // In real implementation, send data to server
    console.log('Scheduling interview for candidate:', selectedCandidateId, {
        datetime, type, duration, interviewer
    });
    
    alert('Interview scheduled successfully!');
    closeInterviewModal();
}

function saveNotes(applicationId) {
    const textarea = event.target.previousElementSibling;
    const notes = textarea.value;
    
    if (notes.trim()) {
        // AJAX call to save notes
        alert('Notes saved successfully!');
        textarea.style.borderColor = '#10b981';
        setTimeout(() => {
            textarea.style.borderColor = '';
        }, 2000);
    }
}

// Add event listeners
document.getElementById('job-filter').addEventListener('change', filterApplications);
document.getElementById('status-filter').addEventListener('change', filterApplications);
document.getElementById('score-filter').addEventListener('change', filterApplications);
document.getElementById('search-applications').addEventListener('input', filterApplications);

// Job filter change should update URL
document.getElementById('job-filter').addEventListener('change', function() {
    const jobId = this.value;
    if (jobId === 'all') {
        window.location.href = '<?= ROOT ?>/recruitment/applications';
    } else {
        window.location.href = '<?= ROOT ?>/recruitment/applications?job=' + jobId;
    }
});

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
