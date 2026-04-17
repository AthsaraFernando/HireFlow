<?php
$formJob = $job ?? [];
if (!empty($form_data) && is_array($form_data)) {
    $formJob = array_merge($formJob, $form_data);
}
$formAction = ROOT . '/hradmin/edit-job/' . ($job['id'] ?? $job_id ?? '');
if (!empty($is_modal)) {
    $formAction .= '?modal=1';
}
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= $formAction ?>" class="job-form js-edit-job-form">

    <div class="form-section">
        <h3 class="section-title">Basic Information</h3>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Job Title *</label>
                <?php $selectedJobTitle = $formJob['title'] ?? $formJob['job_title'] ?? ''; ?>
                <?php
                    $selectedTitleExists = false;
                    if (!empty($job_categories) && is_array($job_categories)) {
                        foreach ($job_categories as $category) {
                            if (($category['name'] ?? '') === $selectedJobTitle) {
                                $selectedTitleExists = true;
                                break;
                            }
                        }
                    }
                ?>
                <select name="job_title" class="form-select" required>
                    <option value="">Select Job Title</option>
                    <?php foreach ($job_categories ?? [] as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>"
                            <?= $selectedJobTitle === $category['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    <?php if ($selectedJobTitle !== '' && !$selectedTitleExists): ?>
                        <option value="<?= htmlspecialchars($selectedJobTitle) ?>" selected>
                            <?= htmlspecialchars($selectedJobTitle) ?>
                        </option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Department *</label>
                <select name="department_id" class="form-select" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments ?? [] as $dept): ?>
                        <option value="<?= $dept['id'] ?>"
                            <?= (string)($formJob['department_id'] ?? '') === (string)$dept['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Employment Type *</label>
                <select name="employment_type" class="form-select" required>
                    <option value="Full-time" <?= ($formJob['employment_type'] ?? '') == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                    <option value="Part-time" <?= ($formJob['employment_type'] ?? '') == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                    <option value="Contract" <?= ($formJob['employment_type'] ?? '') == 'Contract' ? 'selected' : '' ?>>Contract</option>
                    <option value="Internship" <?= ($formJob['employment_type'] ?? '') == 'Internship' ? 'selected' : '' ?>>Internship</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Experience Level *</label>
                <?php $exp = strtolower($formJob['experience_level'] ?? ''); ?>
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
                    value="<?= htmlspecialchars($formJob['location'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Salary Range</label>
                <input type="text" name="salary_range" class="form-input"
                    value="<?= htmlspecialchars($formJob['salary_range'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="form-section">
        <h3 class="section-title">Job Description</h3>

        <div class="form-group">
            <label class="form-label">Summary *</label>
            <textarea name="summary" class="form-textarea" required><?= htmlspecialchars($formJob['description'] ?? $formJob['summary'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Responsibilities</label>
            <textarea name="responsibilities" class="form-textarea"><?= htmlspecialchars($formJob['responsibilities'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Requirements *</label>
            <textarea name="requirements" class="form-textarea" required><?= htmlspecialchars($formJob['requirements'] ?? '') ?></textarea>
        </div>
    </div>

    <div class="form-section">
        <h3 class="section-title">Benefits & Perks</h3>
        <div class="form-group">
            <label class="form-label">Benefits Package</label>
            <textarea name="benefits" class="form-textarea" rows="4"><?= htmlspecialchars($formJob['benefits'] ?? '') ?></textarea>
        </div>
    </div>

    <div class="form-section">
        <h3 class="section-title">Application Settings</h3>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Deadline</label>
                <input type="date" name="application_deadline" class="form-input"
                    value="<?= htmlspecialchars($formJob['deadline'] ?? $formJob['application_deadline'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Status *</label>
                <?php $status = ucfirst(strtolower($formJob['status'] ?? 'Draft')); ?>
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
                            <?= (string)($formJob['hr_id'] ?? $formJob['hiring_manager'] ?? '') === (string)$manager['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($manager['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

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
        <button type="button" onclick="saveDraft(this.form)" class="btn btn-secondary">Save Draft</button>
        <button type="submit" class="btn btn-primary">Update Job</button>
    </div>

</form>

<script>
function saveDraft(form) {
    const statusField = form.querySelector('[name="status"]');
    if (statusField) {
        statusField.value = 'Draft';
    }
    form.submit();
}
</script>
