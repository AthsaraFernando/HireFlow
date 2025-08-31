<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Shortlisted Candidates</h1>
        <p class="page-description">Manage your shortlisted candidates and schedule interviews</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <a href="<?= ROOT ?>/recruitment/applications" class="btn btn-primary">Review More Applications</a>
        </div>
    </div>

    <div class="candidates-grid">
        <?php foreach($shortlisted_candidates as $candidate): ?>
        <div class="candidate-card">
            <div class="candidate-status <?= strtolower($candidate['status']) ?>"></div>
            
            <div class="candidate-main">
                <div class="candidate-header">
                    <div class="candidate-avatar"><?= strtoupper(substr($candidate['name'], 0, 2)) ?></div>
                    <div class="candidate-info">
                        <h3 class="candidate-name"><?= htmlspecialchars($candidate['name']) ?></h3>
                        <div class="candidate-position"><?= htmlspecialchars($candidate['job_title']) ?></div>
                        <div class="candidate-location"><?= htmlspecialchars($candidate['location']) ?></div>
                    </div>
                    <div class="candidate-score <?= $candidate['match_score'] >= 80 ? 'excellent' : ($candidate['match_score'] >= 60 ? 'good' : 'average') ?>">
                        <?= $candidate['match_score'] ?>%
                    </div>
                </div>
                
                <div class="candidate-details">
                    <div class="detail-row">
                        <span class="detail-label">Experience</span>
                        <span class="detail-value"><?= $candidate['experience'] ?> years</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Company</span>
                        <span class="detail-value"><?= htmlspecialchars($candidate['current_company']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Shortlisted</span>
                        <span class="detail-value"><?= date('M j', strtotime($candidate['shortlisted_date'])) ?></span>
                    </div>
                </div>
                
                <div class="candidate-skills">
                    <div class="skills-preview">
                        <?php 
                        $skillsToShow = array_slice($candidate['skills'], 0, 4);
                        foreach($skillsToShow as $skill): ?>
                            <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php if(count($candidate['skills']) > 4): ?>
                        <div class="skills-count">+<?= count($candidate['skills']) - 4 ?> more skills</div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="candidate-footer">
                <button class="btn-minimal primary" onclick="scheduleInterview(<?= $candidate['id'] ?? '1' ?>)">Interview</button>
                <button class="btn-minimal secondary" onclick="viewApplication(<?= $candidate['id'] ?? '1' ?>)">View</button>
                <button class="btn-minimal danger" onclick="removeFromShortlist(<?= $candidate['id'] ?? '1' ?>)">Remove</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Interview Scheduling Modal - New Design -->
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
// Global variables
let selectedCandidateId = null;

function scheduleInterview(candidateId) {
    selectedCandidateId = candidateId;
    const overlay = document.getElementById('interview-modal-overlay');
    overlay.classList.add('active');
    
    // Set minimum datetime to current time
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('interview-datetime').min = now.toISOString().slice(0, 16);
    
    // Reset form
    resetInterviewForm();
}

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

function viewApplication(candidateId) {
    window.location.href = `<?= ROOT ?>/recruitment/applications?candidate=${candidateId}`;
}

function removeFromShortlist(candidateId) {
    if (confirm('Are you sure you want to remove this candidate from shortlist?')) {
        alert('Candidate removed from shortlist successfully!');
        location.reload();
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
document.addEventListener('click', function(e) {
    const overlay = document.getElementById('interview-modal-overlay');
    if (e.target === overlay) {
        closeInterviewModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const overlay = document.getElementById('interview-modal-overlay');
        if (overlay && overlay.classList.contains('active')) {
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
    
    alert('Interview scheduled successfully!');
    closeInterviewModal();
}
</script>

<?php $this->view('components/footer') ?>
<div class="modal" id="interview-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Schedule Interview</h3>
            <button class="modal-close" onclick="closeModal('interview-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="interview-form">
                <div class="form-group">
                    <label>Interview Date & Time:</label>
                    <input type="datetime-local" id="interview-datetime" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label>Interview Type:</label>
                    <div class="interview-type-options">
                        <div class="interview-type-option" data-type="phone">
                            <span class="icon">📞</span>
                            <span class="label">Phone Screening</span>
                        </div>
                        <div class="interview-type-option" data-type="video">
                            <span class="icon">💻</span>
                            <span class="label">Video Interview</span>
                        </div>
                        <div class="interview-type-option" data-type="person">
                            <span class="icon">🏢</span>
                            <span class="label">In-Person</span>
                        </div>
                        <div class="interview-type-option" data-type="technical">
                            <span class="icon">⚡</span>
                            <span class="label">Technical Test</span>
                        </div>
                    </div>
                    <input type="hidden" id="interview-type" name="interview-type" required>
                </div>

                <div class="interview-form-grid">
                    <div class="form-group">
                        <label>Duration:</label>
                        <div class="duration-options">
                            <div class="duration-option" data-duration="30">30 min</div>
                            <div class="duration-option" data-duration="45">45 min</div>
                            <div class="duration-option" data-duration="60">60 min</div>
                            <div class="duration-option" data-duration="90">90 min</div>
                        </div>
                        <input type="hidden" id="interview-duration" name="interview-duration" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Interviewer:</label>
                        <select class="form-input" id="interviewer">
                            <option value="">Select Interviewer</option>
                            <option value="john-doe">John Doe - Senior Developer</option>
                            <option value="jane-smith">Jane Smith - Team Lead</option>
                            <option value="mike-wilson">Mike Wilson - HR Manager</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Additional Notes:</label>
                    <textarea class="form-input" id="interview-notes" rows="3" placeholder="Interview details, location, special requirements..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('interview-modal')">Cancel</button>
            <button class="btn btn-primary" onclick="submitInterviewSchedule()">Schedule Interview</button>
        </div>
    </div>
</div>

<?php $this->view('components/footer') ?>

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });
});

// Interview type and duration selection
document.addEventListener('DOMContentLoaded', function() {
    const typeOptions = document.querySelectorAll('.interview-type-option');
    const typeInput = document.getElementById('interview-type');
    
    typeOptions.forEach(option => {
        option.addEventListener('click', function() {
            typeOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            typeInput.value = this.dataset.type;
        });
    });
    
    const durationOptions = document.querySelectorAll('.duration-option');
    const durationInput = document.getElementById('interview-duration');
    
    durationOptions.forEach(option => {
        option.addEventListener('click', function() {
            durationOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            durationInput.value = this.dataset.duration;
        });
    });
    
    // Set default duration
    if (durationOptions.length > 1) {
        durationOptions[1].click(); // Default to 45 min
    }
});

</script>

<?php $this->view('components/footer') ?>
