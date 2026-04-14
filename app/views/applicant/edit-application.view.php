<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application - <?= esc($application['job_title']) ?> - HireFlow</title>
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
        .current-resume-box {
            margin-bottom: 0.8rem;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
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
                    <a href="<?= ROOT ?>/applicant/applications" class="breadcrumb-link">My Applications</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Edit Application</span>
                </div>
                <h1 class="page-title">Edit Application for <?= esc($application['job_title']) ?></h1>
                <p class="page-subtitle"><?= esc($application['company']) ?> • <?= esc($application['location']) ?></p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
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

                <form id="editApplicationForm" method="POST" action="<?= ROOT ?>/applicant/editApplication/<?= (int)$application['id'] ?>" enctype="multipart/form-data" class="form-preview-container">
                    <div class="form-header">
                        <h2 class="form-title"><?= esc($form['form_title'] ?? 'Update Application') ?></h2>
                        <p class="form-description">Review and update your submitted information.</p>
                    </div>

                    <div class="form-section">
                        <h3 class="section-heading">Job Details</h3>
                        <div class="job-details-grid">
                            <div class="detail-box"><span class="detail-label">Job Title</span><div class="detail-value"><?= esc($application['job_title']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Department</span><div class="detail-value"><?= esc($application['department']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Location</span><div class="detail-value"><?= esc($application['location']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Employment Type</span><div class="detail-value"><?= esc($application['employment_type']) ?></div></div>
                            <div class="detail-box"><span class="detail-label">Salary Range</span><div class="detail-value"><?= esc($application['salary']) ?></div></div>
                            <?php if (!empty($application['deadline'])): ?>
                                <div class="detail-box"><span class="detail-label">Application Deadline</span><div class="detail-value"><?= date('F d, Y', strtotime($application['deadline'])) ?></div></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($grouped_fields)): ?>
                        <?php foreach ($grouped_fields as $category => $fields): ?>
                            <div class="form-section">
                                <h3 class="section-heading"><?= esc($category_labels[$category] ?? ucfirst(str_replace('_', ' ', $category))) ?></h3>
                                <div class="fields-container">
                                    <?php foreach ($fields as $field): ?>
                                        <?php
                                            $fname = $field['field_name'];
                                            $ftype = $field['field_type'];
                                            $required = (int)$field['is_required'] === 1;
                                            $value = $prefill_values[$fname] ?? '';
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
                                                    value="<?= esc($value) ?>"
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
                                                ><?= esc($value) ?></textarea>

                                            <?php elseif ($ftype === 'select'): ?>
                                                <select id="field_<?= esc($fname) ?>" name="form_fields[<?= esc($fname) ?>]" class="form-select" <?= $required ? 'required' : '' ?>>
                                                    <option value="">-- Select --</option>
                                                    <?php
                                                        $options = json_decode($field['field_options'] ?? '[]', true);
                                                        if (is_array($options)):
                                                            foreach ($options as $option):
                                                    ?>
                                                        <option value="<?= esc($option) ?>" <?= ($value === $option) ? 'selected' : '' ?>><?= esc($option) ?></option>
                                                    <?php
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>

                                            <?php elseif ($ftype === 'file'): ?>
                                                <?php if (stripos($fname, 'resume') !== false && !empty($application['resume_path'])): ?>
                                                    <div class="current-resume-box">
                                                        <a href="<?= ROOT . $application['resume_path'] ?>" target="_blank" class="btn btn-outline">View Current Resume</a>
                                                    </div>
                                                <?php endif; ?>
                                                <input
                                                    type="file"
                                                    id="field_<?= esc($fname) ?>"
                                                    name="form_files[<?= esc($fname) ?>]"
                                                    class="form-file"
                                                    accept="<?= (stripos($fname, 'resume') !== false) ? '.pdf' : '.pdf,.doc,.docx' ?>"
                                                >

                                            <?php elseif ($ftype === 'checkbox'): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" id="field_<?= esc($fname) ?>" name="form_fields[<?= esc($fname) ?>]" value="1" <?= (strtolower((string)$value) === 'yes') ? 'checked' : '' ?> <?= $required ? 'required' : '' ?>>
                                                    <span><?= esc($field['field_label']) ?></span>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="form-section">
                            <h3 class="section-heading">Application Summary</h3>
                            <textarea name="cover_letter" class="form-textarea" rows="8" placeholder="Update your application summary..."><?= esc($application['cover_letter']) ?></textarea>
                            <div style="margin-top: 0.8rem;">
                                <a href="<?= ROOT . $application['resume_path'] ?>" target="_blank" class="btn btn-outline">View Current Resume</a>
                                <input type="file" name="resume" class="form-file" accept=".pdf" style="margin-top: 0.8rem;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-section">
                        <div class="submission-info">
                            <span>Info:</span>
                            <p style="margin:0;">Only submit when you are satisfied with the updated details.</p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="<?= ROOT ?>/applicant/applications" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Update Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editApplicationForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.textContent = 'Updating...';
        });
    </script>
</body>
</html>
