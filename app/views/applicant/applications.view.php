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
                    <a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link">
                        <span class="nav-text">Saved Jobs</span>
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
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="applications-content">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background-color: #d4edda; color: #155724; border-radius: 8px;">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-bottom: 20px; padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 8px;">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Status Filter -->
            <div class="filter-section">
                <div class="status-filters">
                    <button class="status-filter active" data-status="all">
                        All Applications (<?= $stats['total'] ?>)
                    </button>
                    <button class="status-filter" data-status="applied">
                        Applied (<?= $stats['pending'] ?>)
                    </button>
                    <button class="status-filter" data-status="shortlisted">
                        Shortlisted (<?= $stats['shortlisted'] ?>)
                    </button>
                    <button class="status-filter" data-status="interview scheduled">
                        Interviewed (<?= $stats['interview_scheduled'] ?>)
                    </button>
                    <button class="status-filter" data-status="rejected">
                        Rejected (<?= $stats['rejected'] ?>)
                    </button>
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
                        <a href="<?= ROOT ?>/applicant/viewApplication/<?= $application['id'] ?>" class="btn btn-outline">View Details</a>
                        <?php if(in_array(strtolower($application['status']), ['applied', 'under review'])): ?>
                            <a href="<?= ROOT ?>/applicant/editApplication/<?= $application['id'] ?>" class="btn btn-secondary">Edit</a>
                            <button class="btn btn-danger" onclick="deleteApplication(<?= $application['id'] ?>)">Delete</button>
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
        
        function deleteApplication(id) {
            if (confirm('Are you sure you want to delete this application? This action cannot be undone.')) {
                window.location.href = '<?= ROOT ?>/applicant/deleteApplication/' + id;
            }
        }
    </script>
</body>

</html>
