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
            <div class="hero-actions" style="margin-bottom: 1rem;">
                <a href="<?= ROOT ?>/hradmin/categories/create" class="btn btn-primary">Create Category</a>
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
                <?php
                $groupedCategories = [];
                foreach ($categories as $category) {
                    $departmentName = trim((string)($category['department_name'] ?? ''));
                    if ($departmentName === '') {
                        $departmentName = 'Unassigned Department';
                    }
                    $groupedCategories[$departmentName][] = $category;
                }
                ?>

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
.categories-department-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
    gap: 1rem;
}

.department-box {
    padding: 1.25rem;
}

.department-box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
}

.department-title {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.department-count {
    font-size: 0.8rem;
    color: var(--muted-foreground);
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
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
}

.department-job-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.department-job-main {
    min-width: 0;
}

.department-job-title {
    margin: 0 0 0.35rem;
    font-weight: 600;
}

.department-job-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.job-meta-item {
    font-size: 0.8rem;
    color: var(--muted-foreground);
}

@media (max-width: 768px) {
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
