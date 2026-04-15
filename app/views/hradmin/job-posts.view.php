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
                    <a href="<?= ROOT ?>/hradmin/create-job" class="nav-link">
                        <span class="nav-text">Create Job</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link active">
                        <span class="nav-text">Job Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicants & Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/departments" class="nav-link">
                        <span class="nav-text">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/categories" class="nav-link">
                        <span class="nav-text">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/profile" class="nav-link">
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
                <h1 class="page-title">Job Posts Management</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">Job Posts Management</h1>
                        <p class="hero-description">Create, edit and manage all your job postings in one place. Track performance and attract top talent.</p>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="stat-number"><?= $total_jobs ?? '24' ?></span>
                                <span class="stat-label">Total Jobs</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $active_jobs ?? '18' ?></span>
                                <span class="stat-label">Active</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $draft_jobs ?? '6' ?></span>
                                <span class="stat-label">Drafts</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                            <i class="icon-plus"></i>Create New Job
                        </a>
                    </div>
                </div>

                <?php if(!empty($errors)): ?>
                    <div class="alert alert-error">
                        <?php foreach($errors as $error): ?>
                            <p><?php echo $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <p><?php echo $success ?></p>
        </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="filter-section">
        <form class="filter-controls" method="GET" action="<?= ROOT ?>/hradmin/job-posts">
            <div class="search-box">
                <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" placeholder="Search job posts..." class="search-input">
                <button type="submit" class="search-btn">Search</button>
            </div>
            <div class="filter-group">
                <select class="filter-select" name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <?php
                        $statusOptions = ['Open', 'Active', 'Closed', 'Draft', 'Paused'];
                        $selectedStatus = strtolower((string)($filters['status'] ?? ''));
                    ?>
                    <?php foreach ($statusOptions as $statusOption): ?>
                        <option value="<?= htmlspecialchars($statusOption) ?>" <?= $selectedStatus === strtolower($statusOption) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($statusOption) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" name="department" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    <?php $selectedDepartment = strtolower((string)($filters['department'] ?? '')); ?>
                    <?php foreach (($department_options ?? []) as $departmentOption): ?>
                        <option value="<?= htmlspecialchars($departmentOption) ?>" <?= $selectedDepartment === strtolower((string)$departmentOption) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($departmentOption) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select class="filter-select" name="type" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <?php $selectedType = strtolower((string)($filters['type'] ?? '')); ?>
                    <?php foreach (($type_options ?? []) as $typeOption): ?>
                        <option value="<?= htmlspecialchars($typeOption) ?>" <?= $selectedType === strtolower((string)$typeOption) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($typeOption) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <!-- Job Posts Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Department</th>
                    <th>Type</th>
                    <th>Posted Date</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($job_posts)): ?>
                    <?php foreach($job_posts as $job): ?>
                        <tr>
                            <td>
                                <div class="job-info">
                                    <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                                    <div class="job-location"><?= htmlspecialchars($job['location']) ?></div>
                                </div>
                            </td>
                            <td><span class="dept-tag <?= strtolower(str_replace(' ', '-', $job['department'])) ?>"><?= htmlspecialchars($job['department']) ?></span></td>
                            <td><?= htmlspecialchars($job['type']) ?></td>
                            <td><?= date('M d, Y', strtotime($job['created_date'])) ?></td>
                            <td>
                                <span class="application-count"><?= $job['applications'] ?></span>
                                <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications&job=<?= $job['id'] ?>" class="view-applications">View</a>
                            </td>
                            <td><span class="status-badge <?= strtolower($job['status']) ?>"><?= htmlspecialchars($job['status']) ?></span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= ROOT ?>/hradmin/view-job/<?= $job['id'] ?>" class="action-btn view-btn" title="View">
                                        View
                                    </a>
                                    <button type="button" class="action-btn edit-btn js-open-edit-modal" data-job-id="<?= $job['id'] ?>" title="Edit">
                                        Edit
                                    </button>
                                    <button class="action-btn delete-btn" title="Delete" onclick="confirmDelete(<?= $job['id'] ?>)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem;">
                            <p>No job posts found. <a href="<?= ROOT ?>/hradmin/create-job">Create your first job post</a></p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <?= count($job_posts ?? []) ?> job post<?= count($job_posts ?? []) != 1 ? 's' : '' ?>
        </div>
        <div class="pagination">
            <button class="pagination-btn" disabled>Previous</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">Next</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this job post? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" onclick="deleteJob()">Delete</button>
        </div>
    </div>
</div>

<div id="editJobModal" class="modal-overlay" style="display: none;">
    <div class="modal-content edit-modal-content">
        <div class="modal-header">
            <h3>Edit Job Post</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <div class="modal-body" id="editJobModalBody">
            <p>Loading...</p>
        </div>
    </div>
</div>

<style>
/* Action buttons styling */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-start;
    align-items: center;
}

.action-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 70px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.view-btn {
    background: #3b82f6;
    color: white;
}

.view-btn:hover {
    background: #2563eb;
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    transform: translateY(-1px);
}

.edit-btn {
    background: #f59e0b;
    color: white;
}

.edit-btn:hover {
    background: #d97706;
    box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
    transform: translateY(-1px);
}

.delete-btn {
    background: #ef4444;
    color: white;
}

.delete-btn:hover {
    background: #dc2626;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
    transform: translateY(-1px);
}

/* Search button styling */
.search-btn {
    padding: 0.625rem 1.25rem;
    background: #4e31aa;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.search-btn:hover {
    background: #3d2687;
}

.edit-modal-content {
    width: min(980px, 96vw);
    max-height: 90vh;
    overflow: auto;
}

#editJobModal .modal-body {
    max-height: calc(90vh - 80px);
    overflow-y: auto;
}

.modal-loading {
    text-align: center;
    padding: 2rem;
}
</style>
<style>
    /* Global Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 2rem;
    }

    .hero-section {
        background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 50%, #667eea 100%);
        color: white;
        padding: 3rem 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        pointer-events: none;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .hero-description {
        font-size: 1.125rem;
        opacity: 1;
        margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.95);
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255,255,255,0.4);
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-outline:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-3px);
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.7rem;
        position: relative;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-stat {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.26);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        min-width: 130px;
    }

    .hero-stat .stat-number {
        font-size: 1.75rem;
        line-height: 1;
        color: #fff;
    }

    .hero-stat .stat-label {
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.3rem;
        display: block;
    }

    .filter-section {
        background: #fff;
        border: 1px solid #e7e9f3;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .filter-controls {
        display: grid;
        grid-template-columns: minmax(300px, 1fr) auto;
        gap: 0.85rem;
        align-items: center;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .search-input {
        width: 100%;
        height: 44px;
        padding: 0 0.95rem;
        border: 1px solid #d8deef;
        border-radius: 10px;
        color: #2f3552;
        background: #fff;
    }

    .search-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #a7aeef;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.16);
    }

    .search-btn {
        height: 44px;
        padding: 0 1.1rem;
        border-radius: 10px;
        background: #5a4ccf;
        color: #fff;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .search-btn:hover {
        background: #4b40b6;
    }

    .filter-group {
        display: flex;
        gap: 0.6rem;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .filter-select {
        height: 44px;
        min-width: 170px;
        padding: 0 0.8rem;
        border: 1px solid #d8deef;
        border-radius: 10px;
        color: #2f3552;
        background: #fff;
    }

    .table-container {
        background: #fff;
        border: 1px solid #e7e9f3;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
        color: #3d3e8e;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.01em;
        padding: 0.9rem 0.85rem;
        border-bottom: 1px solid #ececf5;
        text-align: left;
    }

    .data-table tbody td {
        padding: 0.95rem 0.85rem;
        border-bottom: 1px solid #f0f1f8;
        color: #2f3552;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #fbfbff;
    }

    .job-title {
        font-weight: 700;
        color: #2f3552;
        margin-bottom: 0.2rem;
    }

    .job-location {
        font-size: 0.83rem;
        color: #6d7485;
    }

    .dept-tag {
        display: inline-flex;
        align-items: center;
        padding: 0.28rem 0.72rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        background: #edf1ff;
        color: #4052b5;
        border: 1px solid #dbe3ff;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.3rem 0.72rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .status-badge.open,
    .status-badge.active {
        background: #e9f8ef;
        color: #1f8d56;
        border: 1px solid #cfeedd;
    }

    .status-badge.draft {
        background: #eef1f7;
        color: #5a647a;
        border: 1px solid #e0e4ee;
    }

    .status-badge.closed {
        background: #fce9ec;
        color: #b54556;
        border: 1px solid #f5d1d8;
    }

    .application-count {
        font-weight: 700;
        color: #3d3e8e;
        margin-right: 0.5rem;
    }

    .view-applications {
        color: #5a4ccf;
        font-size: 0.84rem;
        font-weight: 600;
        text-decoration: none;
    }

    .view-applications:hover {
        text-decoration: underline;
    }

    .pagination-container {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #6d7485;
        font-weight: 600;
        font-size: 0.88rem;
    }

    .pagination {
        display: flex;
        gap: 0.45rem;
    }

    .pagination-btn {
        border: 1px solid #d7dcf2;
        background: #f8f9ff;
        color: #4753a6;
        border-radius: 8px;
        padding: 0.42rem 0.78rem;
        font-weight: 600;
        cursor: pointer;
    }

    .pagination-btn.active {
        background: #5a4ccf;
        color: #fff;
        border-color: #5a4ccf;
    }

    .pagination-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .modal-content {
        width: min(540px, 94vw);
        background: #fff;
        border: 1px solid #e7e9f3;
        border-radius: 14px;
        box-shadow: 0 20px 40px rgba(18, 26, 68, 0.2);
        overflow: hidden;
    }

    .modal-header {
        padding: 1rem 1.1rem;
        border-bottom: 1px solid #ececf5;
        background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: #3d3e8e;
    }

    .modal-body {
        padding: 1rem 1.1rem;
        color: #2f3552;
    }

    .modal-footer {
        padding: 0.95rem 1.1rem;
        border-top: 1px solid #ececf5;
        display: flex;
        justify-content: flex-end;
        gap: 0.55rem;
    }

    .modal-close {
        border: none;
        background: transparent;
        color: #5a647a;
        font-size: 1.45rem;
        line-height: 1;
        cursor: pointer;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(21, 25, 48, 0.46);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        z-index: 999;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .alert {
        border-radius: 12px;
        padding: 0.9rem 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
    }

    .alert-error {
        background: #fff5f6;
        border-color: #f3cfd6;
        color: #9b3647;
    }

    .alert-success {
        background: #eefaf3;
        border-color: #cfeedd;
        color: #1f8d56;
    }

    .empty-state {
        color: #6d7485;
    }

    .job-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* Icons */
    .icon-plus::before { content: '✚'; }
    .icon-download::before { content: '⬇'; }
    .icon-edit::before { content: '✏️'; }
    .icon-delete::before { content: '🗑️'; }
    .icon-view::before { content: '👁️'; }

    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
        }
        .dashboard-content {
            padding: 1rem;
        }

        .filter-controls {
            grid-template-columns: 1fr;
            align-items: stretch;
        }

        .search-box {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            justify-content: stretch;
        }

        .filter-select {
            width: 100%;
            min-width: 0;
        }

        .data-table {
            min-width: 860px;
        }

        .table-container {
            overflow-x: auto;
        }
    }
</style>

<script>
let deleteJobId = null;
let editModalOpen = false;

function openEditModal(jobId) {
    const modal = document.getElementById('editJobModal');
    const modalBody = document.getElementById('editJobModalBody');

    if (!modal || !modalBody) {
        return;
    }

    modalBody.innerHTML = '<div class="modal-loading"><p>Loading...</p></div>';
    modal.style.display = 'flex';
    editModalOpen = true;

    fetch('<?= ROOT ?>/hradmin/edit-job/' + jobId + '?modal=1', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.text())
        .then(html => {
            modalBody.innerHTML = html;
        })
        .catch(() => {
            modalBody.innerHTML = '<div class="alert alert-error"><p>Failed to load edit form. Please try again.</p></div>';
        });
}

function closeEditModal() {
    const modal = document.getElementById('editJobModal');
    const modalBody = document.getElementById('editJobModalBody');
    if (!modal || !modalBody) {
        return;
    }
    modal.style.display = 'none';
    modalBody.innerHTML = '<div class="modal-loading"><p>Loading...</p></div>';
    editModalOpen = false;
}

function confirmDelete(jobId) {
    deleteJobId = jobId;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    deleteJobId = null;
    document.getElementById('deleteModal').style.display = 'none';
}

function deleteJob() {
    if (deleteJobId) {
        // Redirect to delete action
        window.location.href = '<?= ROOT ?>/hradmin/job-posts/delete/' + deleteJobId;
    }
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('editJobModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Sidebar toggle functionality
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});

document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
    if (e.target.textContent.trim() === ">") {
        e.target.textContent = "<";
    } else {
        e.target.textContent = ">";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-open-edit-modal').forEach(function(button) {
        button.addEventListener('click', function() {
            openEditModal(this.getAttribute('data-job-id'));
        });
    });

    const modalBody = document.getElementById('editJobModalBody');
    if (modalBody) {
        modalBody.addEventListener('submit', function(event) {
            const form = event.target.closest('.js-edit-job-form');
            if (!form || !editModalOpen) {
                return;
            }

            event.preventDefault();

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Updating...';
            }

            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        window.location.reload();
                        return;
                    }

                    const errors = Array.isArray(result.errors) ? result.errors : ['Failed to update job post.'];
                    const errorHtml = '<div class="alert alert-error">' +
                        errors.map(function(error) {
                            return '<p>' + error + '</p>';
                        }).join('') +
                        '</div>';
                    const existingError = form.querySelector('.alert.alert-error');
                    if (existingError) {
                        existingError.remove();
                    }
                    form.insertAdjacentHTML('afterbegin', errorHtml);
                })
                .catch(() => {
                    const existingError = form.querySelector('.alert.alert-error');
                    if (existingError) {
                        existingError.remove();
                    }
                    form.insertAdjacentHTML('afterbegin', '<div class="alert alert-error"><p>Failed to update job post. Please try again.</p></div>');
                })
                .finally(() => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Update Job';
                    }
                });
        });
    }

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
