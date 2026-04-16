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
                    <a href="<?= ROOT ?>/recruitment/applicationforms" class="nav-link active">
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
                    <a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/recruitment/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
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
                <h1 class="page-title">Application Form Preview</h1>
            </div>

            <div class="header-right">
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name"><?= esc($_SESSION['USER']['full_name'] ?? 'Recruitment Manager') ?></span>
                        <span class="user-role">Recruitment Manager</span>
                    </div>
                    <div class="user-avatar"></div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="page-intro">
                    <a href="<?= ROOT ?>/recruitment/applicationforms" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Application Forms
                    </a>
                    <div class="page-header-row">
                        <p class="intro-text">This is how applicants will see the form</p>
                        <span class="badge badge-<?= $form['status'] ?>">
                            <?= ucfirst($form['status']) ?>
                        </span>
                    </div>
                </div>

                <!-- Notifications -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']) ?>
                    </div>
                <?php endif; ?>

                <!-- Form Preview Container -->
                <div class="form-preview-container">
            <!-- Form Header -->
            <div class="form-header">
                <h2 class="form-title"><?= esc($form['form_title']) ?></h2>
                <p class="form-description"><?= esc($form['form_description']) ?></p>
            </div>

            <!-- Job Details Section (Auto-filled) -->
            <div class="form-section">
                <h3 class="section-heading">Job Details</h3>
                <p class="section-subheading">Information about the position you're applying for</p>
                
                <div class="job-details-grid">
                    <div class="detail-box">
                        <label class="detail-label">Job Title</label>
                        <div class="detail-value"><?= esc($form['job_title']) ?></div>
                    </div>
                    <div class="detail-box">
                        <label class="detail-label">Department</label>
                        <div class="detail-value"><?= esc($form['department']) ?></div>
                    </div>
                    <div class="detail-box">
                        <label class="detail-label">Location</label>
                        <div class="detail-value"><?= esc($form['location']) ?></div>
                    </div>
                    <div class="detail-box">
                        <label class="detail-label">Employment Type</label>
                        <div class="detail-value"><?= esc($form['employment_type']) ?></div>
                    </div>
                    <?php if (!empty($form['salary_range'])): ?>
                    <div class="detail-box">
                        <label class="detail-label">Salary Range</label>
                        <div class="detail-value"><?= esc($form['salary_range']) ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($form['deadline'])): ?>
                    <div class="detail-box">
                        <label class="detail-label">Application Deadline</label>
                        <div class="detail-value"><?= date('F d, Y', strtotime($form['deadline'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Fields by Category -->
            <?php foreach ($grouped_fields as $category => $fields): ?>
                <div class="form-section">
                    <h3 class="section-heading"><?= esc($category_labels[$category] ?? ucfirst(str_replace('_', ' ', $category))) ?></h3>
                    
                    <div class="fields-container">
                        <?php foreach ($fields as $field): ?>
                            <div class="form-field <?= $field['field_type'] === 'textarea' ? 'full-width' : '' ?>">
                                <label class="field-label">
                                    <?= esc($field['field_label']) ?>
                                    <?php if ($field['is_required']): ?>
                                        <span class="required-mark">*</span>
                                    <?php endif; ?>
                                </label>
                                
                                <?php if ($field['help_text']): ?>
                                    <p class="field-help"><?= esc($field['help_text']) ?></p>
                                <?php endif; ?>
                                
                                <?php if ($field['field_type'] === 'text' || $field['field_type'] === 'email' || $field['field_type'] === 'tel' || $field['field_type'] === 'url'): ?>
                                    <input type="<?= $field['field_type'] ?>" 
                                           class="form-input" 
                                           placeholder="<?= esc($field['placeholder'] ?? '') ?>"
                                           <?= $field['is_required'] ? 'required' : '' ?>>
                                           
                                <?php elseif ($field['field_type'] === 'date'): ?>
                                    <input type="date" 
                                           class="form-input"
                                           <?= $field['is_required'] ? 'required' : '' ?>>
                                           
                                <?php elseif ($field['field_type'] === 'textarea'): ?>
                                    <textarea class="form-textarea" 
                                              rows="4" 
                                              placeholder="<?= esc($field['placeholder'] ?? '') ?>"
                                              <?= $field['is_required'] ? 'required' : '' ?>></textarea>
                                              
                                <?php elseif ($field['field_type'] === 'select'): ?>
                                    <select class="form-select" <?= $field['is_required'] ? 'required' : '' ?>>
                                        <option value="">-- Select --</option>
                                        <?php 
                                        $options = json_decode($field['field_options']);
                                        if ($options && is_array($options)):
                                            foreach ($options as $option): 
                                        ?>
                                            <option value="<?= esc($option) ?>"><?= esc($option) ?></option>
                                        <?php 
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    
                                <?php elseif ($field['field_type'] === 'file'): ?>
                                    <input type="file" 
                                           class="form-file" 
                                           accept="<?= isset($field['field_options']) ? json_decode($field['field_options'])->accept ?? '.pdf,.doc,.docx' : '.pdf,.doc,.docx' ?>"
                                           <?= $field['is_required'] ? 'required' : '' ?>>
                                           
                                <?php elseif ($field['field_type'] === 'checkbox'): ?>
                                    <label class="checkbox-label">
                                        <input type="checkbox" 
                                               <?= $field['is_required'] ? 'required' : '' ?>>
                                        <span><?= esc($field['field_label']) ?></span>
                                    </label>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Submission Info -->
            <div class="form-section">
                <div class="submission-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <p>Your application will be automatically dated upon submission.</p>
                </div>
            </div>

            <!-- Submit Button (Disabled in preview) -->
            <div class="form-actions">
                <button type="button" class="btn btn-primary btn-large" disabled>
                    Submit Application (Preview Mode)
                </button>
            </div>

            <!-- Form Stats -->
            <div class="form-stats">
                <div class="stat-item">
                    <span class="stat-label">Total Fields:</span>
                    <span class="stat-value"><?= count($form['fields']) ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Required Fields:</span>
                    <span class="stat-value"><?= count(array_filter($form['fields'], function($f) { return $f['is_required']; })) ?></span>
                </div>
            </div>
        </div>

                <!-- Action Buttons -->
                <div class="action-bar" style="margin-top: 2rem;">
                    <div class="action-group">
                        <a href="<?= ROOT ?>/recruitment/applicationforms/edit/<?= $form['id'] ?>" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit Form
                        </a>
                        
                        <?php if ($form['status'] === 'draft'): ?>
                            <a href="<?= ROOT ?>/recruitment/applicationforms/publish/<?= $form['id'] ?>" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5l7 7-7 7"></path>
                                </svg>
                                Publish Form
                            </a>
                        <?php endif; ?>
                        
                        <button onclick="deleteForm(<?= $form['id'] ?>, '<?= esc($form['form_title']) ?>')" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            Delete Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-intro {
            margin-bottom: 1.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #3b82f6;
        }

        .page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .intro-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        .action-bar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        }

        .action-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .form-preview-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 1rem 0;
        }

        .form-description {
            font-size: 1.125rem;
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
        }

        .form-section {
            margin-bottom: 3rem;
        }

        .section-heading {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
        }

        .section-subheading {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0 0 1.5rem 0;
        }

        .job-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .detail-box {
            padding: 1rem;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .detail-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 500;
            color: #1f2937;
        }

        .fields-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .form-field {
            display: flex;
            flex-direction: column;
        }

        .form-field.full-width {
            grid-column: 1 / -1;
        }

        .field-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .required-mark {
            color: #ef4444;
            font-weight: 700;
        }

        .field-help {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0 0 0.5rem 0;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-file {
            padding: 0.75rem;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            cursor: pointer;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .submission-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            color: #1e40af;
        }

        .submission-info svg {
            flex-shrink: 0;
        }

        .submission-info p {
            margin: 0;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-large {
            padding: 1rem 3rem;
            font-size: 1.125rem;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .form-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            text-align: center;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-draft { background: #fef3c7; color: #92400e; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
    </style>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        function deleteForm(formId, formTitle) {
            if (confirm(`Are you sure you want to deactivate "${formTitle}"?\n\nThe form will be set to inactive and will no longer be visible. This action can be reversed by contacting an administrator.`)) {
                window.location.href = `<?= ROOT ?>/recruitment/applicationforms/delete/${formId}`;
            }
        }

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
