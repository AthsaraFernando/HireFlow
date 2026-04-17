<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Feedback - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/feedback.style.css?v=20260415-4">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <style>
        .feedback-content .filter-section { display:flex !important; justify-content:space-between !important; align-items:center !important; gap:16px !important; }
        .feedback-content .status-filters { display:flex !important; flex-wrap:wrap !important; gap:12px !important; }
        .feedback-content .status-filter { padding:8px 14px !important; border:2px solid #e5e7eb !important; border-radius:8px !important; background:#fff !important; color:#6b7280 !important; font-weight:500 !important; cursor:pointer !important; }
        .feedback-content .status-filter.active,
        .feedback-content .status-filter:hover { border-color:#3b82f6 !important; color:#1d4ed8 !important; background:#eff6ff !important; }
        .feedback-content .cards-grid { display:grid !important; grid-template-columns:repeat(auto-fill,minmax(400px,1fr)) !important; gap:20px !important; }
        .feedback-content .status-badge.hire { background:#dcfce7 !important; color:#166534 !important; }
        .feedback-content .status-badge.reject { background:#fee2e2 !important; color:#991b1b !important; }
        .feedback-content .status-badge.pending { background:#fef3c7 !important; color:#92400e !important; }
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
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews" class="nav-link"><span class="nav-text">Interview Schedule</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link active"><span class="nav-text">Interview Feedback</span></a></li>
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
                <h1 class="page-title">Interview Feedback</h1>
                <p class="page-subtitle">Review detailed evaluations from completed interviews.</p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($user['name'] ?? 'User') ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="feedback-content">
            <div class="filter-section">
                <div class="status-filters">
                    <button class="status-filter active" data-status="all">All (<?= (int)($stats['total_feedbacks'] ?? 0) ?>)</button>
                    <button class="status-filter" data-status="hire">Hire (<?= (int)($stats['hire_recommendations'] ?? 0) ?>)</button>
                    <button class="status-filter" data-status="pending">Pending (<?= (int)($stats['pending_recommendations'] ?? 0) ?>)</button>
                    <button class="status-filter" data-status="reject">Reject</button>
                </div>
            </div>

            <div class="cards-grid" id="feedbackContainer" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(400px,1fr));gap:20px;">
                <?php foreach (($feedbacks ?? []) as $feedback): ?>
                    <article id="feedback-<?= (int)$feedback['id'] ?>" class="feedback-card" data-status="<?= strtolower($feedback['recommendation'] ?? 'pending') ?>" data-feedback-id="<?= (int)$feedback['id'] ?>" data-interview-id="<?= (int)$feedback['interview_id'] ?>" style="scroll-margin-top:96px;">
                        <div class="card-header">
                            <div class="company-info">
                                <div class="company-logo"><?= strtoupper(substr($feedback['job_title'] ?? 'FB', 0, 2)) ?></div>
                                <div class="job-info">
                                    <h3 class="job-title"><?= htmlspecialchars($feedback['job_title']) ?></h3>
                                    <p class="company-name"><?= htmlspecialchars($feedback['company']) ?></p>
                                    <p class="location">🗓 <?= date('M d, Y', strtotime($feedback['interview_date'])) ?> • <?= htmlspecialchars($feedback['interview_type']) ?></p>
                                </div>
                            </div>
                            <div class="card-status">
                                <span class="status-badge <?= strtolower($feedback['recommendation'] ?? 'pending') ?>"><?= htmlspecialchars($feedback['recommendation'] ?? 'Pending') ?></span>
                            </div>
                        </div>

                        <div class="note-box">
                            <p><?= !empty($feedback['interview_notes']) ? nl2br(htmlspecialchars($feedback['interview_notes'])) : 'No additional notes provided.' ?></p>
                        </div>

                        <div class="card-details">
                            <div class="detail-item"><span class="detail-label">Reviewer:</span><span class="detail-value"><?= htmlspecialchars($feedback['reviewer'] ?? 'Recruitment Team') ?></span></div>
                            <div class="detail-item"><span class="detail-label">Updated:</span><span class="detail-value"><?= date('M d, Y', strtotime($feedback['feedback_date'])) ?></span></div>
                        </div>

                        <div class="card-actions">
                            <?php if (!empty($feedback['application_id'])): ?>
                                <a href="<?= ROOT ?>/applicant/viewApplication/<?= (int)$feedback['application_id'] ?>" class="btn btn-secondary">Related Application</a>
                            <?php else: ?>
                                <a href="<?= ROOT ?>/applicant/applications" class="btn btn-secondary">Related Application</a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">🧾</div>
                <h3>No feedback found</h3>
                <p>Feedback appears here after interviews are completed and evaluated.</p>
                <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">View Interviews</a>
            </div>
        </div>
    </div>

    <script>
        const filters = document.querySelectorAll('.status-filter');
        const cards = document.querySelectorAll('.feedback-card');
        const emptyState = document.getElementById('emptyState');
        const urlParams = new URLSearchParams(window.location.search);
        const focusFeedbackId = urlParams.get('feedback_id');
        const focusInterviewId = urlParams.get('interview_id');

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

        if (focusFeedbackId || focusInterviewId) {
            cards.forEach((card) => {
                const matchByFeedback = focusFeedbackId && card.dataset.feedbackId === focusFeedbackId;
                const matchByInterview = focusInterviewId && card.dataset.interviewId === focusInterviewId;
                const match = matchByFeedback || matchByInterview;

                card.style.display = match ? 'block' : 'none';
                card.classList.toggle('focused', match);

                if (match) {
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
            emptyState.style.display = document.querySelectorAll('.feedback-card.focused').length === 0 ? 'block' : 'none';
        }
    </script>
</body>

</html>
