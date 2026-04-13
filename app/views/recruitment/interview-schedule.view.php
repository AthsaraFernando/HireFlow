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
                    <a href="<?= ROOT ?>/recruitment/applicationforms" class="nav-link">
                        <span class="nav-text">Application Forms</span>
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
            <?php if(!empty($interviews)): ?>
                <?php foreach($interviews as $interview): ?>
                <div class="interview-card">
                    <div class="interview-time">
                        <div class="date"><?= date('M j', strtotime($interview['scheduled_date'])) ?></div>
                        <div class="time"><?= date('g:i A', strtotime($interview['scheduled_time'])) ?></div>
                    </div>
                    <div class="interview-details">
                        <h3><?= htmlspecialchars($interview['candidate_name']) ?></h3>
                        <p><?= htmlspecialchars($interview['job_title']) ?></p>
                        <span class="interview-type"><?= htmlspecialchars($interview['interview_type']) ?></span>
                        <span class="duration"><?= htmlspecialchars($interview['duration_minutes']) ?> min</span>
                        <?php if(!empty($interview['interviewer_name'])): ?>
                            <p class="interviewer-info">
                                <strong>Interviewer:</strong> <?= htmlspecialchars($interview['interviewer_name']) ?>
                                <?php if(!empty($interview['interviewer_role'])): ?>
                                    (<?= htmlspecialchars($interview['interviewer_role']) ?>)
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <span class="status-badge <?= strtolower($interview['status']) ?>"><?= ucfirst($interview['status']) ?></span>
                    <div class="interview-actions">
                        <?php if (strtolower($interview['status']) !== 'completed'): ?>
                            <a href="<?= ROOT ?>/recruitment/conduct-interview/<?= $interview['id'] ?>" class="btn btn-primary">Join Interview</a>
                            <button class="btn btn-outline" onclick="rescheduleInterview(<?= $interview['id'] ?>)">Reschedule</button>
                        <?php endif; ?>
                        <button class="btn btn-danger" onclick="deleteInterview(<?= $interview['id'] ?>)">Delete</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No interviews scheduled yet. Click "Schedule New Interview" to get started.</p>
                </div>
            <?php endif; ?>
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
                    <select class="interview-input" id="interviewer-select" required>
                        <option value="">Select Interviewer</option>
                        <?php if(!empty($interviewers)): ?>
                            <?php foreach($interviewers as $interviewer): ?>
                                <option value="<?= $interviewer['id'] ?>">
                                    <?= htmlspecialchars($interviewer['full_name']) ?> - <?= $interviewer['role_id'] == 2 ? 'HR Admin' : 'Recruitment Manager' ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="interview-form-section">
                    <label class="interview-form-label">Interview Type</label>
                    <select class="interview-input" id="interview-type-select" required>
                        <option value="Video">Video Interview</option>
                        <option value="Phone">Phone Interview</option>
                        <option value="In-person">In person Interview</option>
                        <option value="Panel">Panel Interview</option>
                    </select>
                </div>

                <div class="interview-form-section">
                    <label class="interview-form-label">Location / Meeting Link</label>
                    <input type="text" class="interview-input" id="interview-location" placeholder="Conference Room or Zoom Link">
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
let selectedInterviewId = null;
let isReschedule = false;

function scheduleNewInterview() {
    // Check if there are shortlisted candidates available
    const candidateSelect = document.getElementById('candidate-select');
    const hasOptions = candidateSelect.options.length > 1; // More than just the placeholder
    
    if (!hasOptions) {
        alert('No shortlisted candidates available for scheduling interviews. All shortlisted candidates may already have interviews scheduled, or no candidates have been shortlisted yet.');
        return;
    }
    
    isReschedule = false;
    selectedInterviewId = null;
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
    selectedInterviewId = interviewId;
    
    // Update title for reschedule
    document.querySelector('.interview-modal-title').textContent = 'Reschedule Interview';
    
    // Set minimum datetime to current time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('interview-datetime').min = now.toISOString().slice(0, 16);
    
    // Fetch and populate interview data BEFORE showing modal
    fetch('<?= ROOT ?>/recruitment/interview-schedule/get/' + interviewId)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const data = result.data;
                
                console.log('Loading interview data for reschedule:', data);
                
                // Populate form fields
                document.getElementById('candidate-select').value = data.application_id;
                document.getElementById('candidate-select').disabled = true; // Can't change candidate
                
                // Combine date and time for datetime-local input
                const datetime = data.scheduled_date + 'T' + data.scheduled_time.substring(0, 5);
                document.getElementById('interview-datetime').value = datetime;
                
                // Set duration
                const durationPill = document.querySelector(`[data-duration="${data.duration_minutes}"]`);
                if (durationPill) {
                    document.querySelectorAll('.interview-duration-pill').forEach(p => p.classList.remove('selected'));
                    durationPill.classList.add('selected');
                    document.getElementById('selected-duration').value = data.duration_minutes;
                } else {
                    // If no matching pill, set the value directly
                    document.getElementById('selected-duration').value = data.duration_minutes;
                }
                
                // Set interviewer
                document.getElementById('interviewer-select').value = data.interviewer_id;
                
                // Set interview type
                document.getElementById('interview-type-select').value = data.interview_type;
                
                // Set location
                document.getElementById('interview-location').value = data.location || data.meeting_link || '';
                
                console.log('Form populated with:', {
                    application_id: data.application_id,
                    datetime: datetime,
                    duration: data.duration_minutes,
                    interviewer: data.interviewer_id
                });
                
                // NOW show the modal after data is loaded
                const overlay = document.getElementById('interview-modal-overlay');
                overlay.classList.add('active');
            } else {
                alert('Failed to load interview data: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while loading interview data');
        });
}

function deleteInterview(interviewId) {
    if (!confirm('Are you sure you want to delete this interview? This action cannot be undone.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('id', interviewId);
    
    fetch('<?= ROOT ?>/recruitment/interview-schedule/delete/' + interviewId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Interview deleted successfully!');
            window.location.reload(); // Use window.location explicitly
        } else {
            alert('Failed to delete interview: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the interview');
    });
}

function closeInterviewModal() {
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.remove('active');
    selectedInterviewId = null;
    isReschedule = false;
    document.getElementById('candidate-select').disabled = false;
}

function resetInterviewForm() {
    // Clear all selections
    document.querySelectorAll('.interview-duration-pill.selected').forEach(pill => {
        pill.classList.remove('selected');
    });
    document.getElementById('selected-duration').value = '';
    
    // Clear form fields
    document.getElementById('candidate-select').value = '';
    document.getElementById('candidate-select').disabled = false;
    document.getElementById('interviewer-select').value = '';
    document.getElementById('interview-type-select').value = 'Video';
    document.getElementById('interview-location').value = '';
    document.getElementById('interview-datetime').value = '';
    
    // Set default duration (45 min)
    const defaultDuration = document.querySelector('[data-duration="45"]');
    if (defaultDuration) {
        defaultDuration.click();
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const overlay = document.getElementById('interview-modal-overlay');
    if (event.target === overlay) {
        closeInterviewModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const overlay = document.getElementById('interview-modal-overlay');
        if (overlay.classList.contains('active')) {
            closeInterviewModal();
        }
    }
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
    const candidateSelect = document.getElementById('candidate-select');
    const datetime = document.getElementById('interview-datetime').value;
    const duration = document.getElementById('selected-duration').value;
    const interviewer = document.getElementById('interviewer-select').value;
    const interviewType = document.getElementById('interview-type-select').value;
    const locationValue = document.getElementById('interview-location').value; // Renamed to avoid conflict
    
    // Debug logging
    console.log('Validation check:', {
        candidateValue: candidateSelect.value,
        candidateDisabled: candidateSelect.disabled,
        datetime: datetime,
        duration: duration,
        interviewer: interviewer,
        isReschedule: isReschedule
    });
    
    // Validation - different for create vs reschedule
    // For reschedule, candidate field might be disabled so we skip it in validation
    if (isReschedule) {
        // Reschedule: Only validate editable fields
        if (!datetime || !duration || !interviewer) {
            console.error('Reschedule validation failed:', {
                hasDatetime: !!datetime,
                hasDuration: !!duration,
                hasInterviewer: !!interviewer
            });
            alert('Please fill in all required fields (date/time, duration, and interviewer)');
            return;
        }
    } else {
        // Create new: Validate all fields including candidate
        if (!candidateSelect.value) {
            alert('Please select a candidate');
            return;
        }
        if (!datetime || !duration || !interviewer) {
            console.error('Create validation failed:', {
                hasCandidate: !!candidateSelect.value,
                hasDatetime: !!datetime,
                hasDuration: !!duration,
                hasInterviewer: !!interviewer
            });
            alert('Please fill in all required fields');
            return;
        }
    }
    
    // Prepare form data
    const formData = new FormData();
    
    // Only send application_id if creating new interview (not reschedule)
    if (!isReschedule) {
        formData.append('application_id', candidateSelect.value);
    }
    
    formData.append('interviewer_id', interviewer);
    formData.append('datetime', datetime);
    formData.append('duration', duration);
    formData.append('interview_type', interviewType);
    formData.append('location', locationValue); // Use renamed variable
    formData.append('meeting_link', locationValue); // Use same field for both
    
    // Determine URL based on create or update
    const url = isReschedule 
        ? '<?= ROOT ?>/recruitment/interview-schedule/update/' + selectedInterviewId
        : '<?= ROOT ?>/recruitment/interview-schedule/create';
    
    console.log('Submitting to URL:', url);
    console.log('Form data:', {
        application_id: candidateSelect.value,
        interviewer_id: interviewer,
        datetime: datetime,
        duration: duration,
        interview_type: interviewType,
        location: locationValue
    });
    
    // Submit data
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            return response.text().then(text => {
                console.error('Non-JSON response:', text);
                throw new Error('Server returned non-JSON response. Check console for details.');
            });
        }
        
        return response.json();
    })
    .then(result => {
        console.log('Result:', result);
        if (result.success) {
            alert(result.message);
            closeInterviewModal();
            window.location.reload(); // Use window.location explicitly
        } else {
            alert('Error: ' + result.message);
            if (result.errors) {
                console.error('Validation errors:', result.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form: ' + error.message);
    });
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
