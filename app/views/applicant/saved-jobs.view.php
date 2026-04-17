<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Jobs - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/saved-jobs.style.css">
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
                <li class="nav-item"><a href="<?= ROOT ?>/applicant/jobs/savedJobs" class="nav-link active"><span class="nav-text">Saved Jobs</span></a></li>
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
                <h1 class="page-title">Saved Jobs</h1>
                <p class="page-subtitle">Track opportunities and keep private notes before applying.</p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="saved-jobs-content">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if(empty($saved_jobs)): ?>
                <div class="empty-state">
                    <div class="empty-icon">🔖</div>
                    <h3>No saved jobs yet</h3>
                    <p>Save jobs from Browse Jobs or Job Details so you can return later.</p>
                    <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-primary">Browse Jobs</a>
                </div>
            <?php else: ?>
                <div class="saved-jobs-grid">
                    <?php foreach($saved_jobs as $saved_job): ?>
                        <div class="saved-job-card">
                            <div class="card-top">
                                <div>
                                    <h3 class="job-title"><?= htmlspecialchars($saved_job['title']) ?></h3>
                                    <p class="job-subtitle"><?= htmlspecialchars($saved_job['company']) ?> • <?= htmlspecialchars($saved_job['location']) ?></p>
                                </div>
                                <span class="status-badge <?= strtolower($saved_job['job_status']) === 'open' ? 'open' : 'closed' ?>">
                                    <?= htmlspecialchars($saved_job['job_status']) ?>
                                </span>
                            </div>

                            <div class="job-meta">
                                <span>💼 <?= htmlspecialchars($saved_job['employment_type']) ?></span>
                                <span>🏢 <?= htmlspecialchars($saved_job['department']) ?></span>
                                <span>💰 <?= htmlspecialchars($saved_job['salary_range']) ?></span>
                            </div>

                            <p class="job-description"><?= htmlspecialchars(mb_substr($saved_job['description'], 0, 160)) ?><?= mb_strlen($saved_job['description']) > 160 ? '...' : '' ?></p>

                            <form method="POST" action="<?= ROOT ?>/applicant/jobs/savedJobs/updateNote/<?= (int)$saved_job['id'] ?>" class="note-form">
                                <label for="note_<?= (int)$saved_job['id'] ?>">My Note</label>
                                <textarea id="note_<?= (int)$saved_job['id'] ?>" name="note" rows="3"><?= htmlspecialchars($saved_job['note'] ?? '') ?></textarea>
                                <button type="submit" class="btn btn-outline action-btn">Update Note</button>
                            </form>

                            <div class="card-actions">
                                <a href="<?= ROOT ?>/applicant/jobs/details/<?= (int)$saved_job['job_id'] ?>" class="btn btn-outline action-btn">View Job</a>
                                <?php if($saved_job['has_applied']): ?>
                                    <span class="btn btn-secondary action-btn action-static">Applied</span>
                                <?php elseif(strtolower($saved_job['job_status']) === 'open' && $saved_job['form_available']): ?>
                                    <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= (int)$saved_job['job_id'] ?>" class="btn btn-primary action-btn">Apply Now</a>
                                <?php else: ?>
                                    <span class="btn btn-disabled action-btn action-static" title="Application form not yet available">Opening Soon</span>
                                <?php endif; ?>
                                <form method="POST" action="<?= ROOT ?>/applicant/jobs/savedJobs/delete/<?= (int)$saved_job['id'] ?>" onsubmit="return confirm('Remove this job from your saved list?');">
                                    <button type="submit" class="btn btn-danger action-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
