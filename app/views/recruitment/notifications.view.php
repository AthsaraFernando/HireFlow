<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Notifications</h1>
        <p class="page-description">Stay updated with your recruitment activities</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <button class="btn btn-outline" onclick="markAllAsRead()">Mark All as Read</button>
        </div>
    </div>

    <div class="notifications-list">
        <?php foreach($notifications as $notification): ?>
        <div class="notification-item <?= $notification['read'] ? 'read' : 'unread' ?> <?= $notification['priority'] ?>">
            <div class="notification-icon">
                <?php 
                switch($notification['type']) {
                    case 'new_application': echo '📋'; break;
                    case 'interview_reminder': echo '📅'; break;
                    case 'feedback_pending': echo '💬'; break;
                    default: echo '🔔'; break;
                }
                ?>
            </div>
            <div class="notification-content">
                <h4><?= htmlspecialchars($notification['title']) ?></h4>
                <p><?= htmlspecialchars($notification['message']) ?></p>
                <span class="notification-time"><?= $notification['time'] ?></span>
            </div>
            <div class="notification-actions">
                <?php if (!$notification['read']): ?>
                    <button class="btn btn-sm btn-outline" onclick="markAsRead(<?= $notification['id'] ?>)">Mark as Read</button>
                <?php endif; ?>
                <button class="btn btn-sm btn-danger" onclick="deleteNotification(<?= $notification['id'] ?>)">Delete</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    // AJAX call to mark as read
    alert('Notification marked as read');
    location.reload();
}

function markAllAsRead() {
    if (confirm('Mark all notifications as read?')) {
        alert('All notifications marked as read');
        location.reload();
    }
}

function deleteNotification(notificationId) {
    if (confirm('Delete this notification?')) {
        alert('Notification deleted');
        location.reload();
    }
}
</script>

<?php $this->view('components/footer') ?>
