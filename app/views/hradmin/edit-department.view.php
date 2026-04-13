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
            <h1 class="page-title">Edit Department</h1>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="main-container">
            <div class="hero-actions" style="margin-bottom: 1rem;">
                <a href="<?= ROOT ?>/hradmin/departments" class="btn btn-secondary">Back to Departments</a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-container" style="background:#fff; border-radius:12px; padding:1.5rem;">
                <form method="POST" action="<?= ROOT ?>/hradmin/departments/edit/<?= $department['id'] ?>">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Department Name *</label>
                        <input type="text" name="name" class="form-input" required value="<?= htmlspecialchars($department['name'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-textarea" rows="4"><?= htmlspecialchars($department['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Head of Department</label>
                        <select name="head_of_department" class="form-select">
                            <option value="">Select Head</option>
                            <?php foreach (($managers ?? []) as $manager): ?>
                                <option value="<?= $manager['id'] ?>" <?= (string)($department['head_of_department'] ?? '') === (string)$manager['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($manager['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Department</button>
                    </div>
                </form>
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
