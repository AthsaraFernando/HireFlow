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
                    <a href="<?= ROOT ?>/recruitment/profile" class="nav-link">
                        <span class="nav-text">Profile</span>
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
                <h1 class="page-title">Create Application Form</h1>
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
                    <p class="intro-text">Select fields to include in the application form for this job post</p>
                </div>

                <!-- Job Post Details Card -->
                <div class="job-info-card">
                    <h2 class="card-title">Job Post Details</h2>
                    <div class="job-info-grid">
                        <div class="info-item">
                            <span class="info-label">Job Title:</span>
                            <span class="info-value"><?= esc($job['title']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Department:</span>
                            <span class="info-value"><?= esc($job['department']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Location:</span>
                            <span class="info-value"><?= esc($job['location']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Employment Type:</span>
                            <span class="info-value"><?= esc($job['employment_type']) ?></span>
                        </div>
                        <?php if (!empty($job['salary_range'])): ?>
                        <div class="info-item">
                            <span class="info-label">Salary Range:</span>
                            <span class="info-value"><?= esc($job['salary_range']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($job['deadline'])): ?>
                        <div class="info-item">
                            <span class="info-label">Deadline:</span>
                            <span class="info-value"><?= date('F d, Y', strtotime($job['deadline'])) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Builder -->
                <form method="POST" action="<?= ROOT ?>/recruitment/applicationforms/store" id="formBuilderForm">
                    <input type="hidden" name="job_post_id" value="<?= $job['id'] ?>">
                    
                    <!-- Form Title and Description -->
                    <div class="form-section">
                        <h3 class="section-title">Form Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="form_title">Form Title <span class="required">*</span></label>
                                <input type="text" id="form_title" name="form_title" class="form-control" 
                                       value="Application Form - <?= esc($job['title']) ?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="form_description">Form Description</label>
                                <textarea id="form_description" name="form_description" class="form-control" rows="3">Please fill out this application form for the position of <?= esc($job['title']) ?>. Ensure all required fields are completed accurately.</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Field Selection -->
                    <div class="form-section">
                        <h3 class="section-title">Select Form Fields</h3>
                        <p class="section-description">Choose which fields applicants should fill in this application form. Required fields are automatically selected.</p>

                        <?php foreach ($available_fields as $category => $category_data): ?>
                            <div class="field-category">
                                <div class="category-header">
                                    <h4 class="category-title"><?= esc($category_data['category_label']) ?></h4>
                                    <?php if (isset($category_data['description'])): ?>
                                        <p class="category-description"><?= esc($category_data['description']) ?></p>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-outline select-all-btn" data-category="<?= $category ?>">
                                        Select All
                                    </button>
                                </div>
                                
                                <div class="fields-grid">
                                    <?php foreach ($category_data['fields'] as $field): ?>
                                        <div class="field-checkbox-item">
                                            <input type="checkbox" 
                                                   id="field_<?= $category ?>_<?= $field['name'] ?>" 
                                                   name="fields[<?= $category ?>][]" 
                                                   value="<?= $field['name'] ?>"
                                                   <?= $field['required'] ? 'checked required' : '' ?>
                                                   <?= $field['required'] ? 'disabled' : '' ?>>
                                            <?php if ($field['required']): ?>
                                                <!-- Hidden input for required fields since disabled fields don't submit -->
                                                <input type="hidden" name="fields[<?= $category ?>][]" value="<?= $field['name'] ?>">
                                            <?php endif; ?>
                                            <label for="field_<?= $category ?>_<?= $field['name'] ?>" class="field-label">
                                                <div class="field-info">
                                                    <span class="field-name"><?= esc($field['label']) ?></span>
                                                    <?php if ($field['required']): ?>
                                                        <span class="badge badge-required">Required</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (isset($field['help_text'])): ?>
                                                    <span class="field-help-text"><?= esc($field['help_text']) ?></span>
                                                <?php endif; ?>
                                                <span class="field-type-badge"><?= ucfirst($field['type']) ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="<?= ROOT ?>/recruitment/applicationforms" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Create Application Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Page Layout */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #3b82f6;
            text-decoration: none;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #2563eb;
        }

        .back-link svg {
            flex-shrink: 0;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            transition: color 0.2s ease;
        }

        .back-button:hover {
            color: #3b82f6;
        }

        .job-info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 1rem 0;
            color: #1f2937;
        }

        .job-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 500;
        }

        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            color: #1f2937;
        }

        .section-description {
            color: #6b7280;
            margin: 0 0 1.5rem 0;
        }

        .form-row {
            margin-bottom: 1.5rem;
        }

        .form-group {
            width: 100%;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .field-category {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .field-category:last-child {
            border-bottom: none;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .category-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            flex: 1;
        }

        .category-description {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0.25rem 0 0 0;
            flex-basis: 100%;
        }

        .select-all-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .fields-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }

        .field-checkbox-item {
            display: flex;
            align-items: start;
            gap: 0.75rem;
            padding: 1rem;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .field-checkbox-item:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .field-checkbox-item input[type="checkbox"] {
            margin-top: 0.25rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .field-checkbox-item input[type="checkbox"]:checked + .field-label {
            color: #1f2937;
        }

        .field-checkbox-item input[type="checkbox"]:disabled {
            cursor: not-allowed;
        }

        .field-label {
            flex: 1;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .field-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .field-name {
            font-weight: 500;
            color: #374151;
        }

        .field-help-text {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .field-type-badge {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            background: #e0e7ff;
            color: #3730a3;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-required {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #d1d5db;
            color: #4b5563;
        }

        .btn-outline:hover {
            background: #f9fafb;
        }
    </style>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        // Select all buttons
        document.querySelectorAll('.select-all-btn').forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                const checkboxes = document.querySelectorAll(`input[name="fields[${category}][]"]:not(:disabled)`);
                
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });
                
                this.textContent = allChecked ? 'Select All' : 'Deselect All';
            });
        });

        // Form validation
        document.getElementById('formBuilderForm').addEventListener('submit', function(e) {
            const checkedFields = document.querySelectorAll('input[name^="fields["]:checked').length;
            
            if (checkedFields === 0) {
                e.preventDefault();
                alert('Please select at least one field for the application form.');
                return false;
            }
        });
    </script>
</body>
</html>
