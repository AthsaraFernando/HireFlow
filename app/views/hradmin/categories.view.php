<?php $this->view('components/header') ?>

<body>
<div class="sidebar">
    <div class="sidebar-header">
        <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
        <p class="brand-subtitle">HR Admin</p>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/create-job" class="nav-link"><span class="nav-text">Create Job</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link"><span class="nav-text">Job Posts</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link"><span class="nav-text">Applicants & Applications</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/departments" class="nav-link"><span class="nav-text">Departments</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/categories" class="nav-link active"><span class="nav-text">Categories</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/reports" class="nav-link"><span class="nav-text">Reports</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/profile" class="nav-link"><span class="nav-text">My Profile</span></a></li>
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
            <h1 class="page-title">Job Categories / Roles</h1>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="main-container">
            <?php
                $categoryList = $categories ?? [];
                $totalCategories = count($categoryList);
                $totalJobsAcrossCategories = 0;
                $activeCategories = 0;
                $groupedCategories = [];

                if (!empty($categoryList)) {
                    foreach ($categoryList as $category) {
                        $departmentName = trim((string)($category['department_name'] ?? ''));
                        if ($departmentName === '') {
                            $departmentName = 'Unassigned Department';
                        }

                        $groupedCategories[$departmentName][] = $category;
                        $totalJobsAcrossCategories += (int)($category['jobs_count'] ?? 0);

                        if (strtolower((string)($category['status'] ?? 'inactive')) === 'active') {
                            $activeCategories++;
                        }
                    }
                }
            ?>

            <section class="hero-section">
                <div class="hero-content">
                    <h2>Job Categories Management</h2>
                    <p>Organize roles by department and keep your hiring structure consistent across the system.</p>
                </div>
                <div class="hero-actions">
                    <a href="<?= ROOT ?>/hradmin/categories/create" class="btn btn-primary">Create Category</a>
                </div>
            </section>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Categories</div>
                    <div class="stat-value"><?= $totalCategories ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Active Categories</div>
                    <div class="stat-value"><?= $activeCategories ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Jobs Linked</div>
                    <div class="stat-value"><?= $totalJobsAcrossCategories ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Departments Covered</div>
                    <div class="stat-value"><?= count($groupedCategories) ?></div>
                </div>
            </div>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><p><?= htmlspecialchars($success) ?></p></div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($categories)): ?>
                <div class="categories-department-grid">
                    <?php foreach ($groupedCategories as $departmentName => $departmentCategories): ?>
                        <section class="dashboard-card department-box">
                            <div class="department-box-header">
                                <h3 class="department-title"><?= htmlspecialchars($departmentName) ?></h3>
                                <span class="department-count"><?= count($departmentCategories) ?> Job Title<?= count($departmentCategories) !== 1 ? 's' : '' ?></span>
                            </div>

                            <div class="department-jobs-list">
                                <?php foreach ($departmentCategories as $category): ?>
                                    <?php $status = strtolower((string)($category['status'] ?? 'inactive')); ?>
                                    <div class="department-job-row">
                                        <div class="department-job-main">
                                            <p class="department-job-title"><?= htmlspecialchars($category['name']) ?></p>
                                            <div class="department-job-meta">
                                                <span class="job-meta-item">Job Count: <?= (int)($category['jobs_count'] ?? 0) ?></span>
                                                <span class="status-badge <?= $status === 'active' ? 'active' : 'draft' ?>">
                                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="action-buttons">
                                            <a href="<?= ROOT ?>/hradmin/categories/edit/<?= $category['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                                            <form method="POST" action="<?= ROOT ?>/hradmin/categories/delete/<?= $category['id'] ?>" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <div style="text-align:center; padding:1.5rem;">No categories found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.dashboard-content {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 1.5rem;
}

.main-container {
    max-width: 1400px;
    margin: 0 auto;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.25);
}

.hero-content h2 {
    margin: 0 0 0.5rem;
    font-size: 1.8rem;
    color: #fff;
}

.hero-content p {
    margin: 0;
    color: rgba(255, 255, 255, 0.92);
}

.hero-actions .btn {
    border-radius: 10px;
    padding: 0.7rem 1.15rem;
    font-weight: 600;
}

.hero-actions .btn-primary {
    background: #ffffff;
    color: #5a4ccf;
    border: none;
    text-decoration: none;
}

.hero-actions .btn-primary:hover {
    background: #f3f1ff;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-card {
    background: #fff;
    border: 1px solid #e8e9f3;
    border-radius: 12px;
    padding: 1rem 1.1rem;
    box-shadow: 0 4px 14px rgba(86, 76, 207, 0.08);
}

.stat-label {
    font-size: 0.85rem;
    color: #6d7485;
    margin-bottom: 0.35rem;
}

.stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #3d3e8e;
}

.categories-department-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
    gap: 1rem;
}

.department-box {
    padding: 1.25rem;
    border-radius: 14px;
    border: 1px solid #e8e9f3;
    background: #fff;
    box-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
}

.department-box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #ececf5;
}

.department-title {
    margin: 0;
    font-size: 1.03rem;
    font-weight: 700;
    color: #3d3e8e;
}

.department-count {
    font-size: 0.8rem;
    color: #6d7485;
    background: #f4f5ff;
    border: 1px solid #e6e9ff;
    border-radius: 999px;
    padding: 0.22rem 0.62rem;
}

.department-jobs-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.department-job-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.65rem 0;
    border-bottom: 1px solid #f0f1f8;
}

.department-job-row:last-child {
    border-bottom: none;
    padding-bottom: 0.2rem;
}

.department-job-main {
    min-width: 0;
}

.department-job-title {
    margin: 0 0 0.35rem;
    font-weight: 700;
    color: #2f3552;
}

.department-job-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.job-meta-item {
    font-size: 0.8rem;
    color: #6d7485;
}

.status-badge {
    border-radius: 999px;
    padding: 0.22rem 0.6rem;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid transparent;
}

.status-badge.active {
    background: #eafbf2;
    color: #1f8d56;
    border-color: #c9efd9;
}

.status-badge.draft,
.status-badge.inactive {
    background: #fff4e5;
    color: #b96a11;
    border-color: #f6ddb4;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-buttons .btn {
    border-radius: 8px;
    padding: 0.36rem 0.68rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
}

.action-buttons .btn-secondary {
    background: #e9f0ff;
    color: #3159c7;
}

.action-buttons .btn-danger {
    background: #ffe9ee;
    color: #b63858;
}

.action-buttons .btn-secondary:hover {
    background: #dde8ff;
}

.action-buttons .btn-danger:hover {
    background: #ffdbe4;
}

.table-container {
    background: #fff;
    border: 1px solid #e8e9f3;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(86, 76, 207, 0.08);
}

@media (max-width: 768px) {
    .dashboard-content {
        padding: 1rem;
    }

    .hero-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .categories-department-grid {
        grid-template-columns: 1fr;
    }

    .department-job-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<script>
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});
</script>

<?php $this->view('components/footer') ?>
