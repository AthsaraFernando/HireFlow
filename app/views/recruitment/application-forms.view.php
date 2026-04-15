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
                    <a href="<?= ROOT ?>/recruitment/notifications" class="nav-link">
                        <span class="nav-text">Notifications</span>
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
                <h1 class="page-title">Application Forms</h1>
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

                <!-- Page Description -->
                <div class="page-intro">
                    <p class="intro-text">Create and manage custom application forms for job posts</p>
                        </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?= $stats['available_jobs'] ?></h3>
                            <p class="stat-label">Available Jobs</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?= $stats['total_forms'] ?></h3>
                            <p class="stat-label">Total Forms Created</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?= $stats['active_forms'] ?></h3>
                            <p class="stat-label">Active Forms</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon orange">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?= $stats['draft_forms'] ?></h3>
                            <p class="stat-label">Draft Forms</p>
                        </div>
                    </div>
                </div>

                <!-- View Toggle Tabs -->
                <div class="tabs-container">
                    <button class="tab-button active" data-tab="available-jobs">
                Available Job Posts (<?= $stats['available_jobs'] ?>)
            </button>
                    <button class="tab-button" data-tab="created-forms">
                Created Forms (<?= $stats['total_forms'] ?>)
            </button>
                </div>

                <!-- Available Job Posts Section -->
                <div class="tab-content active" id="available-jobs">
                    <div class="section-header">
                        <h2 class="section-title">Available Job Posts</h2>
                    </div>

            <?php if (empty($available_jobs)): ?>
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h3>No Available Job Posts</h3>
                    <p>All open job posts already have application forms created, or there are no open positions.</p>
                        </div>
            <?php else: ?>
                <div class="jobs-grid">
                    <?php foreach ($available_jobs as $job): ?>
                        <?php
                            $jobTitle = trim((string)($job['title'] ?? ''));
                            $employmentTypeRaw = trim((string)($job['employment_type'] ?? ''));
                            $locationText = trim((string)($job['location'] ?? ''));
                            $departmentText = trim((string)($job['department'] ?? ''));
                            $salaryText = trim((string)($job['salary_range'] ?? ''));
                            $descriptionText = trim(strip_tags((string)($job['description'] ?? '')));

                            $employmentType = $employmentTypeRaw !== '' ? $employmentTypeRaw : 'Not specified';
                            $employmentBadgeClass = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $employmentTypeRaw !== '' ? $employmentTypeRaw : 'not-specified'));
                            $jobTitle = $jobTitle !== '' ? $jobTitle : 'Untitled job post';
                            $locationText = $locationText !== '' ? $locationText : 'Location not specified';
                            $departmentText = $departmentText !== '' ? $departmentText : 'Department not specified';
                            $salaryText = $salaryText !== '' ? $salaryText : 'Salary not specified';
                            $descriptionPreview = $descriptionText !== '' ? mb_substr($descriptionText, 0, 150) : 'No job description available for this post yet.';
                        ?>
                        <div class="job-card">
                            <div class="job-card-header">
                                <h3 class="job-title\"><?= esc($jobTitle) ?></h3>
                                <span class="badge badge-<?= esc($employmentBadgeClass) ?>">
                                    <?= esc($employmentType) ?>
                                </span>
                            </div>
                            
                            <div class="job-details">
                                <div class="detail-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <span><?= esc($locationText) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                    <span><?= esc($departmentText) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                    <span><?= esc($salaryText) ?></span>
                                </div>
                                
                                <?php if (!empty($job['deadline'])): ?>
                                <div class="detail-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span>Deadline: <?= date('M d, Y', strtotime($job['deadline'])) ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="job-description">
                                <?= esc($descriptionPreview) ?>
                                <?= mb_strlen($descriptionText) > 150 ? '...' : '' ?>
                            </div>
                            
                            <div class="job-card-footer">
                                <span class="job-meta">Posted: <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                                <a href="<?= ROOT ?>/recruitment/applicationforms/create/<?= $job['id'] ?>" class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Create Form
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                        </div>
            <?php endif; ?>
                </div>

        <!-- Created Forms Section -->
                <div class="tab-content" id="created-forms">
                    <div class="section-header">
                        <h2 class="section-title">Created Application Forms</h2>
                    </div>

                    <!-- Search and Filter Bar -->
                    <div class="filter-bar">
                        <form method="GET" action="<?= ROOT ?>/recruitment/applicationforms" class="search-form" id="searchForm">
                            <input type="hidden" name="tab" id="currentTab" value="created-forms">
                            <div class="search-group">
                                <input type="text" 
                                       name="search" 
                                       class="search-input" 
                                       placeholder="Search by form title or job post..." 
                                       value="<?= esc($search ?? '') ?>">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                    Search
                                </button>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Filter by Status:</label>
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    <option value="all" <?= ($status_filter ?? 'all') === 'all' ? 'selected' : '' ?>>All Forms</option>
                                    <option value="active" <?= ($status_filter ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($status_filter ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="draft" <?= ($status_filter ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="deleted" <?= ($status_filter ?? '') === 'deleted' ? 'selected' : '' ?>>Deleted</option>
                                </select>
                            </div>
                        </form>
                    </div>

            <?php if (empty($created_forms)): ?>
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <h3>No Forms Found</h3>
                    <p><?= !empty($search) ? 'No forms match your search criteria.' : 'Start by creating application forms for available job posts.' ?></p>
                        </div>
            <?php else: ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Form Title</th>
                                <th>Job Post</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Fields</th>
                                <th>Submissions</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($created_forms as $form): ?>
                                <tr class="<?= $form['is_deleted'] ? 'deleted-row' : '' ?>">
                                    <td>
                                        <strong><?= esc($form['form_title'] ?? 'Untitled Form') ?></strong>
                                        <?php if ($form['is_deleted']): ?>
                                            <span class="badge badge-deleted">Deleted</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($form['job_title'] ?? 'N/A') ?></td>
                                    <td><?= esc($form['department'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge badge-<?= $form['status'] ?>">
                                            <?= ucfirst($form['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?= $form['total_fields'] ?? 0 ?></td>
                                    <td class="text-center"><?= $form['submission_count'] ?? 0 ?></td>
                                    <td><?= date('M d, Y', strtotime($form['created_at'])) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <?php if ($form['is_deleted']): ?>
                                                <!-- Restore button for deleted forms -->
                                                <a href="<?= ROOT ?>/recruitment/applicationforms/restore/<?= $form['id'] ?>" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Restore"
                                                   onclick="return confirm('Are you sure you want to restore this form?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="23 4 23 10 17 10"></polyline>
                                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                                    </svg>
                                                    Restore
                                                </a>
                                            <?php else: ?>
                                                <!-- Normal action buttons for active forms -->
                                                <a href="<?= ROOT ?>/recruitment/applicationforms/preview/<?= $form['id'] ?>" class="btn btn-sm btn-secondary" title="Preview">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <a href="<?= ROOT ?>/recruitment/applicationforms/edit/<?= $form['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                </a>
                                                <a href="<?= ROOT ?>/recruitment/applicationforms/toggleStatus/<?= $form['id'] ?>" 
                                                   class="btn btn-sm <?= $form['status'] === 'active' ? 'btn-warning' : 'btn-primary' ?>" 
                                                   title="<?= $form['status'] === 'active' ? 'Set Inactive' : 'Set Active' ?>"
                                                   onclick="return confirm('Change form status to <?= $form['status'] === 'active' ? 'inactive' : 'active' ?>?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                                    </svg>
                                                </a>
                                                <button onclick="deleteForm(<?= $form['id'] ?>, '<?= esc($form['form_title']) ?>')" class="btn btn-sm btn-danger" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
            </div>
        </div>
    </div>

    <style>
        /* Page Intro */
        .page-intro {
            margin-bottom: 2rem;
        }

        .intro-text {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        /* Tab Styles */
        .tabs-container {
            display: flex;
            gap: 1rem;
            margin: 2rem 0 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .tab-button {
            padding: 1rem 2rem;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .tab-button:hover {
            color: #3b82f6;
            background: #f3f4f6;
        }

        .tab-button.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Job Cards */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .job-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .job-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .job-card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .job-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            flex: 1;
        }

        .job-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .detail-item svg {
            flex-shrink: 0;
        }

        .job-description {
            color: #4b5563;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .job-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .job-meta {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .empty-state svg {
            margin: 0 auto 1rem;
            color: #d1d5db;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
        }

        /* Section Header */
        .section-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        /* Badge Colors */
        .badge-full-time { background: #dbeafe; color: #1e40af; }
        .badge-part-time { background: #fef3c7; color: #92400e; }
        .badge-contract { background: #e0e7ff; color: #3730a3; }
        .badge-internship { background: #fce7f3; color: #831843; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-draft { background: #f3f4f6; color: #4b5563; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        .badge-deleted { background: #fef2f2; color: #991b1b; font-size: 0.75rem; padding: 0.25rem 0.5rem; margin-left: 0.5rem; }

        /* Search and Filter Bar */
        .filter-bar {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-group {
            display: flex;
            gap: 0.5rem;
            flex: 1;
            min-width: 300px;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .filter-label {
            font-size: 0.95rem;
            color: #4b5563;
            font-weight: 500;
            white-space: nowrap;
            margin: 0;
        }

        .status-select {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            background: white;
            cursor: pointer;
            min-width: 150px;
        }

        .status-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Deleted Row Style */
        .deleted-row {
            background: #fef2f2;
            opacity: 0.7;
        }

        .deleted-row td {
            color: #6b7280;
        }
    </style>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');
        });

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and contents
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
                
                // Update hidden field to remember tab state
                document.getElementById('currentTab').value = tabId;
            });
        });

        // Maintain tab state after search/filter
        window.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const hasSearch = urlParams.has('search') || urlParams.has('status_filter');
            const currentTab = urlParams.get('tab') || 'created-forms';
            
            if (hasSearch && currentTab) {
                // Remove active from all
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Activate the correct tab
                const tabButton = document.querySelector(`[data-tab="${currentTab}"]`);
                const tabContent = document.getElementById(currentTab);
                
                if (tabButton && tabContent) {
                    tabButton.classList.add('active');
                    tabContent.classList.add('active');
                }
            }
        });

        // Delete form confirmation
        function deleteForm(formId, formTitle) {
            if (confirm(`Are you sure you want to delete the form "${formTitle}"?\n\nThis action cannot be undone and will delete all associated data including submissions.`)) {
                window.location.href = `<?= ROOT ?>/recruitment/applicationforms/delete/${formId}`;
            }
        }

        // Auto-hide alerts after 5 seconds
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
