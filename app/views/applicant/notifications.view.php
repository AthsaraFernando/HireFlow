<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/dashboard.style.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/notifications.style.css?v=<?= time() ?>">
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
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs" class="nav-link"><span class="nav-text">Browse Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/applications" class="nav-link"><span class="nav-text">My Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link"><span class="nav-text">Saved Jobs</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/interviews" class="nav-link"><span class="nav-text">Interview Schedule</span></a></li>
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
                <h1 class="page-title">Notifications</h1>
                <p class="page-subtitle">Interview and feedback updates for your applications.</p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($user['name'] ?? 'User') ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="notifications-content">
            <section class="notifications-hero">
                <div>
                    <p class="hero-kicker">Live feed</p>
                    <h2>Your latest updates</h2>
                    <p class="hero-copy">Interview schedule and feedback updates are synced into your notification center.</p>
                </div>
                <div class="notifications-summary">
                    <div class="summary-card">
                        <span class="summary-value"><?= (int)($unread_count ?? 0) ?></span>
                        <span class="summary-label">Unread updates</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-value"><?= (int)($total_count ?? 0) ?></span>
                        <span class="summary-label">Total records</span>
                    </div>
                </div>
            </section>

            <section class="notifications-panel">
                <?php if (empty($notifications)): ?>
                    <div class="empty-state">
                        <h3>No notifications yet</h3>
                        <p>Once an interview is scheduled, rescheduled, canceled, or a feedback update is available, it will appear here.</p>
                        <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">Go to interview schedule</a>
                    </div>
                <?php else: ?>
                    <?php
                    $resolveNotificationTag = function (array $notification): array {
                        $title = strtolower((string)($notification['title'] ?? ''));
                        $message = strtolower((string)($notification['message'] ?? ''));
                        $type = strtolower((string)($notification['type'] ?? 'info'));
                        $text = $title . ' ' . $message;

                        if (strpos($text, 'reject') !== false) {
                            return ['label' => 'Rejected', 'class' => 'error'];
                        }

                        if (strpos($text, 'hire') !== false || strpos($text, 'offer') !== false) {
                            return ['label' => 'Hired', 'class' => 'success'];
                        }

                        if (strpos($text, 'shortlist') !== false) {
                            return ['label' => 'Shortlisted', 'class' => 'success'];
                        }

                        if (strpos($text, 'cancel') !== false) {
                            return ['label' => 'Canceled', 'class' => 'warning'];
                        }

                        if (strpos($text, 'reschedule') !== false) {
                            return ['label' => 'Rescheduled', 'class' => 'info'];
                        }

                        if (strpos($text, 'schedule') !== false) {
                            return ['label' => 'Scheduled', 'class' => 'info'];
                        }

                        if ($type === 'error' || $type === 'warning') {
                            return ['label' => 'Rejected', 'class' => 'error'];
                        }

                        if ($type === 'success') {
                            return ['label' => 'Hired', 'class' => 'success'];
                        }

                        return ['label' => 'Update', 'class' => 'info'];
                    };
                    ?>
                    <div class="notifications-grid" id="notificationsGrid">
                        <?php foreach ($notifications as $notification): ?>
                            <?php $tag = $resolveNotificationTag($notification); ?>
                            <article class="notification-card <?= htmlspecialchars($notification['category'] ?? 'interview') ?> <?= !empty($notification['is_read']) ? 'read' : 'unread' ?>" data-notification-id="<?= (int)$notification['id'] ?>">
                                <div class="notification-card-header">
                                    <div>
                                        <p class="notification-eyebrow"><?= htmlspecialchars(ucfirst($notification['category'] ?? 'interview')) ?></p>
                                        <h3><?= htmlspecialchars($notification['title']) ?></h3>
                                    </div>
                                    <span class="notification-type <?= htmlspecialchars($tag['class']) ?>"><?= htmlspecialchars($tag['label']) ?></span>
                                </div>

                                <p class="notification-message"><?= htmlspecialchars($notification['message']) ?></p>

                                <div class="notification-meta">
                                    <span class="notification-read-label"><?= !empty($notification['is_read']) ? 'Read' : 'Unread' ?></span>
                                    <span><?= htmlspecialchars($notification['created_at_display'] ?? '') ?></span>
                                </div>

                                <div class="notification-actions">
                                    <a href="<?= htmlspecialchars($notification['link'] ?? '#') ?>" class="btn btn-primary notification-open-link"><?= htmlspecialchars($notification['link_label'] ?? 'Open') ?></a>
                                    <?php if (empty($notification['is_read'])): ?>
                                        <button type="button" class="btn btn-secondary notification-mark-read">Mark as read</button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-outline notification-delete">Delete</button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <script>
        (function () {
            const grid = document.getElementById('notificationsGrid');
            if (!grid) {
                return;
            }

            const markReadUrl = '<?= ROOT ?>/applicant/notifications/mark-read';
            const deleteUrl = '<?= ROOT ?>/applicant/notifications/delete';

            const postForm = async (url, payload) => {
                const body = new URLSearchParams(payload);
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'Accept': 'application/json'
                    },
                    body,
                    credentials: 'same-origin'
                });

                return response.json();
            };

            const applyReadState = (card) => {
                card.classList.remove('unread');
                card.classList.add('read');
                const label = card.querySelector('.notification-read-label');
                if (label) {
                    label.textContent = 'Read';
                }

                const markButton = card.querySelector('.notification-mark-read');
                if (markButton) {
                    markButton.remove();
                }
            };

            grid.addEventListener('click', async (event) => {
                const card = event.target.closest('.notification-card');
                if (!card) {
                    return;
                }

                const notificationId = Number(card.dataset.notificationId || 0);
                if (!notificationId) {
                    return;
                }

                if (event.target.closest('.notification-delete')) {
                    event.preventDefault();

                    const result = await postForm(deleteUrl, { notification_id: notificationId });
                    if (result && result.success) {
                        card.remove();
                    }
                    return;
                }

                if (event.target.closest('.notification-mark-read')) {
                    event.preventDefault();

                    const result = await postForm(markReadUrl, { notification_id: notificationId });
                    if (result && result.success) {
                        applyReadState(card);
                    }
                    return;
                }

                const openLink = event.target.closest('.notification-open-link');
                if (openLink) {
                    event.preventDefault();

                    const result = await postForm(markReadUrl, { notification_id: notificationId });
                    if (result && result.success) {
                        applyReadState(card);
                    }

                    const href = openLink.getAttribute('href');
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                }
            });
        })();
    </script>
</body>
</html>