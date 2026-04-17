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
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/applications" class="nav-link"><span class="nav-text">Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link"><span class="nav-text">Shortlist</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link"><span class="nav-text">Interviews</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/reports" class="nav-link active"><span class="nav-text">Reports</span></a></li>
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
                <h1 class="page-title">Recruitment Reports</h1>
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
            <div class="main-container">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="tabs-container">
                    <a href="<?= ROOT ?>/recruitment/reports?tab=generate" class="tab-button <?= $active_tab === 'generate' ? 'active' : '' ?>">Generate Report</a>
                    <a href="<?= ROOT ?>/recruitment/reports?tab=created" class="tab-button <?= $active_tab === 'created' ? 'active' : '' ?>">Created Reports</a>
                </div>

                <?php if ($active_tab === 'generate'): ?>
                    <div class="content-card" style="padding: 1rem; margin-top: 1rem;">
                        <h3 class="card-title" style="margin-bottom: 1rem;">
                            <?= $mode === 'edit' ? 'Update Report' : ($mode === 'view' ? 'View Report' : 'Generate Recruitment Report') ?>
                        </h3>

                        <form method="GET" action="<?= ROOT ?>/recruitment/reports" class="filters-container">
                            <input type="hidden" name="tab" value="generate">
                            <?php if (!empty($editing_report['id'])): ?>
                                <input type="hidden" name="report_id" value="<?= (int) $editing_report['id'] ?>">
                                <input type="hidden" name="mode" value="<?= htmlspecialchars($mode) ?>">
                            <?php endif; ?>

                            <div class="filter-group">
                                <label for="from_date">From Date</label>
                                <input type="date" id="from_date" name="from_date" class="search-input" value="<?= htmlspecialchars($report_filters['from_date'] ?? '') ?>" required <?= $mode === 'view' ? 'disabled' : '' ?>>
                            </div>

                            <div class="filter-group">
                                <label for="to_date">To Date</label>
                                <input type="date" id="to_date" name="to_date" class="search-input" value="<?= htmlspecialchars($report_filters['to_date'] ?? '') ?>" required <?= $mode === 'view' ? 'disabled' : '' ?>>
                            </div>

                            <div class="filter-group">
                                <label for="report_type">Report Type</label>
                                <select id="report_type" name="report_type" class="filter-select" required <?= $mode === 'view' ? 'disabled' : '' ?>>
                                    <?php foreach ($status_type_labels as $key => $label): ?>
                                        <option value="<?= htmlspecialchars($key) ?>" <?= ($report_filters['report_type'] ?? 'all') === $key ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label for="title">Report Title</label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="search-input"
                                    value="<?= htmlspecialchars($editing_report['title'] ?? '') ?>"
                                    placeholder="Ex: April Shortlisted Applicants"
                                    form="report-save-form"
                                    required
                                    <?= $mode === 'view' ? 'readonly' : '' ?>
                                >
                            </div>

                            <div class="filter-group">
                                <button type="submit" class="btn btn-primary" <?= $mode === 'view' ? 'disabled' : '' ?>>Preview</button>
                            </div>
                        </form>

                        <?php if (!empty($report_filters['from_date']) && !empty($report_filters['to_date'])): ?>
                            <div class="summary-section" style="margin-top: 1rem;">
                                <?php if (($report_filters['report_type'] ?? 'all') === 'all'): ?>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['total_applications'] ?? 0) ?></div><div class="summary-label">Total Applications</div></div>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['applied_count'] ?? 0) ?></div><div class="summary-label">Applied</div></div>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['shortlisted_count'] ?? 0) ?></div><div class="summary-label">Shortlisted</div></div>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['interview_scheduled_count'] ?? 0) ?></div><div class="summary-label">Interview Scheduled</div></div>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['offered_count'] ?? 0) ?></div><div class="summary-label">Offered</div></div>
                                    <div class="summary-card"><div class="summary-value"><?= (int) ($summary_counts['rejected_count'] ?? 0) ?></div><div class="summary-label">Rejected</div></div>
                                <?php else: ?>
                                    <div class="summary-card info">
                                        <div class="summary-value"><?= (int) $type_count ?></div>
                                        <div class="summary-label"><?= htmlspecialchars($status_type_labels[$report_filters['report_type']] ?? 'Selected Type') ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <form
                                id="report-save-form"
                                method="POST"
                                action="<?= $mode === 'edit' && !empty($editing_report['id']) ? ROOT . '/recruitment/reports/update/' . (int) $editing_report['id'] : ROOT . '/recruitment/reports/create' ?>"
                                style="margin-top: 1rem;"
                            >
                                <input type="hidden" name="from_date" value="<?= htmlspecialchars($report_filters['from_date'] ?? '') ?>">
                                <input type="hidden" name="to_date" value="<?= htmlspecialchars($report_filters['to_date'] ?? '') ?>">
                                <input type="hidden" name="report_type" value="<?= htmlspecialchars($report_filters['report_type'] ?? 'all') ?>">

                                <div class="table-responsive" style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:10px;">
                                    <table class="table" style="width:100%; border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="padding:0.75rem; text-align:left; width:50px;">Select</th>
                                                <th style="padding:0.75rem; text-align:left;">Name</th>
                                                <th style="padding:0.75rem; text-align:left;">Email</th>
                                                <th style="padding:0.75rem; text-align:left;">Mobile</th>
                                                <th style="padding:0.75rem; text-align:left;">Job Post Applied</th>
                                                <th style="padding:0.75rem; text-align:left;">Status</th>
                                                <th style="padding:0.75rem; text-align:left;">Applied Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($preview_applicants)): ?>
                                                <?php foreach ($preview_applicants as $row): ?>
                                                    <?php $checked = in_array((int) $row['application_id'], $selected_application_ids, true); ?>
                                                    <tr>
                                                        <td style="padding:0.75rem;">
                                                            <input
                                                                type="checkbox"
                                                                name="selected_applications[]"
                                                                value="<?= (int) $row['application_id'] ?>"
                                                                <?= ($checked || ($mode === 'create' && empty($selected_application_ids))) ? 'checked' : '' ?>
                                                                <?= $mode === 'view' ? 'disabled' : '' ?>
                                                            >
                                                        </td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['applicant_name']) ?></td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['email']) ?></td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['phone'] ?: '-') ?></td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['job_title']) ?></td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['status']) ?></td>
                                                        <td style="padding:0.75rem;"><?= htmlspecialchars($row['applied_date']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" style="padding:1rem; text-align:center;">No applicants found for selected date range and report type.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php if ($mode !== 'view'): ?>
                                    <div style="margin-top:1rem; display:flex; gap:0.75rem;">
                                        <button type="submit" class="btn btn-primary">
                                            <?= $mode === 'edit' ? 'Update Report' : 'Save Report' ?>
                                        </button>

                                        <?php if ($mode === 'edit' && !empty($editing_report['id'])): ?>
                                            <a href="<?= ROOT ?>/recruitment/reports?tab=generate" class="btn btn-outline">Cancel Edit</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($active_tab === 'created'): ?>
                    <div class="content-card" style="padding: 1rem; margin-top:1rem;">
                        <h3 class="card-title" style="margin-bottom:1rem;">Earlier Created Reports</h3>

                        <div class="table-responsive" style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:10px;">
                            <table class="table" style="width:100%; border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="padding:0.75rem; text-align:left;">Title</th>
                                        <th style="padding:0.75rem; text-align:left;">Type</th>
                                        <th style="padding:0.75rem; text-align:left;">Date Range</th>
                                        <th style="padding:0.75rem; text-align:left;">Selected Applicants</th>
                                        <th style="padding:0.75rem; text-align:left;">Created</th>
                                        <th style="padding:0.75rem; text-align:left;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($saved_reports)): ?>
                                        <?php foreach ($saved_reports as $report): ?>
                                            <tr>
                                                <td style="padding:0.75rem;"><?= htmlspecialchars($report['title']) ?></td>
                                                <td style="padding:0.75rem;"><?= htmlspecialchars($report['report_type']) ?></td>
                                                <td style="padding:0.75rem;"><?= htmlspecialchars($report['from_date']) ?> to <?= htmlspecialchars($report['to_date']) ?></td>
                                                <td style="padding:0.75rem;"><?= (int) $report['selected_count'] ?></td>
                                                <td style="padding:0.75rem;"><?= htmlspecialchars(date('Y-m-d', strtotime($report['created_at']))) ?></td>
                                                <td style="padding:0.75rem; display:flex; gap:0.5rem;">
                                                    <a href="<?= ROOT ?>/recruitment/reports?tab=generate&mode=view&report_id=<?= (int) $report['id'] ?>" class="btn btn-outline">View</a>
                                                    <a href="<?= ROOT ?>/recruitment/reports?tab=generate&mode=edit&report_id=<?= (int) $report['id'] ?>" class="btn btn-primary">Edit</a>
                                                    <a href="<?= ROOT ?>/recruitment/reports/download/<?= (int) $report['id'] ?>" class="btn btn-secondary">Download</a>
                                                    <form method="POST" action="<?= ROOT ?>/recruitment/reports/delete/<?= (int) $report['id'] ?>" onsubmit="return confirm('Delete this report?');">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" style="padding:1rem; text-align:center;">No reports created yet.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script>
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
