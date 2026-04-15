<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Recruitment Manager</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/applicationforms" class="nav-link"><span class="nav-text">Application Forms</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/applications" class="nav-link active"><span class="nav-text">Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link"><span class="nav-text">Shortlist</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link"><span class="nav-text">Interviews</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/reports" class="nav-link"><span class="nav-text">Reports</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/notifications" class="nav-link"><span class="nav-text">Notifications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/profile" class="nav-link"><span class="nav-text">My Profile</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn"><span>Logout</span></a>
        </div>
    </div>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle"><</button>
                <h1 class="page-title">Applications</h1>
            </div>

            <div class="header-right">
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name"><?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">Recruitment Manager</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="applications-page">
                <div class="applications-toolbar">
                    <div class="filters-card">
                        <form method="GET" action="<?= ROOT ?>/recruitment/applications" class="filters-form">
                            <div class="filter-group">
                                <label for="status-filter" class="filter-label">Status</label>
                                <select id="status-filter" name="status" class="filter-select">
                                    <option value="all" <?= ($selected_status ?? 'all') === 'all' ? 'selected' : '' ?>>All Statuses</option>
                                    <?php foreach (($status_filters ?? []) as $statusFilter): ?>
                                        <option value="<?= htmlspecialchars($statusFilter) ?>" <?= ($selected_status ?? 'all') === $statusFilter ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($statusFilter) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-group search-group">
                                <label for="search" class="filter-label">Applicant Name</label>
                                <input
                                    id="search"
                                    name="search"
                                    type="text"
                                    class="search-input"
                                    placeholder="Search by name"
                                    value="<?= htmlspecialchars($search_name ?? '') ?>">
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">Apply</button>
                                <a href="<?= ROOT ?>/recruitment/applications" class="btn btn-outline">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="application-count">Total: <?= count($applications ?? []) ?></div>
                </div>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (empty($applications)): ?>
                    <div class="empty-state">
                        <h3>No applications found</h3>
                        <p>There are no applications for the selected criteria.</p>
                    </div>
                <?php else: ?>
                    <div class="application-list">
                        <?php foreach ($applications as $application): ?>
                            <?php
                                $statusClass = strtolower(str_replace([' ', '_'], '-', $application['status'] ?? 'applied'));
                                $safeFormData = htmlspecialchars($application['form_data'] ?? '', ENT_QUOTES, 'UTF-8');
                            ?>
                            <article class="application-card">
                                <div class="application-main">
                                    <h3 class="applicant-name"><?= htmlspecialchars($application['applicant_name'] ?? 'Unknown Applicant') ?></h3>

                                    <div class="detail-grid">
                                        <div><strong>Email:</strong> <?= htmlspecialchars($application['applicant_email'] ?? '-') ?></div>
                                        <div><strong>Contact No:</strong> <?= htmlspecialchars($application['applicant_phone'] ?? '-') ?></div>
                                        <div><strong>Applied Job:</strong> <?= htmlspecialchars($application['job_title'] ?? '-') ?></div>
                                        <div><strong>Date Applied:</strong> <?= !empty($application['applied_at']) ? date('M j, Y g:i A', strtotime($application['applied_at'])) : '-' ?></div>
                                    </div>

                                    <div class="status-line">
                                        <span class="status-label">Current Status:</span>
                                        <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($application['status'] ?? 'Applied') ?></span>
                                    </div>
                                </div>

                                <div class="application-actions">
                                    <button
                                        type="button"
                                        class="btn btn-outline"
                                        data-applicant-name="<?= htmlspecialchars($application['applicant_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-applicant-email="<?= htmlspecialchars($application['applicant_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-applicant-phone="<?= htmlspecialchars($application['applicant_phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-job-title="<?= htmlspecialchars($application['job_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-applied-at="<?= !empty($application['applied_at']) ? htmlspecialchars(date('M j, Y g:i A', strtotime($application['applied_at'])), ENT_QUOTES, 'UTF-8') : '-' ?>"
                                        data-form='<?= $safeFormData ?>'
                                        onclick="openApplicationModal(this)">
                                        View Application
                                    </button>

                                    <form method="POST" action="<?= ROOT ?>/recruitment/applications" class="status-form">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                        <input type="hidden" name="application_id" value="<?= (int)$application['id'] ?>">
                                        <label for="status-<?= (int)$application['id'] ?>">Update Status</label>
                                        <select id="status-<?= (int)$application['id'] ?>" name="status" required>
                                            <option value="">Select status</option>
                                            <?php foreach (($status_update_options ?? []) as $statusOption): ?>
                                                <option value="<?= htmlspecialchars($statusOption) ?>" <?= ($application['status'] ?? '') === $statusOption ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($statusOption) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="application-modal" class="modal-overlay" aria-hidden="true">
        <div class="modal-container" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-header">
                <h3 id="modal-title">Submitted Application</h3>
                <button type="button" class="modal-close" onclick="closeApplicationModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="modal-subtitle" class="modal-subtitle"></div>
                <div id="modal-content" class="modal-content"></div>
            </div>
        </div>
    </div>

    <style>
        .applications-page { padding: 20px; }
        .applications-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .filters-card {
            width: min(860px, 100%);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            display: grid;
            gap: 10px;
        }
        .filters-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(180px, 1fr)) auto;
            gap: 10px;
            align-items: end;
            width: 100%;
        }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .search-group { min-width: 220px; }
        .filter-label { font-size: 14px; font-weight: 600; }
        .filter-select, .search-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }
        .filter-actions { display: flex; gap: 8px; }
        .application-count { font-weight: 600; }

        .alert { padding: 12px; border-radius: 8px; margin-bottom: 14px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        .application-list { display: grid; gap: 14px; }
        .application-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
        }
        .applicant-name { margin: 0 0 12px; font-size: 20px; }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 8px 18px;
        }
        .status-line { margin-top: 12px; display: flex; align-items: center; gap: 8px; }
        .status-label { font-weight: 600; }
        .status-badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 13px;
            border: 1px solid transparent;
        }
        .status-badge.applied { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        .status-badge.under-review { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        .status-badge.shortlisted { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .status-badge.rejected { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        .status-badge.offered { background: #f0f9ff; color: #075985; border-color: #bae6fd; }

        .application-actions { display: flex; flex-direction: column; gap: 10px; min-width: 230px; }
        .status-form { display: flex; flex-direction: column; gap: 8px; }
        .status-form select { padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; }

        .empty-state {
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 24px;
            text-align: center;
            background: #f8fafc;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1200;
            padding: 16px;
        }
        .modal-overlay.active { display: flex; }
        .modal-container {
            background: #fff;
            width: min(760px, 100%);
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            max-height: 82vh;
            overflow: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .modal-close {
            border: 0;
            background: transparent;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
        }
        .modal-body { padding: 16px; }
        .modal-subtitle {
            display: grid;
            grid-template-columns: repeat(2, minmax(180px, 1fr));
            gap: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 14px;
        }
        .meta-item { display: flex; flex-direction: column; gap: 3px; }
        .meta-label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.04em; }
        .meta-value { font-size: 14px; color: #0f172a; word-break: break-word; }

        .form-preview {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            padding: 14px;
            display: grid;
            gap: 14px;
        }
        .form-section {
            border: 1px solid #f1f5f9;
            border-radius: 8px;
            padding: 12px;
            background: #fcfdff;
        }
        .form-section-title {
            margin: 0 0 10px;
            font-size: 14px;
            color: #1e293b;
            font-weight: 700;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(200px, 1fr));
            gap: 10px;
        }
        .form-field {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            background: #fff;
        }
        .field-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
            text-transform: capitalize;
        }
        .field-value {
            color: #0f172a;
            font-size: 14px;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .full-width { grid-column: 1 / -1; }
        .empty-form-msg { margin: 0; color: #475569; }

        @media (max-width: 900px) {
            .filters-form {
                grid-template-columns: 1fr;
                width: 100%;
            }
            .filters-card { width: 100%; }
            .filter-actions { justify-content: flex-start; }
            .application-card { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; }
            .application-actions { min-width: 0; }
            .filter-select, .search-input { width: 100%; }
            .modal-subtitle { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>

    <script>
        const modal = document.getElementById('application-modal');
        const modalContent = document.getElementById('modal-content');
        const modalSubtitle = document.getElementById('modal-subtitle');

        function toTitleCase(rawKey) {
            return String(rawKey)
                .replace(/[_-]+/g, ' ')
                .replace(/\s+/g, ' ')
                .trim()
                .replace(/\b\w/g, function(char) { return char.toUpperCase(); });
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(char) { return map[char]; });
        }

        function renderPrimitive(value) {
            if (value === null || value === undefined || value === '') {
                return '-';
            }
            if (typeof value === 'boolean') {
                return value ? 'Yes' : 'No';
            }
            return escapeHtml(String(value));
        }

        function renderField(label, value, fullWidth) {
            return '<div class="form-field ' + (fullWidth ? 'full-width' : '') + '">' +
                '<div class="field-label">' + escapeHtml(toTitleCase(label)) + '</div>' +
                '<div class="field-value">' + value + '</div>' +
            '</div>';
        }

        function renderObjectSection(title, obj) {
            const keys = Object.keys(obj || {});
            if (keys.length === 0) {
                return '';
            }

            let sectionHtml = '<section class="form-section">';
            sectionHtml += '<h4 class="form-section-title">' + escapeHtml(toTitleCase(title)) + '</h4>';
            sectionHtml += '<div class="form-grid">';

            keys.forEach(function(key) {
                const value = obj[key];
                if (Array.isArray(value)) {
                    const content = value.length ? value.map(function(item) {
                        if (typeof item === 'object' && item !== null) {
                            return JSON.stringify(item);
                        }
                        return String(item);
                    }).join(', ') : '-';
                    sectionHtml += renderField(key, escapeHtml(content), true);
                    return;
                }

                if (typeof value === 'object' && value !== null) {
                    sectionHtml += renderField(key, escapeHtml(JSON.stringify(value, null, 2)), true);
                    return;
                }

                const longText = String(value).length > 80;
                sectionHtml += renderField(key, renderPrimitive(value), longText);
            });

            sectionHtml += '</div></section>';
            return sectionHtml;
        }

        function renderJsonHtml(data) {
            if (data === null || data === undefined || data === '') {
                return '<div class="form-preview"><p class="empty-form-msg">No submitted form data available for this application.</p></div>';
            }

            if (typeof data !== 'object') {
                return '<div class="form-preview">' + renderField('Submitted Data', escapeHtml(data), true) + '</div>';
            }

            let html = '<div class="form-preview">';
            const topLevelFields = {};
            const nestedSections = [];

            Object.keys(data).forEach(function(key) {
                const value = data[key];
                if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
                    nestedSections.push({ key: key, value: value });
                } else {
                    topLevelFields[key] = value;
                }
            });

            if (Object.keys(topLevelFields).length > 0) {
                html += renderObjectSection('Application Details', topLevelFields);
            }

            nestedSections.forEach(function(section) {
                html += renderObjectSection(section.key, section.value);
            });

            if (Object.keys(topLevelFields).length === 0 && nestedSections.length === 0) {
                html += '<p class="empty-form-msg">No submitted form data available for this application.</p>';
            }

            html += '</div>';

            return html;
        }

        function openApplicationModal(button) {
            const applicantName = button.getAttribute('data-applicant-name') || 'Applicant';
            const applicantEmail = button.getAttribute('data-applicant-email') || '-';
            const applicantPhone = button.getAttribute('data-applicant-phone') || '-';
            const jobTitle = button.getAttribute('data-job-title') || '-';
            const appliedAt = button.getAttribute('data-applied-at') || '-';
            const rawFormData = button.getAttribute('data-form');
            let parsedData = null;

            if (rawFormData) {
                try {
                    parsedData = JSON.parse(rawFormData);
                } catch (error) {
                    parsedData = rawFormData;
                }
            }

            modalSubtitle.innerHTML =
                '<div class="meta-item"><span class="meta-label">Applicant</span><span class="meta-value">' + escapeHtml(applicantName) + '</span></div>' +
                '<div class="meta-item"><span class="meta-label">Email</span><span class="meta-value">' + escapeHtml(applicantEmail) + '</span></div>' +
                '<div class="meta-item"><span class="meta-label">Contact No</span><span class="meta-value">' + escapeHtml(applicantPhone) + '</span></div>' +
                '<div class="meta-item"><span class="meta-label">Job Post</span><span class="meta-value">' + escapeHtml(jobTitle) + '</span></div>' +
                '<div class="meta-item full-width"><span class="meta-label">Applied Date</span><span class="meta-value">' + escapeHtml(appliedAt) + '</span></div>';
            modalContent.innerHTML = renderJsonHtml(parsedData);
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeApplicationModal() {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            modalContent.innerHTML = '';
            modalSubtitle.textContent = '';
        }

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeApplicationModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('active')) {
                closeApplicationModal();
            }
        });

        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.main-content').classList.toggle('expanded');

            if (this.textContent.trim() === '>') {
                this.textContent = '<';
            } else {
                this.textContent = '>';
            }
        });
    </script>

<?php $this->view('components/footer') ?>