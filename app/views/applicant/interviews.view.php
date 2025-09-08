<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Schedule - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/interviews.style.css">
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
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link">
                        <span class="nav-text">My Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews" class="nav-link active">
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
                <h1 class="page-title">Interview Schedule</h1>
                <p class="page-subtitle">Manage your upcoming and past interviews</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="interviews-content">
            <!-- Status Filter -->
            <div class="filter-section">
                <div class="status-filters">
                    <button class="status-filter active" data-status="all">All Interviews</button>
                    <button class="status-filter" data-status="scheduled">Scheduled</button>
                    <button class="status-filter" data-status="completed">Completed</button>
                    <button class="status-filter" data-status="cancelled">Cancelled</button>
                </div>
            </div>

            <!-- Interviews Timeline -->
            <div class="interviews-timeline">
                <?php foreach($interviews as $interview): ?>
                <div class="interview-card" data-status="<?= strtolower($interview['status']) ?>">
                    <div class="interview-date-badge">
                        <div class="date-day"><?= date('d', strtotime($interview['date'])) ?></div>
                        <div class="date-month"><?= date('M', strtotime($interview['date'])) ?></div>
                    </div>
                    
                    <div class="interview-content">
                        <div class="interview-header">
                            <div class="job-info">
                                <h3 class="job-title"><?= $interview['job_title'] ?></h3>
                                <p class="company-name"><?= $interview['company'] ?></p>
                            </div>
                            <div class="interview-status">
                                <span class="status-badge <?= strtolower($interview['status']) ?>"><?= ucfirst($interview['status']) ?></span>
                            </div>
                        </div>
                        
                        <div class="interview-details">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <span class="detail-icon">⏰</span>
                                    <span class="detail-text"><?= $interview['time'] ?> (<?= $interview['duration'] ?>)</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">👤</span>
                                    <span class="detail-text"><?= $interview['interviewer'] ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">📍</span>
                                    <span class="detail-text"><?= $interview['location'] ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">💼</span>
                                    <span class="detail-text"><?= $interview['type'] ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="interview-actions">
                            <?php if($interview['status'] === 'scheduled'): ?>
                                <button class="btn btn-outline" onclick="viewDetails(<?= $interview['id'] ?>)">View Details</button>
                                <button class="btn btn-primary" onclick="joinInterview(<?= $interview['id'] ?>)">Join Interview</button>
                            <?php elseif($interview['status'] === 'completed'): ?>
                                <button class="btn btn-outline" onclick="viewDetails(<?= $interview['id'] ?>)">View Details</button>
                                <a href="<?= ROOT ?>/applicant/interviews/feedback" class="btn btn-secondary">View Feedback</a>
                            <?php else: ?>
                                <button class="btn btn-outline" onclick="viewDetails(<?= $interview['id'] ?>)">View Details</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">📅</div>
                <h3>No interviews found</h3>
                <p>Your scheduled interviews will appear here</p>
                <a href="<?= ROOT ?>/applicant/applications" class="btn btn-primary">View Applications</a>
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
                const interviews = document.querySelectorAll('.interview-card');
                let visibleCount = 0;
                
                interviews.forEach(interview => {
                    if (status === 'all' || interview.dataset.status === status) {
                        interview.style.display = 'flex';
                        visibleCount++;
                    } else {
                        interview.style.display = 'none';
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
        
        function viewDetails(id) {
            alert(`Viewing interview details for ID: ${id} (Demo mode)`);
        }
        
        function joinInterview(id) {
            alert(`Joining interview for ID: ${id} (Demo mode)\nThis would typically open the video call link.`);
        }
    </script>
</body>

</html>
