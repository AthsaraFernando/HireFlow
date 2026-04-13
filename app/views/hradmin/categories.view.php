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

            <div class="table-container">
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>Name (Job Title)</th>
                        <th>Department (Responsible Department)</th>
                        <th>Jobs</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td><?= htmlspecialchars($category['department_name'] ?? '—') ?></td>
                                <td><?= (int)($category['jobs_count'] ?? 0) ?></td>
                                <td><?= htmlspecialchars(ucfirst($category['status'] ?? 'inactive')) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= ROOT ?>/hradmin/categories/edit/<?= $category['id'] ?>" class="action-btn edit-btn">Edit</a>
                                        <form method="POST" action="<?= ROOT ?>/hradmin/categories/delete/<?= $category['id'] ?>" style="display:inline;" onsubmit="return confirm('Delete this category?');">
                                            <button type="submit" class="action-btn delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding:1.5rem;">No categories found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});
</script>

<?php $this->view('components/footer') ?>
