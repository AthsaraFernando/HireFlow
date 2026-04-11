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
                    <a href="<?= ROOT ?>/hradmin/create-job" class="nav-link active">
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
                    <a href="<?= ROOT ?>/hradmin/interview-schedule" class="nav-link">
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
                <h1 class="page-title">Create Job Post</h1>
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
                        <h1 class="hero-title">Create Job Post</h1>
                        <p class="hero-description">Attract top talent with a compelling job posting. Fill out the details below to get started.</p>
                        <div class="breadcrumb">
                            <a href="<?= ROOT ?>/hradmin/dashboard" class="breadcrumb-link">Dashboard</a>
                            <span class="breadcrumb-separator">/</span>
                            <a href="<?= ROOT ?>/hradmin/job-posts" class="breadcrumb-link">Job Posts</a>
                            <span class="breadcrumb-separator">/</span>
                            <span class="breadcrumb-current">Create New</span>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= ROOT ?>/hradmin/job-posts" class="btn btn-outline">
                            <i class="icon-arrow-left"></i>Back to Jobs
                        </a>
                        <button type="submit" form="job-form" class="btn btn-primary">
                            <i class="icon-save"></i>Publish Job
                        </button>
                    </div>
                </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="<?= ROOT ?>/hradmin/create-job" class="job-form">
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="job_title" class="form-label">Job Title *</label>
                        <input type="text" id="job_title" name="job_title" class="form-input" 
                               value="<?= $_POST['job_title'] ?? '' ?>" placeholder="e.g. Senior Software Developer" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="department_id" class="form-label">Department *</label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php if (!empty($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>" <?= ($_POST['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($dept['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="employment_type" class="form-label">Employment Type *</label>
                        <select id="employment_type" name="employment_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Full-time" <?= ($_POST['employment_type'] ?? '') == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                            <option value="Part-time" <?= ($_POST['employment_type'] ?? '') == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                            <option value="Contract" <?= ($_POST['employment_type'] ?? '') == 'Contract' ? 'selected' : '' ?>>Contract</option>
                            <option value="Internship" <?= ($_POST['employment_type'] ?? '') == 'Internship' ? 'selected' : '' ?>>Internship</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience_level" class="form-label">Experience Level *</label>
                        <select id="experience_level" name="experience_level" class="form-select" required>
                            <option value="">Select Level</option>
                            <option value="entry" <?= ($_POST['experience_level'] ?? '') == 'entry' ? 'selected' : '' ?>>Entry Level</option>
                            <option value="mid" <?= ($_POST['experience_level'] ?? '') == 'mid' ? 'selected' : '' ?>>Mid Level</option>
                            <option value="senior" <?= ($_POST['experience_level'] ?? '') == 'senior' ? 'selected' : '' ?>>Senior Level</option>
                            <option value="lead" <?= ($_POST['experience_level'] ?? '') == 'lead' ? 'selected' : '' ?>>Lead/Principal</option>
                            <option value="executive" <?= ($_POST['experience_level'] ?? '') == 'executive' ? 'selected' : '' ?>>Executive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Location *</label>
                        <input type="text" id="location" name="location" class="form-input" 
                               value="<?= $_POST['location'] ?? '' ?>" placeholder="e.g. San Francisco, CA or Remote" required>
                    </div>

                    <div class="form-group">
                        <label for="salary_range" class="form-label">Salary Range</label>
                        <input type="text" id="salary_range" name="salary_range" class="form-input" 
                               value="<?= $_POST['salary_range'] ?? '' ?>" placeholder="e.g. $80,000 - $120,000">
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="form-section">
                <h3 class="section-title">Job Description</h3>
                <div class="form-group">
                    <label for="summary" class="form-label">Job Summary *</label>
                    <textarea id="summary" name="summary" class="form-textarea" rows="4" 
                              placeholder="Brief overview of the role and its importance to the company" required><?= $_POST['summary'] ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="requirements" class="form-label">Requirements *</label>
                    <textarea id="requirements" name="requirements" class="form-textarea" rows="6" 
                              placeholder="• Education requirements&#10;• Years of experience needed&#10;• Technical skills required&#10;• Soft skills preferred" required><?= $_POST['requirements'] ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="preferred_qualifications" class="form-label">Preferred Qualifications</label>
                    <textarea id="preferred_qualifications" name="preferred_qualifications" class="form-textarea" rows="4" 
                              placeholder="• Nice-to-have skills&#10;• Additional certifications&#10;• Industry experience"><?= $_POST['preferred_qualifications'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- Benefits & Perks -->
            <div class="form-section">
                <h3 class="section-title">Benefits & Perks</h3>
                <div class="form-group">
                    <label for="benefits" class="form-label">Benefits Package</label>
                    <textarea id="benefits" name="benefits" class="form-textarea" rows="4" 
                              placeholder="• Health insurance&#10;• Retirement plans&#10;• Paid time off&#10;• Professional development opportunities"><?= $_POST['benefits'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="form-section">
                <h3 class="section-title">Application Settings</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="application_deadline" class="form-label">Application Deadline</label>
                        <input type="date" id="application_deadline" name="application_deadline" class="form-input" 
                               value="<?= $_POST['application_deadline'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="Draft" <?= ($_POST['status'] ?? 'Draft') == 'Draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="Open" <?= ($_POST['status'] ?? '') == 'Open' ? 'selected' : '' ?>>Open</option>
                            <option value="Closed" <?= ($_POST['status'] ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hiring_manager" class="form-label">Hiring Manager</label>
                        <select id="hiring_manager" name="hiring_manager" class="form-select">
                            <option value="">Select Hiring Manager</option>
                            <option value="1" <?= ($_POST['hiring_manager'] ?? '') == '1' ? 'selected' : '' ?>>John Smith</option>
                            <option value="2" <?= ($_POST['hiring_manager'] ?? '') == '2' ? 'selected' : '' ?>>Sarah Johnson</option>
                            <option value="3" <?= ($_POST['hiring_manager'] ?? '') == '3' ? 'selected' : '' ?>>Mike Wilson</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="openings" class="form-label">Number of Openings</label>
                        <input type="number" id="openings" name="openings" class="form-input" 
                               value="<?= $_POST['openings'] ?? '1' ?>" min="1" max="50">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="saveDraft()">Save as Draft</button>
                <button type="submit" class="btn btn-primary">
                    <i class="icon-save"></i>Create Job Post
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.form-container {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 2rem;
    margin-top: 1.5rem;
}

.form-section {
    margin-bottom: 2.5rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-title {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    border-bottom: 2px solid #f1f3f4;
    padding-bottom: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #4e31aa;
    box-shadow: 0 0 0 3px rgba(78, 49, 170, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
    margin-top: 2rem;
}

.form-actions .btn {
    min-width: 150px;
}

/* Required field indicator */
.form-label::after {
    content: ' *';
    color: #dc3545;
}

.form-label:not([for$="_required"])::after {
    content: '';
}

/* Icon styles */
.icon-back::before { content: '←'; }
.icon-save::before { content: ''; }

/* Responsive design */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>

<script>
function saveDraft() {
    // Set status to draft and submit form
    document.getElementById('status').value = 'draft';
    document.querySelector('.job-form').submit();
}

// Auto-save functionality (optional)
let autoSaveTimeout;
function autoSave() {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        // Save form data to localStorage or send AJAX request
        console.log('Auto-saving form data...');
    }, 30000); // Save every 30 seconds
}

// Add event listeners for auto-save
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(element => {
    element.addEventListener('input', autoSave);
});

// Load saved data on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load any previously saved data
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

<?php $this->view('components/footer') ?>
