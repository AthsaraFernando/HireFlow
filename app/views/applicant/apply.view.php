<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?= esc($job['title']) ?> - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/apply.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <style>
        .form-preview-container {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        .form-header { border-bottom: 2px solid #e5e7eb; margin-bottom: 2rem; padding-bottom: 1rem; }
        .form-title { margin: 0 0 0.5rem 0; font-size: 1.75rem; }
        .form-description { margin: 0; color: #6b7280; }
        .job-details-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        .detail-box { padding: 0.9rem; border: 1px solid #e5e7eb; border-radius: 10px; background: #f9fafb; }
        .detail-label { display: block; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0.3rem; }
        .detail-value { color: #111827; font-weight: 600; }
        .form-section { margin-bottom: 2rem; }
        .section-heading { margin: 0 0 1rem 0; }
        .fields-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; }
        .form-field { display: flex; flex-direction: column; }
        .form-field.full-width { grid-column: 1 / -1; }
        .field-label { font-weight: 600; margin-bottom: 0.35rem; color: #1f2937; }
        .required-mark { color: #dc2626; }
        .field-help { margin: 0 0 0.35rem 0; color: #6b7280; font-size: 0.85rem; }
        .form-input, .form-select, .form-textarea, .form-file {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0.7rem 0.8rem;
            font-size: 0.95rem;
            background: #fff;
        }
        .checkbox-label { display: inline-flex; align-items: center; gap: 0.5rem; }
        .form-actions { display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 2rem; }
        .submission-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.8rem;
            color: #374151;
        }
        .alert { padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 1rem; }
        .alert-success { background: #ecfdf3; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
        @media (max-width: 768px) {
            .form-preview-container { padding: 1rem; }
            .form-actions { flex-direction: column; }
            .form-actions .btn { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs" class="nav-link"><span class="nav-text">Browse Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/applications" class="nav-link active"><span class="nav-text">My Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link"><span class="nav-text">Saved Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews" class="nav-link"><span class="nav-text">Interview Schedule</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link"><span class="nav-text">Interview Feedback</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/profile" class="nav-link"><span class="nav-text">My Profile</span></a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn"><span>Logout</span></a>
        </div>
    </div>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <div class="breadcrumb">
                    <a href="<?= ROOT ?>/applicant/jobs" class="breadcrumb-link">Browse Jobs</a>
                    <span class="breadcrumb-separator">›</span>
                    <a href="<?= ROOT ?>/applicant/jobs/details/<?= $job['id'] ?>" class="breadcrumb-link">Job Details</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Application Form</span>
                </div>
                <h1 class="page-title">Apply for <?= esc($job['title']) ?></h1>
                <p class="page-subtitle"><?= esc($job['company']) ?> • <?= esc($job['location']) ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= esc($user['name'] ?? 'Applicant') ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?></div>
                </div>
            </div>
        </header>

        <div class="apply-content">
            <div class="apply-main" style="max-width: 100%;">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form id="applicationForm" method="POST" action="<?= ROOT ?>/applicant/applications/apply" enctype="multipart/form-data" class="form-preview-container">
                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">

                    <div class="form-header">
                        <h2 class="form-title"><?= esc($form['form_title']) ?></h2>
                        <p class="form-description"><?= esc($form['form_description']) ?></p>
                    </div>

                    <div class="form-section">
                        <h3 class="section-heading">Job Details</h3>
                        <div class="job-details-grid">
                            <div class="detail-box"><span class="detail-label">Job Title</span><div class="detail-value"><?= esc($job['title']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Department</span><div class="detail-value"><?= esc($job['department']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Location</span><div class="detail-value"><?= esc($job['location']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Employment Type</span><div class="detail-value"><?= esc($job['employment_type']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Salary Range</span><div class="detail-value"><?= esc($job['salary']) ?></div></div>
                            <?php if (!empty($job['deadline'])): ?>
                                <div class="detail-box"><span class="detail-label">Application Deadline</span><div class="detail-value"><?= date('F d, Y', strtotime($job['deadline'])) ?></div></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php foreach ($grouped_fields as $category => $fields): ?>
                        <div class="form-section">
                            <h3 class="section-heading"><?= esc($category_labels[$category] ?? ucfirst(str_replace('_', ' ', $category))) ?></h3>
                            <div class="fields-container">
                                <?php foreach ($fields as $field): ?>
                                    <?php
                                        $fname = $field['field_name'];
                                        $ftype = $field['field_type'];
                                        $required = (int)$field['is_required'] === 1;
                                        $prefillValue = $prefill[$fname] ?? '';
                                    ?>
                                    <div class="form-field <?= $ftype === 'textarea' ? 'full-width' : '' ?>">
                                        <label class="field-label" for="field_<?= esc($fname) ?>">
                                            <?= esc($field['field_label']) ?>
                                            <?php if ($required): ?><span class="required-mark">*</span><?php endif; ?>
                                        </label>

                                        <?php if (!empty($field['help_text'])): ?>
                                            <p class="field-help"><?= esc($field['help_text']) ?></p>
                                        <?php endif; ?>

                                        <?php if (in_array($ftype, ['text', 'email', 'tel', 'url', 'date'], true)): ?>
                                            <input
                                                type="<?= esc($ftype) ?>"
                                                id="field_<?= esc($fname) ?>"
                                                name="form_fields[<?= esc($fname) ?>]"
                                                class="form-input"
                                                value="<?= esc($prefillValue) ?>"
                                                placeholder="<?= esc($field['placeholder'] ?? '') ?>"
                                                <?= $required ? 'required' : '' ?>
                                            >

                                        <?php elseif ($ftype === 'textarea'): ?>
                                            <textarea
                                                id="field_<?= esc($fname) ?>"
                                                name="form_fields[<?= esc($fname) ?>]"
                                                rows="4"
                                                class="form-textarea"
                                                placeholder="<?= esc($field['placeholder'] ?? '') ?>"
                                                <?= $required ? 'required' : '' ?>
                                            ><?= esc($prefillValue) ?></textarea>

                                        <?php elseif ($ftype === 'select'): ?>
                                            <select id="field_<?= esc($fname) ?>" name="form_fields[<?= esc($fname) ?>]" class="form-select" <?= $required ? 'required' : '' ?>>
                                                <option value="">-- Select --</option>
                                                <?php
                                                    $options = json_decode($field['field_options'] ?? '[]', true);
                                                    if (is_array($options)):
                                                        foreach ($options as $option):
                                                ?>
                                                    <option value="<?= esc($option) ?>" <?= ($prefillValue === $option) ? 'selected' : '' ?>><?= esc($option) ?></option>
                                                <?php
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>

                                        <?php elseif ($ftype === 'file'): ?>
                                            <input
                                                type="file"
                                                id="field_<?= esc($fname) ?>"
                                                name="form_files[<?= esc($fname) ?>]"
                                                class="form-file"
                                                accept="<?= (stripos($fname, 'resume') !== false) ? '.pdf' : '.pdf,.doc,.docx' ?>"
                                                <?= $required ? 'required' : '' ?>
                                            >

                                        <?php elseif ($ftype === 'checkbox'): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" id="field_<?= esc($fname) ?>" name="form_fields[<?= esc($fname) ?>]" value="1" <?= $required ? 'required' : '' ?>>
                                                <span><?= esc($field['field_label']) ?></span>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="form-section">
                        <div class="submission-info">
                            <span>Info:</span>
                            <p style="margin:0;">Your application will be dated automatically when you submit.</p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="<?= ROOT ?>/applicant/jobs/details/<?= $job['id'] ?>" class="btn btn-outline">Back to Job</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('applicationForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.textContent = 'Submitting...';
        });
    </script>
</body>
</html>
