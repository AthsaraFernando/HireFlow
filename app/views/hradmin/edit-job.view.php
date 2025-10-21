<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Edit Job Post</h1>
        <p class="page-description">Update job posting details and requirements</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/jobposts" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Job Posts
            </a>
            <a href="<?= ROOT ?>/hradmin/jobposts/view/<?= $job['id'] ?? '1' ?>" class="btn btn-outline">
                <i class="icon-eye"></i>Preview
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

    <div class="form-container">
        <form method="POST" action="<?= ROOT ?>/hradmin/jobposts/edit/<?= $job['id'] ?? '1' ?>" class="job-form">
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="job_title" class="form-label">Job Title *</label>
                        <input type="text" id="job_title" name="job_title" class="form-input" 
                               value="<?= htmlspecialchars($job['title'] ?? 'Senior Software Developer') ?>" 
                               placeholder="e.g. Senior Software Developer" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="department" class="form-label">Department *</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php $dept = strtolower($job['department'] ?? ''); ?>
                            <option value="Engineering" <?= $dept == 'engineering' ? 'selected' : '' ?>>Engineering</option>
                            <option value="Design" <?= $dept == 'design' ? 'selected' : '' ?>>Design</option>
                            <option value="Marketing" <?= $dept == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                            <option value="Sales" <?= $dept == 'sales' ? 'selected' : '' ?>>Sales</option>
                            <option value="HR" <?= $dept == 'hr' ? 'selected' : '' ?>>Human Resources</option>
                            <option value="Finance" <?= $dept == 'finance' ? 'selected' : '' ?>>Finance</option>
                            <option value="Operations" <?= $dept == 'operations' ? 'selected' : '' ?>>Operations</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="employment_type" class="form-label">Employment Type *</label>
                        <select id="employment_type" name="employment_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <?php $emp_type = strtolower($job['employment_type'] ?? ''); ?>
                            <option value="Full-time" <?= $emp_type == 'full-time' ? 'selected' : '' ?>>Full-time</option>
                            <option value="Part-time" <?= $emp_type == 'part-time' ? 'selected' : '' ?>>Part-time</option>
                            <option value="Contract" <?= $emp_type == 'contract' ? 'selected' : '' ?>>Contract</option>
                            <option value="Internship" <?= $emp_type == 'internship' ? 'selected' : '' ?>>Internship</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience_level" class="form-label">Experience Level *</label>
                        <select id="experience_level" name="experience_level" class="form-select" required>
                            <option value="">Select Level</option>
                            <?php $exp_level = strtolower($job['experience_level'] ?? ''); ?>
                            <option value="Entry" <?= $exp_level == 'entry' ? 'selected' : '' ?>>Entry Level</option>
                            <option value="Mid" <?= $exp_level == 'mid' ? 'selected' : '' ?>>Mid Level</option>
                            <option value="Senior" <?= $exp_level == 'senior' ? 'selected' : '' ?>>Senior Level</option>
                            <option value="Lead" <?= $exp_level == 'lead' ? 'selected' : '' ?>>Lead/Principal</option>
                            <option value="Executive" <?= $exp_level == 'executive' ? 'selected' : '' ?>>Executive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location *</label>
                        <input type="text" id="location" name="location" class="form-input" 
                               value="<?= htmlspecialchars($job['location'] ?? 'San Francisco, CA') ?>" 
                               placeholder="e.g. San Francisco, CA or Remote" required>
                    </div>

                    <div class="form-group">
                        <label for="salary_range" class="form-label">Salary Range</label>
                        <input type="text" id="salary_range" name="salary_range" class="form-input" 
                               value="<?= htmlspecialchars($job['salary_range'] ?? '$120,000 - $160,000') ?>" 
                               placeholder="e.g. $80,000 - $120,000">
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="form-section">
                <h3 class="section-title">Job Description</h3>
                <div class="form-group">
                    <label for="summary" class="form-label">Job Summary *</label>
                    <textarea id="summary" name="summary" class="form-textarea" rows="4" 
                              placeholder="Brief overview of the role and its importance to the company" required><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="responsibilities" class="form-label">Key Responsibilities *</label>
                    <textarea id="responsibilities" name="responsibilities" class="form-textarea" rows="8" 
                              placeholder="• List key responsibilities here" required><?= htmlspecialchars($job['responsibilities'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="requirements" class="form-label">Requirements *</label>
                    <textarea id="requirements" name="requirements" class="form-textarea" rows="8" 
                              placeholder="• Education requirements" required><?= htmlspecialchars($job['requirements'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="preferred_qualifications" class="form-label">Preferred Qualifications</label>
                    <textarea id="preferred_qualifications" name="preferred_qualifications" class="form-textarea" rows="4" 
                              placeholder="• Nice-to-have skills"><?= htmlspecialchars($job['preferred_qualifications'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Benefits & Perks -->
            <div class="form-section">
                <h3 class="section-title">Benefits & Perks</h3>
                <div class="form-group">
                    <label for="benefits" class="form-label">Benefits Package</label>
                    <textarea id="benefits" name="benefits" class="form-textarea" rows="6" 
                              placeholder="• Health insurance"><?= htmlspecialchars($job['benefits'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="form-section">
                <h3 class="section-title">Application Settings</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="application_deadline" class="form-label">Application Deadline</label>
                        <input type="date" id="application_deadline" name="application_deadline" class="form-input" 
                               value="<?= $job['deadline'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-select" required>
                            <?php $status = ucfirst(strtolower($job['status'] ?? 'draft')); ?>
                            <option value="Draft" <?= $status == 'Draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="Open" <?= $status == 'Open' ? 'selected' : '' ?>>Open</option>
                            <option value="Closed" <?= $status == 'Closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hiring_manager" class="form-label">Hiring Manager</label>
                        <select id="hiring_manager" name="hiring_manager" class="form-select">
                            <option value="">Select Hiring Manager</option>
                            <option value="1" <?= ($job['hiring_manager'] ?? '') == '1' ? 'selected' : '' ?>>John Smith</option>
                            <option value="2" <?= ($job['hiring_manager'] ?? '') == '2' ? 'selected' : '' ?>>Sarah Johnson</option>
                            <option value="3" <?= ($job['hiring_manager'] ?? '') == '3' ? 'selected' : '' ?>>Mike Wilson</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="openings" class="form-label">Number of Openings</label>
                        <input type="number" id="openings" name="openings" class="form-input" 
                               value="<?= $job['openings'] ?? '1' ?>" min="1" max="50">
                    </div>
                </div>
            </div>

            <!-- Job Statistics -->
            <div class="form-section">
                <h3 class="section-title">Job Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value"><?= $job['applications_count'] ?? '23' ?></div>
                        <div class="stat-label">Total Applications</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?= $job['views_count'] ?? '456' ?></div>
                        <div class="stat-label">Job Views</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?= $job['shortlisted_count'] ?? '8' ?></div>
                        <div class="stat-label">Shortlisted</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?= $job['interviewed_count'] ?? '5' ?></div>
                        <div class="stat-label">Interviewed</div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="saveDraft()">Save as Draft</button>
                <button type="submit" name="action" value="update" class="btn btn-primary">
                    <i class="icon-save"></i>Update Job Post
                </button>
                <button type="submit" name="action" value="publish" class="btn btn-success" 
                        <?= ($job['status'] ?? '') == 'active' ? 'style="display:none"' : '' ?>>
                    <i class="icon-publish"></i>Publish Now
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.stat-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #4e31aa;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-outline {
    border: 1px solid #4e31aa;
    color: #4e31aa;
    background: transparent;
}

.btn-outline:hover {
    background: #4e31aa;
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
    border: 1px solid #28a745;
}

.btn-success:hover {
    background: #218838;
    border-color: #1e7e34;
}

/* Icon styles */
.icon-back::before { content: '←'; }
.icon-eye::before { content: ''; }
.icon-save::before { content: ''; }
.icon-publish::before { content: ''; }

.last-updated {
    background: #e7f3ff;
    border: 1px solid #bee5eb;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
    color: #0c5460;
}

/* Form modifications for edit mode */
.form-container {
    position: relative;
}

.form-container::before {
    content: 'EDITING MODE';
    position: absolute;
    top: -10px;
    right: 20px;
    background: #ffc107;
    color: #212529;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 10;
}
</style>

<script>
function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.querySelector('.job-form').submit();
}

// Form change tracking
let originalFormData = new FormData(document.querySelector('.job-form'));
let hasChanges = false;

function trackChanges() {
    const currentFormData = new FormData(document.querySelector('.job-form'));
    hasChanges = false;
    
    for (let [key, value] of currentFormData.entries()) {
        if (originalFormData.get(key) !== value) {
            hasChanges = true;
            break;
        }
    }
    
    // Update button states based on changes
    const updateBtn = document.querySelector('button[value="update"]');
    if (updateBtn) {
        updateBtn.disabled = !hasChanges;
    }
}

// Add change listeners
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(element => {
    element.addEventListener('input', trackChanges);
    element.addEventListener('change', trackChanges);
});

// Disable warning when form is submitted
let isSubmitting = false;
document.querySelector('.job-form').addEventListener('submit', function() {
    isSubmitting = true;
});

// Warn before leaving if there are unsaved changes
window.addEventListener('beforeunload', function(e) {
    if (hasChanges && !isSubmitting) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Auto-save functionality
let autoSaveTimeout;
function autoSave() {
    if (!hasChanges) return;
    
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        // Save form data
        console.log('Auto-saving changes...');
        // You can implement AJAX save here
    }, 30000);
}

document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(element => {
    element.addEventListener('input', () => {
        trackChanges();
        autoSave();
    });
});
</script>

<?php $this->view('components/footer') ?>
