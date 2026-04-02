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
            <h1 class="page-title">Create Job Post</h1>
        </header>

        <div class="dashboard-content">
            <div class="main-container">

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach($errors as $error): ?>
                            <p><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST" action="<?= ROOT ?>/hradmin/create-job" class="job-form">

                        <!-- Basic Info -->
                        <div class="form-section">
                            <h3 class="section-title">Basic Information</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Job Title *</label>
                                    <input type="text" name="job_title" class="form-input"
                                        value="<?= $_POST['job_title'] ?? '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Department *</label>
                                    <select name="department_id" class="form-select" required>
                                        <option value="">Select Department</option>
                                        <?php foreach ($departments ?? [] as $dept): ?>
                                            <option value="<?= $dept['id'] ?>"
                                                <?= ($_POST['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($dept['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Employment Type *</label>
                                    <select name="employment_type" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="Full-time" <?= ($_POST['employment_type'] ?? '') == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                        <option value="Part-time" <?= ($_POST['employment_type'] ?? '') == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                        <option value="Contract" <?= ($_POST['employment_type'] ?? '') == 'Contract' ? 'selected' : '' ?>>Contract</option>
                                        <option value="Internship" <?= ($_POST['employment_type'] ?? '') == 'Internship' ? 'selected' : '' ?>>Internship</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Experience Level *</label>
                                    <select name="experience_level" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="entry" <?= ($_POST['experience_level'] ?? '') == 'entry' ? 'selected' : '' ?>>Entry</option>
                                        <option value="mid" <?= ($_POST['experience_level'] ?? '') == 'mid' ? 'selected' : '' ?>>Mid</option>
                                        <option value="senior" <?= ($_POST['experience_level'] ?? '') == 'senior' ? 'selected' : '' ?>>Senior</option>
                                        <option value="executive" <?= ($_POST['experience_level'] ?? '') == 'executive' ? 'selected' : '' ?>>Executive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Location *</label>
                                    <input type="text" name="location" class="form-input"
                                        value="<?= $_POST['location'] ?? '' ?>" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Salary Range</label>
                                    <input type="text" name="salary_range" class="form-input"
                                        value="<?= $_POST['salary_range'] ?? '' ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-section">
                            <h3 class="section-title">Job Description</h3>

                            <div class="form-group">
                                <label class="form-label">Summary *</label>
                                <textarea name="summary" class="form-textarea" required><?= $_POST['summary'] ?? '' ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Responsibilities</label>
                                <textarea name="responsibilities" class="form-textarea"><?= $_POST['responsibilities'] ?? '' ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Requirements *</label>
                                <textarea name="requirements" class="form-textarea" required><?= $_POST['requirements'] ?? '' ?></textarea>
                            </div>
                        </div>

                        <!-- Application -->
                        <div class="form-section">
                            <h3 class="section-title">Application Settings</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Deadline</label>
                                    <input type="date" name="application_deadline" class="form-input"
                                        value="<?= $_POST['application_deadline'] ?? '' ?>">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Status *</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="Draft" <?= ($_POST['status'] ?? 'Draft') == 'Draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="Open" <?= ($_POST['status'] ?? '') == 'Open' ? 'selected' : '' ?>>Open</option>
                                        <option value="Closed" <?= ($_POST['status'] ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Hiring Manager</label>
                                    <select name="hiring_manager" class="form-select">
                                        <option value="">Select</option>
                                        <?php foreach ($hiring_managers ?? [] as $manager): ?>
                                            <option value="<?= $manager['id'] ?>"
                                                <?= ($_POST['hiring_manager'] ?? '') == $manager['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($manager['full_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" onclick="saveDraft()" class="btn btn-secondary">Save Draft</button>
                            <button type="submit" class="btn btn-primary">Create Job</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

<script>
function saveDraft() {
    document.getElementById('status').value = 'Draft';
    document.querySelector('.job-form').submit();
}
</script>

<?php $this->view('components/footer') ?>