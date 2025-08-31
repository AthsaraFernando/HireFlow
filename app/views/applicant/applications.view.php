<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/applications.style.css">
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
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link active">
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
                <h1 class="page-title">My Applications</h1>
                <p class="page-subtitle">Track your job applications and their status</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Smith</span>
                    <div class="user-avatar">JS</div>
                </div>
            </div>
        </header>

        <div class="applications-content">
            <!-- Status Filter -->
            <div class="filter-section">
                <div class="status-filters">
                    <button class="status-filter active" data-status="all">All Applications</button>
                    <button class="status-filter" data-status="pending">Pending</button>
                    <button class="status-filter" data-status="shortlisted">Shortlisted</button>
                    <button class="status-filter" data-status="interviewed">Interviewed</button>
                    <button class="status-filter" data-status="rejected">Rejected</button>
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid">📊 Grid</button>
                    <button class="view-btn" data-view="list">📋 List</button>
                </div>
            </div>

            <!-- Applications Grid -->
            <div class="applications-grid" id="applicationsContainer">
                <?php foreach($applications as $application): ?>
                <div class="application-card" data-status="<?= strtolower($application['status']) ?>">
                    <div class="application-header">
                        <div class="company-info">
                            <div class="company-logo"><?= strtoupper(substr($application['company'], 0, 2)) ?></div>
                            <div class="job-info">
                                <h3 class="job-title"><?= $application['job_title'] ?></h3>
                                <p class="company-name"><?= $application['company'] ?></p>
                                <p class="location">📍 <?= $application['location'] ?></p>
                            </div>
                        </div>
                        <div class="application-status">
                            <span class="status-badge <?= strtolower($application['status']) ?>"><?= ucfirst($application['status']) ?></span>
                        </div>
                    </div>
                    
                    <div class="application-details">
                        <div class="detail-item">
                            <span class="detail-label">Applied Date:</span>
                            <span class="detail-value"><?= date('M d, Y', strtotime($application['applied_date'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Last Update:</span>
                            <span class="detail-value"><?= date('M d, Y', strtotime($application['last_update'])) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Salary:</span>
                            <span class="detail-value"><?= $application['salary'] ?></span>
                        </div>
                    </div>
                    
                    <div class="application-actions">
                        <button class="btn btn-outline" onclick="viewApplication(<?= $application['id'] ?>)">View Details</button>
                        <?php if($application['status'] === 'pending'): ?>
                            <button class="btn btn-secondary" onclick="withdrawApplication(<?= $application['id'] ?>)">Withdraw</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">📄</div>
                <h3>No applications found</h3>
                <p>Start applying for jobs to see them here</p>
                <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-primary">Browse Jobs</a>
            </div>
        </div>
    </div>

    <script>
        // Status filtering
        document.querySelectorAll('.status-filter').forEach(filter => {
            filter.addEventListener('click', function() {
                // Update active filter
                document.querySelectorAll('.status-filter').forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                
                const status = this.dataset.status;
                const applications = document.querySelectorAll('.application-card');
                let visibleCount = 0;
                
                applications.forEach(app => {
                    if (status === 'all' || app.dataset.status === status) {
                        app.style.display = 'block';
                        visibleCount++;
                    } else {
                        app.style.display = 'none';
                    }
                });
                
                // Show/hide empty state
                const emptyState = document.getElementById('emptyState');
                if (visibleCount === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                }
            });
        });
        
        // View toggle
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                const container = document.getElementById('applicationsContainer');
                
                if (view === 'list') {
                    container.classList.add('list-view');
                } else {
                    container.classList.remove('list-view');
                }
            });
        });
        
        function viewApplication(id) {
            alert(`Viewing application details for ID: ${id} (Demo mode)`);
        }
        
        function withdrawApplication(id) {
            if (confirm('Are you sure you want to withdraw this application?')) {
                alert(`Application withdrawn for ID: ${id} (Demo mode)`);
            }
        }
    </script>
</body>

</html>
