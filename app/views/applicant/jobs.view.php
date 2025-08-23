<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/jobs.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link active">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link">
                        <span class="nav-text">My Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews" class="nav-link">
                        <span class="nav-text">Interview Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link">
                        <span class="nav-text">Interview Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/profile" class="nav-link">
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
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">Browse Jobs</h1>
                <p class="page-subtitle">Find your next opportunity</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="jobs-content">
            <!-- Search and Filter Section -->
            <div class="search-section">
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" placeholder="Search jobs by title, company, or keywords..." class="search-input">
                        <button class="search-btn">🔍</button>
                    </div>
                    <div class="filter-container">
                        <select class="filter-select">
                            <option value="">All Locations</option>
                            <option value="colombo">Colombo</option>
                            <option value="kandy">Kandy</option>
                            <option value="galle">Galle</option>
                            <option value="negombo">Negombo</option>
                        </select>
                        <select class="filter-select">
                            <option value="">All Job Types</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                        <select class="filter-select">
                            <option value="">All Departments</option>
                            <option value="engineering">Engineering</option>
                            <option value="development">Development</option>
                            <option value="design">Design</option>
                            <option value="data-science">Data Science</option>
                            <option value="management">Management</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Jobs List -->
            <div class="jobs-grid">
                <?php if (!empty($jobs)): ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card">
                            <div class="job-header">
                                <div class="job-title-section">
                                    <h3 class="job-title"><?= $job['title'] ?></h3>
                                    <p class="company-name"><?= $job['company'] ?></p>
                                </div>
                                <div class="job-type-badge">
                                    <span class="job-type"><?= $job['type'] ?></span>
                                </div>
                            </div>
                            
                            <div class="job-details">
                                <div class="job-info-row">
                                    <span class="info-label">📍 Location:</span>
                                    <span class="info-value"><?= $job['location'] ?></span>
                                </div>
                                <div class="job-info-row">
                                    <span class="info-label">💰 Salary:</span>
                                    <span class="info-value"><?= $job['salary'] ?></span>
                                </div>
                                <div class="job-info-row">
                                    <span class="info-label">🏢 Department:</span>
                                    <span class="info-value"><?= $job['department'] ?></span>
                                </div>
                                <div class="job-info-row">
                                    <span class="info-label">📅 Deadline:</span>
                                    <span class="info-value deadline"><?= date('M d, Y', strtotime($job['deadline'])) ?></span>
                                </div>
                            </div>
                            
                            <div class="job-description">
                                <p><?= $job['description_short'] ?></p>
                            </div>
                            
                            <div class="job-meta">
                                <span class="posted-date">Posted: <?= date('M d, Y', strtotime($job['posted_date'])) ?></span>
                            </div>
                            
                            <div class="job-actions">
                                <a href="<?= ROOT ?>/applicant/jobs/details?id=<?= $job['id'] ?>" class="btn btn-outline">View Details</a>
                                <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">🔍</div>
                        <h3>No jobs found</h3>
                        <p>Try adjusting your search criteria or check back later for new opportunities.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn" disabled>← Previous</button>
                <span class="page-info">Page 1 of 1</span>
                <button class="page-btn" disabled>Next →</button>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/jobs.js"></script>
</body>

</html>
