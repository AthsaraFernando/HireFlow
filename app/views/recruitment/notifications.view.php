<?php $this->view('components/header') ?>

<div>
    <div>
        <h1>Notifications</h1>
        <p>Stay updated with your recruitment activities</p>
        <div>
            <a href="<?= ROOT ?>/recruitment/dashboard">Back to Dashboard</a>
            <button onclick="markAllAsRead()">Mark All as Read</button>
        </div>
    </div>

    <div>
        <?php foreach($notifications as $notification): ?>
        <div>
            <div>
                <?php 
                switch($notification['type']) {
                    case 'new_application': echo '📋'; break;
                    case 'interview_reminder': echo '📅'; break;
                    case 'feedback_pending': echo '💬'; break;
                    default: echo '🔔'; break;
                }
                ?>
            </div>
            <div>
                <h4><?= htmlspecialchars($notification['title']) ?></h4>
                <p><?= htmlspecialchars($notification['message']) ?></p>
                <span><?= $notification['time'] ?></span>
            </div>
            <div>
                <?php if (!$notification['read']): ?>
                    <button onclick="markAsRead(<?= $notification['id'] ?>)">Mark as Read</button>
                <?php endif; ?>
                <button onclick="deleteNotification(<?= $notification['id'] ?>)">Delete</button>
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
