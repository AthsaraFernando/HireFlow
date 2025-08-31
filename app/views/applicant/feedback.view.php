<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Feedback - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/feedback.style.css">
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
                    <a href="<?= ROOT ?>/applicant/interviews" class="nav-link">
                        <span class="nav-text">Interview Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link active">
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
                <h1 class="page-title">Interview Feedback</h1>
                <p class="page-subtitle">Review feedback from your completed interviews</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Smith</span>
                    <div class="user-avatar">JS</div>
                </div>
            </div>
        </header>

        <div class="feedback-content">
            <?php if (!empty($feedbacks)): ?>
                <div class="feedback-list">
                    <?php foreach($feedbacks as $feedback): ?>
                    <div class="feedback-card">
                        <div class="feedback-header">
                            <div class="job-info">
                                <h3 class="job-title"><?= $feedback['job_title'] ?></h3>
                                <p class="company-name"><?= $feedback['company'] ?></p>
                                <p class="interview-date">Interview: <?= date('M d, Y', strtotime($feedback['interview_date'])) ?></p>
                            </div>
                            <div class="feedback-meta">
                                <div class="overall-rating">
                                    <span class="rating-label">Overall Rating</span>
                                    <div class="rating-stars">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <span class="star <?= $i <= $feedback['overall_rating'] ? 'filled' : '' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="feedback-status <?= $feedback['status'] ?>"><?= ucfirst($feedback['status']) ?></span>
                            </div>
                        </div>
                        
                        <div class="feedback-scores">
                            <div class="score-item">
                                <span class="score-label">Technical Skills</span>
                                <div class="score-bar">
                                    <div class="score-fill" style="width: <?= ($feedback['technical_score'] / 5) * 100 ?>%"></div>
                                </div>
                                <span class="score-value"><?= $feedback['technical_score'] ?>/5</span>
                            </div>
                            <div class="score-item">
                                <span class="score-label">Communication</span>
                                <div class="score-bar">
                                    <div class="score-fill" style="width: <?= ($feedback['communication_score'] / 5) * 100 ?>%"></div>
                                </div>
                                <span class="score-value"><?= $feedback['communication_score'] ?>/5</span>
                            </div>
                        </div>
                        
                        <div class="feedback-text">
                            <h4>Feedback Comments</h4>
                            <p><?= $feedback['feedback_text'] ?></p>
                        </div>
                        
                        <div class="feedback-footer">
                            <div class="interviewer-info">
                                <span class="interviewer-label">Feedback by:</span>
                                <span class="interviewer-name"><?= $feedback['interviewer'] ?></span>
                                <span class="feedback-date">on <?= date('M d, Y', strtotime($feedback['feedback_date'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">💬</div>
                    <h3>No feedback available</h3>
                    <p>Feedback from completed interviews will appear here</p>
                    <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">View Interviews</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
