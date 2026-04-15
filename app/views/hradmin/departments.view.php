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
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/departments" class="nav-link active"><span class="nav-text">Departments</span></a></li>
            <li class="nav-item"><a href="<?= ROOT ?>/hradmin/categories" class="nav-link"><span class="nav-text">Categories</span></a></li>
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
            <h1 class="page-title">Departments</h1>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="main-container">
            <?php
                $departmentList = $departments ?? [];
                $totalDepartments = count($departmentList);
                $totalJobs = 0;
                foreach ($departmentList as $departmentItem) {
                    $totalJobs += (int)($departmentItem['jobs_count'] ?? 0);
                }
                $avgJobsPerDepartment = $totalDepartments > 0 ? round($totalJobs / $totalDepartments, 1) : 0;
            ?>

            <section class="hero-section">
                <div class="hero-content">
                    <h2>Department Management</h2>
                    <p>Manage organizational departments, leadership, and job allocations in one place.</p>
                </div>
                <div class="hero-actions">
                    <a href="<?= ROOT ?>/hradmin/departments/create" class="btn btn-primary">Create Department</a>
                </div>
            </section>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Departments</div>
                    <div class="stat-value"><?= $totalDepartments ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Jobs Assigned</div>
                    <div class="stat-value"><?= $totalJobs ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Avg Jobs / Department</div>
                    <div class="stat-value"><?= number_format($avgJobsPerDepartment, 1) ?></div>
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

            <div class="table-card">
                <div class="table-header">
                    <h3>Department Directory</h3>
                    <span class="table-subtitle">Aligned with current system structure</span>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Head</th>
                            <th>Jobs</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($departments)): ?>
                            <?php foreach ($departments as $department): ?>
                                <tr>
                                    <td>
                                        <div class="department-name"><?= htmlspecialchars($department['name']) ?></div>
                                    </td>
                                    <td><?= htmlspecialchars($department['description'] ?? '—') ?></td>
                                    <td><?= htmlspecialchars($department['head_name'] ?? '—') ?></td>
                                    <td><span class="jobs-pill"><?= (int)($department['jobs_count'] ?? 0) ?></span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= ROOT ?>/hradmin/departments/edit/<?= $department['id'] ?>" class="action-btn edit-btn">Edit</a>
                                            <form method="POST" action="<?= ROOT ?>/hradmin/departments/delete/<?= $department['id'] ?>" style="display:inline;" onsubmit="return confirm('Delete this department?');">
                                                <button type="submit" class="action-btn delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="empty-row">No departments found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
    margin-bottom: 1.25rem;
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
    text-decoration: none;
}

.hero-actions .btn-primary {
    background: #ffffff;
    color: #5a4ccf;
    border: none;
}

.hero-actions .btn-primary:hover {
    background: #f4f2ff;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
    margin-bottom: 0.4rem;
}

.stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #3d3e8e;
}

.table-card {
    background: #fff;
    border: 1px solid #e8e9f3;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.2rem;
    border-bottom: 1px solid #ececf5;
    background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
}

.table-header h3 {
    margin: 0;
    color: #3d3e8e;
    font-size: 1.05rem;
}

.table-subtitle {
    color: #7a7e94;
    font-size: 0.85rem;
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    text-align: left;
    background: #f9f9ff;
    color: #5a4ccf;
    padding: 0.85rem 1rem;
    font-size: 0.88rem;
    border-bottom: 1px solid #ececf5;
}

.data-table tbody td {
    padding: 0.9rem 1rem;
    border-bottom: 1px solid #f0f1f8;
    color: #2f3552;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #fafaff;
}

.department-name {
    font-weight: 700;
    color: #364090;
}

.jobs-pill {
    background: #ece9ff;
    color: #4b39b8;
    border: 1px solid #ddd6ff;
    border-radius: 999px;
    padding: 0.28rem 0.65rem;
    font-size: 0.82rem;
    font-weight: 700;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-btn {
    border: none;
    border-radius: 8px;
    padding: 0.4rem 0.75rem;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.edit-btn {
    background: #e9f0ff;
    color: #3159c7;
}

.delete-btn {
    background: #ffe9ee;
    color: #b63858;
}

.edit-btn:hover {
    background: #dce7ff;
}

.delete-btn:hover {
    background: #ffd9e3;
}

.empty-row {
    text-align: center;
    padding: 1.5rem;
    color: #6d7485;
}

.alert {
    border-radius: 10px;
    margin-bottom: 0.9rem;
    padding: 0.8rem 1rem;
}

@media (max-width: 768px) {
    .hero-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .dashboard-content {
        padding: 1rem;
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
