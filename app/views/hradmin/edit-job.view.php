<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Edit Job Post</h1>
        <p class="page-description">Update job posting details and requirements</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/job-posts" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Job Posts
            </a>
            <a href="<?= ROOT ?>/hradmin/view-job/<?= $job['id'] ?>" class="btn btn-outline">
                <i class="icon-eye"></i>Preview
            </a>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="<?= ROOT ?>/hradmin/edit-job/<?= $job['id'] ?>" class="job-form">

            <!-- Basic Info -->
            <div class="form-section">
                <h3 class="section-title">Basic Information</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Job Title *</label>
                        <input type="text" name="job_title" class="form-input"
                            value="<?= htmlspecialchars($job['title'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Department *</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php foreach ($departments ?? [] as $dept): ?>
                                <option value="<?= $dept['id'] ?>"
                                    <?= ($job['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dept['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Employment Type *</label>
                        <select name="employment_type" class="form-select" required>
                            <option value="Full-time" <?= ($job['employment_type'] ?? '') == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                            <option value="Part-time" <?= ($job['employment_type'] ?? '') == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                            <option value="Contract" <?= ($job['employment_type'] ?? '') == 'Contract' ? 'selected' : '' ?>>Contract</option>
                            <option value="Internship" <?= ($job['employment_type'] ?? '') == 'Internship' ? 'selected' : '' ?>>Internship</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Experience Level *</label>
                        <?php $exp = strtolower($job['experience_level'] ?? ''); ?>
                        <select name="experience_level" class="form-select" required>
                            <option value="entry" <?= $exp == 'entry' ? 'selected' : '' ?>>Entry</option>
                            <option value="mid" <?= $exp == 'mid' ? 'selected' : '' ?>>Mid</option>
                            <option value="senior" <?= $exp == 'senior' ? 'selected' : '' ?>>Senior</option>
                            <option value="executive" <?= $exp == 'executive' ? 'selected' : '' ?>>Executive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-input"
                            value="<?= htmlspecialchars($job['location'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Salary Range</label>
                        <input type="text" name="salary_range" class="form-input"
                            value="<?= htmlspecialchars($job['salary_range'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-section">
                <h3 class="section-title">Job Description</h3>

                <div class="form-group">
                    <label class="form-label">Summary *</label>
                    <textarea name="summary" class="form-textarea" required><?= htmlspecialchars($job['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Responsibilities</label>
                    <textarea name="responsibilities" class="form-textarea"><?= htmlspecialchars($job['responsibilities'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Requirements *</label>
                    <textarea name="requirements" class="form-textarea" required><?= htmlspecialchars($job['requirements'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Application -->
            <div class="form-section">
                <h3 class="section-title">Application Settings</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="application_deadline" class="form-input"
                            value="<?= $job['deadline'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <?php $status = ucfirst(strtolower($job['status'] ?? 'Draft')); ?>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Draft" <?= $status == 'Draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="Open" <?= $status == 'Open' ? 'selected' : '' ?>>Open</option>
                            <option value="Closed" <?= $status == 'Closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hiring Manager</label>
                        <select name="hiring_manager" class="form-select">
                            <option value="">Select</option>
                            <?php foreach ($hiring_managers ?? [] as $manager): ?>
                                <option value="<?= $manager['id'] ?>"
                                    <?= ($job['hr_id'] ?? '') == $manager['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($manager['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="form-section">
                <h3 class="section-title">Job Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value"><?= $job['applications_count'] ?? 0 ?></div>
                        <div class="stat-label">Applications</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" onclick="saveDraft()" class="btn btn-secondary">Save Draft</button>
                <button type="submit" class="btn btn-primary">Update Job</button>
            </div>

        </form>
    </div>
</div>

<script>
function saveDraft() {
    document.getElementById('status').value = 'Draft';
    document.querySelector('.job-form').submit();
}
</script>

<?php $this->view('components/footer') ?>