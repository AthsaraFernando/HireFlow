<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Postings - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/jobposting.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

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
                    <a href="<?= ROOT ?>/hradmin/jobposting" class="nav-link active">
                        <span class="nav-text">Job Posting</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
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
                    &#9776;
                </button>
                <h1 class="page-title">Job Postings</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? 'HR Admin' ?>
                        </span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="jobposting-container">
                <!-- Header Section -->
                <div class="page-header">
                    <h1>Job Postings</h1>
                    <button class="btn btn-primary" onclick="window.location.href='<?= ROOT ?>/hradmin/jobposting/create'">
                        <i class="fas fa-plus"></i> Create New Job
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= $stats['total'] ?? 0 ?></h3>
                            <p>Total Job Postings</p>
                        </div>
                    </div>
                    
                    <div class="stat-card green">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= $stats['active'] ?? 0 ?></h3>
                            <p>Active Postings</p>
                        </div>
                    </div>
                    
                    <div class="stat-card orange">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= $stats['thisWeek'] ?? 0 ?></h3>
                            <p>New This Week</p>
                        </div>
                    </div>
                    
                    <div class="stat-card purple">
                        <div class="stat-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?= $stats['pending'] ?? 0 ?></h3>
                            <p>Pending Applications</p>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search jobs by title, company, or location...">
                    </div>
                    
                    <div class="filter-controls">
                        <select id="statusFilter" class="filter-select">
                            <option value="">All Status</option>
                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>
                            <option value="Draft">Draft</option>
                        </select>
                        
                        <select id="sortBy" class="filter-select">
                            <option value="created_at">Sort by Date</option>
                            <option value="title">Sort by Title</option>
                            <option value="deadline">Sort by Deadline</option>
                        </select>
                    </div>
                </div>

                <!-- Job Postings Table -->
                <div class="table-container">
                    <table class="job-table">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="jobTableBody">
                            <?php if (!empty($jobpostings)): ?>
                                <?php foreach ($jobpostings as $job): ?>
                                    <tr>
                                        <td>
                                            <div class="job-title">
                                                <strong><?= htmlspecialchars($job['title'] ?? '') ?></strong>
                                                <small><?= htmlspecialchars($job['department'] ?? '') ?></small>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($job['company'] ?? '') ?></td>
                                        <td>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($job['location'] ?? '') ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-dollar-sign"></i>
                                            <?= htmlspecialchars($job['salary'] ?? '') ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar"></i>
                                            <?= date('Y-m-d', strtotime($job['deadline'] ?? '')) ?>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= strtolower($job['status'] ?? 'open') ?>">
                                                <?= htmlspecialchars($job['status'] ?? 'Open') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action edit" onclick="editJob(<?= $job['id'] ?? 0 ?>)" title="Edit">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn-action delete" onclick="deleteJob(<?= $job['id'] ?? 0 ?>)" title="Delete">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="no-data">
                                        <div class="no-data-message">
                                            <i class="fas fa-briefcase"></i>
                                            <h3>No Job Postings Found</h3>
                                            <p>Start by creating your first job posting</p>
                                            <button class="btn btn-primary" onclick="window.location.href='<?= ROOT ?>/hradmin/jobposting/create'">
                                                Create New Job
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <script>
        const ROOT = '<?= ROOT ?>';
    </script>
    <script src="<?= ROOT ?>/assets/js/jobposting.js"></script>
</body>
</html>
