<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Schedule - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/interviews.style.css?v=20260415-4">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <style>
        .interviews-content .filter-section { display:flex !important; justify-content:space-between !important; align-items:center !important; gap:16px !important; }
        .interviews-content .status-filters { display:flex !important; flex-wrap:wrap !important; gap:12px !important; }
        .interviews-content .status-filter { padding:8px 14px !important; border:2px solid #e5e7eb !important; border-radius:8px !important; background:#fff !important; color:#6b7280 !important; font-weight:500 !important; cursor:pointer !important; }
        .interviews-content .status-filter.active,
        .interviews-content .status-filter:hover { border-color:#3b82f6 !important; color:#1d4ed8 !important; background:#eff6ff !important; }
        .interviews-content .cards-grid { display:grid !important; grid-template-columns:repeat(auto-fill,minmax(390px,1fr)) !important; gap:20px !important; }
        .interviews-content .status-badge.completed { background:#dcfce7 !important; color:#166534 !important; }
        .interviews-content .status-badge.canceled { background:#fee2e2 !important; color:#991b1b !important; }
        .interviews-content .status-badge.pending { background:#fef3c7 !important; color:#92400e !important; }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs" class="nav-link"><span class="nav-text">Browse Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/applications" class="nav-link"><span class="nav-text">My Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs/savedJobs" class="nav-link"><span class="nav-text">Saved Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews" class="nav-link active"><span class="nav-text">Interview Schedule</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link"><span class="nav-text">Interview Feedback</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/profile" class="nav-link"><span class="nav-text">My Profile</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn"><span>Logout</span></a>
        </div>
    </div>

    <div class="main-content">
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">Interview Schedule</h1>
                <p class="page-subtitle">Track upcoming interviews and review completed sessions.</p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($user['name'] ?? 'User') ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="interviews-content">
            <div class="filter-section">
                <div class="status-filters">
                    <button class="status-filter active" data-status="all">All (<?= (int)($stats['total'] ?? 0) ?>)</button>
                    <button class="status-filter" data-status="pending">Pending</button>
                    <button class="status-filter" data-status="scheduled">Scheduled</button>
                    <button class="status-filter" data-status="rescheduled">Rescheduled</button>
                    <button class="status-filter" data-status="completed">Completed</button>
                    <button class="status-filter" data-status="canceled">Canceled</button>
                </div>
            </div>

            <div class="cards-grid" id="interviewsContainer" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(390px,1fr));gap:20px;">
                <?php foreach (($interviews ?? []) as $interview): ?>
                    <?php
                        $locationMeetingText = $interview['location_meeting_text'] ?? 'TBD';
                        $locationMeetingHref = $interview['location_meeting_href'] ?? '';
                    ?>
                    <article id="interview-<?= (int)$interview['id'] ?>" class="interview-card" data-status="<?= htmlspecialchars($interview['status']) ?>" style="scroll-margin-top:96px;">
                        <div class="card-header">
                            <div class="company-info">
                                <div class="company-logo"><?= strtoupper(substr($interview['job_title'] ?? 'IN', 0, 2)) ?></div>
                                <div class="job-info">
                                    <h3 class="job-title"><?= htmlspecialchars($interview['job_title']) ?></h3>
                                    <p class="company-name"><?= htmlspecialchars($interview['company']) ?></p>
                                </div>
                            </div>
                            <div class="card-status">
                                <span class="status-badge <?= htmlspecialchars($interview['status']) ?>"><?= htmlspecialchars($interview['status_display'] ?? ucfirst($interview['status'])) ?></span>
                            </div>
                        </div>

                        <div class="card-details">
                            <div class="detail-item"><span class="detail-label">Date:</span><span class="detail-value"><?= date('M d, Y', strtotime($interview['date'])) ?></span></div>
                            <div class="detail-item"><span class="detail-label">Time:</span><span class="detail-value"><?= htmlspecialchars($interview['time']) ?></span></div>
                            <div class="detail-item"><span class="detail-label">Type:</span><span class="detail-value"><?= htmlspecialchars($interview['type']) ?></span></div>
                            <div class="detail-item"><span class="detail-label">Interviewer:</span><span class="detail-value"><?= htmlspecialchars($interview['interviewer']) ?></span></div>
                            <div class="detail-item"><span class="detail-label">Duration:</span><span class="detail-value"><?= htmlspecialchars($interview['duration']) ?></span></div>
                            <div class="detail-item">
                                <span class="detail-label"><?= htmlspecialchars($interview['location_meeting_label'] ?? 'Location/Meeting Link') ?>:</span>
                                <span class="detail-value">
                                    <?php if (!empty($locationMeetingHref)): ?>
                                        <a href="<?= htmlspecialchars($locationMeetingHref) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($locationMeetingText) ?></a>
                                    <?php else: ?>
                                        <?= htmlspecialchars($locationMeetingText) ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-actions">
                            <?php if (!empty($interview['meeting_link']) && in_array($interview['status'], ['pending', 'scheduled', 'rescheduled'], true)): ?>
                                <a href="<?= htmlspecialchars($interview['meeting_link']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Join Interview</a>
                            <?php endif; ?>

                            <?php if ($interview['status'] === 'completed'): ?>
                                    <a href="<?= ROOT ?>/applicant/interviews/feedback?interview_id=<?= (int)$interview['id'] ?>" class="btn btn-secondary">View Feedback</a>
                            <?php endif; ?>

                                <?php if (!empty($interview['application_id'])): ?>
                                    <a href="<?= ROOT ?>/applicant/viewApplication/<?= (int)$interview['application_id'] ?>" class="btn btn-outline">Related Application</a>
                                <?php else: ?>
                                    <a href="<?= ROOT ?>/applicant/applications" class="btn btn-outline">Related Application</a>
                                <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">📅</div>
                <h3>No interviews found</h3>
                <p>Your interviews will appear here once a recruiter schedules them.</p>
                <a href="<?= ROOT ?>/applicant/applications" class="btn btn-primary">View Applications</a>
            </div>
        </div>
    </div>

    <script>
        const filters = document.querySelectorAll('.status-filter');
        const cards = document.querySelectorAll('.interview-card');
        const emptyState = document.getElementById('emptyState');

        function applyFilter(status) {
            let visibleCount = 0;
            cards.forEach((card) => {
                const match = status === 'all' || card.dataset.status === status;
                card.style.display = match ? 'block' : 'none';
                if (match) {
                    visibleCount += 1;
                }
            });
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        filters.forEach((filter) => {
            filter.addEventListener('click', function () {
                filters.forEach((item) => item.classList.remove('active'));
                this.classList.add('active');
                applyFilter(this.dataset.status);
            });
        });

        applyFilter('all');
    </script>
</body>

</html>
