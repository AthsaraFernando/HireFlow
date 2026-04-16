<?php
$page_title = 'Announcements';
$dashboardMap = [
    1 => 'systemadmin/dashboard',
    2 => 'hradmin/dashboard',
    3 => 'recruitment/dashboard',
    4 => 'applicant/dashboard'
];
$dashboardUrl = $dashboardMap[Auth::user_role()] ?? 'home';
?>
<?php $this->view('components/header', ['page_title' => $page_title ?? 'System Admin']); ?>

<style>
    body {
        background-color: white;
    }

    .announcements-main {
        max-width: 1800px;
        margin: 24px auto;
        padding: 0 16px 32px;
        max-height: 1200px;
    }

    .announcements-header {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .announcements-title {
        margin: 0 0 6px;
        color: white;
    }

    .announcements-subtitle {
        margin: 0;
        color: white;
    }

    .announcements-alert {
        margin-bottom: 16px;
    }

    .announcements-admin-card,
    .announcement-item,
    .announcements-empty {
        padding: 16px;
    }

    .announcements-admin-card {
        margin-bottom: 20px;
    }

    .announcements-form-title {
        margin-top: 0;
    }

    .announcements-field {
        margin-bottom: 12px;
    }

    .announcements-label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .announcements-input,
    .announcements-textarea {
        width: 100%;
    }

    .announcements-textarea {
        resize: vertical;
    }

    .announcements-error {
        color: #b91c1c;
    }

    .announcements-actions,
    .announcement-admin-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .announcement-item {
        margin-bottom: 14px;
    }

    .announcement-layout {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
    }

    .announcement-item-title {
        margin: 0 0 8px;
    }

    .announcement-item-message {
        margin: 0 0 10px;
        white-space: pre-wrap;
    }

    .announcement-item-meta,
    .announcements-empty-text {
        color: #64748b;
    }

    .announcements-empty-text {
        margin: 0;
    }

    .announcements-admin-layout {
        display: grid;
        grid-template-columns: minmax(280px, 1fr) minmax(420px, 1.5fr);
        gap: 20px;
        align-items: start;
    }

    .announcements-list {
        min-width: 0;
    }

    @media (max-width: 900px) {
        .announcements-admin-layout {
            grid-template-columns: 1fr;
        }
    }

    .main-header {
        display: none !important;
    }
</style>

<main class="announcements-main">
    <div class="announcements-header">
        <div>
            <h1 class="announcements-title">Announcements</h1>

        </div>
        <a href="<?= ROOT ?>/<?= $dashboardUrl ?>" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if (!empty($flash_message)): ?>
        <div class="alert alert-success announcements-alert"><?= htmlspecialchars($flash_message) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-error announcements-alert"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <?php if ($is_system_admin): ?>
        <div class="announcements-admin-layout">
            <section class="card announcements-admin-card">

                <h2 class="announcements-form-title">
                    <?= !empty($edit_announcement) ? 'Edit Announcement' : 'Create Announcement' ?>
                </h2>

                <form method="POST" action="<?= ROOT ?>/announcements">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                    <?php if (!empty($edit_announcement)): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="announcement_id" value="<?= (int) $edit_announcement['id'] ?>">
                    <?php else: ?>
                        <input type="hidden" name="action" value="create">
                    <?php endif; ?>

                    <div class="announcements-field">
                        <label for="announcement-title" class="announcements-label">Title</label>
                        <input id="announcement-title" type="text" name="title" class="form-input announcements-input"
                            value="<?= htmlspecialchars($edit_announcement['title'] ?? '') ?>" required>
                        <?php if (!empty($errors['title'])): ?>
                            <small class="announcements-error"><?= htmlspecialchars($errors['title']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="announcements-field">
                        <label for="announcement-message" class="announcements-label">Message</label>
                        <textarea id="announcement-message" name="message" rows="16"
                            class="form-input announcements-textarea"
                            required><?= htmlspecialchars($edit_announcement['message'] ?? '') ?></textarea>
                        <?php if (!empty($errors['message'])): ?>
                            <small class="announcements-error"><?= htmlspecialchars($errors['message']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="announcements-actions">
                        <button type="submit"
                            class="btn btn-primary"><?= !empty($edit_announcement) ? 'Update' : 'Publish' ?></button>
                        <?php if (!empty($edit_announcement)): ?>
                            <a href="<?= ROOT ?>/announcements" class="btn btn-secondary">Cancel Edit</a>
                        <?php endif; ?>
                    </div>
                </form>
                
            </section>

            <section class="announcements-list">
                <?php if (!empty($announcements)): ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <article class="card announcement-item">
                            <div class="announcement-layout">
                                <div>
                                    <h3 class="announcement-item-title"><?= htmlspecialchars($announcement['title']) ?></h3>
                                    <p class="announcement-item-message"><?= nl2br(htmlspecialchars($announcement['message'])) ?>
                                    </p>
                                    <small class="announcement-item-meta">
                                        Posted <?= htmlspecialchars(date('M d, Y h:i A', strtotime($announcement['created_at']))) ?>
                                        <?php if (!empty($announcement['author_name'])): ?>
                                            by <?= htmlspecialchars($announcement['author_name']) ?>
                                        <?php endif; ?>
                                    </small>
                                </div>

                                <div class="announcement-admin-actions">
                                    <a href="<?= ROOT ?>/announcements?edit=<?= (int) $announcement['id'] ?>"
                                        class="btn btn-secondary">Edit</a>

                                    <form method="POST" action="<?= ROOT ?>/announcements"
                                        onsubmit="return confirm('Delete this announcement?');">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="announcement_id" value="<?= (int) $announcement['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>

                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card announcements-empty">
                        <p class="announcements-empty-text">No announcements yet.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    <?php else: ?>
        <section>
            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <article class="card announcement-item">
                        <div class="announcement-layout">
                            <div>
                                <h3 class="announcement-item-title"><?= htmlspecialchars($announcement['title']) ?></h3>
                                <p class="announcement-item-message"><?= nl2br(htmlspecialchars($announcement['message'])) ?></p>
                                <small class="announcement-item-meta">
                                    Posted <?= htmlspecialchars(date('M d, Y h:i A', strtotime($announcement['created_at']))) ?>
                                    <?php if (!empty($announcement['author_name'])): ?>
                                        by <?= htmlspecialchars($announcement['author_name']) ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card announcements-empty">
                    <p class="announcements-empty-text">No announcements yet.</p>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<?php  // $this->view('components/footer'); ?>