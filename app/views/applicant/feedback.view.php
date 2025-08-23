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
                <p class="page-subtitle">View feedback from your completed interviews</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="feedback-content">
            <!-- Feedback Summary -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon">📝</div>
                        <div class="summary-info">
                            <h3><?= count($feedback_list) ?></h3>
                            <p>Total Feedback</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">⭐</div>
                        <div class="summary-info">
                            <h3><?= !empty($feedback_list) ? number_format(array_sum(array_column($feedback_list, 'overall_rating')) / count($feedback_list), 1) : '0' ?></h3>
                            <p>Average Rating</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">✅</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($feedback_list, function($f) { return $f['status'] !== 'Rejected'; })) ?></h3>
                            <p>Positive Outcomes</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon">📈</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($feedback_list, function($f) { return $f['status'] === 'Under Review'; })) ?></h3>
                            <p>Pending Results</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback List -->
            <div class="feedback-list">
                <?php if (!empty($feedback_list)): ?>
                    <?php foreach ($feedback_list as $feedback): ?>
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div class="feedback-title-section">
                                    <h3 class="job-title"><?= $feedback['job_title'] ?></h3>
                                    <p class="company-name"><?= $feedback['company'] ?></p>
                                    <p class="interview-date">
                                        Interview Date: <?= date('M d, Y', strtotime($feedback['interview_date'])) ?>
                                    </p>
                                    <p class="interviewer">Interviewer: <?= $feedback['interviewer'] ?></p>
                                </div>
                                <div class="feedback-status-section">
                                    <span class="status-badge <?= strtolower(str_replace(' ', '-', $feedback['status'])) ?>">
                                        <?= $feedback['status'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="feedback-ratings">
                                <h4>Performance Ratings</h4>
                                <div class="ratings-grid">
                                    <div class="rating-item">
                                        <span class="rating-label">Overall Rating</span>
                                        <div class="rating-display">
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star <?= $i <= $feedback['overall_rating'] ? 'filled' : '' ?>">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="rating-number"><?= $feedback['overall_rating'] ?>/5</span>
                                        </div>
                                    </div>
                                    
                                    <div class="rating-item">
                                        <span class="rating-label">Technical Skills</span>
                                        <div class="rating-display">
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star <?= $i <= $feedback['technical_skills'] ? 'filled' : '' ?>">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="rating-number"><?= $feedback['technical_skills'] ?>/5</span>
                                        </div>
                                    </div>
                                    
                                    <div class="rating-item">
                                        <span class="rating-label">Communication</span>
                                        <div class="rating-display">
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star <?= $i <= $feedback['communication'] ? 'filled' : '' ?>">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="rating-number"><?= $feedback['communication'] ?>/5</span>
                                        </div>
                                    </div>
                                    
                                    <div class="rating-item">
                                        <span class="rating-label">Problem Solving</span>
                                        <div class="rating-display">
                                            <div class="stars">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star <?= $i <= $feedback['problem_solving'] ? 'filled' : '' ?>">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="rating-number"><?= $feedback['problem_solving'] ?>/5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="feedback-comments">
                                <h4>Interviewer Comments</h4>
                                <div class="comments-content">
                                    <p><?= $feedback['feedback'] ?></p>
                                </div>
                            </div>

                            <div class="feedback-next-steps">
                                <h4>Next Steps</h4>
                                <div class="next-steps-content">
                                    <p><?= $feedback['next_steps'] ?></p>
                                </div>
                            </div>

                            <!-- Performance Chart -->
                            <div class="performance-chart">
                                <h4>Performance Breakdown</h4>
                                <div class="chart-container">
                                    <div class="chart-item">
                                        <div class="chart-label">Technical Skills</div>
                                        <div class="chart-bar">
                                            <div class="chart-fill" style="width: <?= ($feedback['technical_skills'] / 5) * 100 ?>%"></div>
                                        </div>
                                        <div class="chart-value"><?= $feedback['technical_skills'] ?>/5</div>
                                    </div>
                                    
                                    <div class="chart-item">
                                        <div class="chart-label">Communication</div>
                                        <div class="chart-bar">
                                            <div class="chart-fill" style="width: <?= ($feedback['communication'] / 5) * 100 ?>%"></div>
                                        </div>
                                        <div class="chart-value"><?= $feedback['communication'] ?>/5</div>
                                    </div>
                                    
                                    <div class="chart-item">
                                        <div class="chart-label">Problem Solving</div>
                                        <div class="chart-bar">
                                            <div class="chart-fill" style="width: <?= ($feedback['problem_solving'] / 5) * 100 ?>%"></div>
                                        </div>
                                        <div class="chart-value"><?= $feedback['problem_solving'] ?>/5</div>
                                    </div>
                                </div>
                            </div>

                            <div class="feedback-actions">
                                <?php if ($feedback['status'] === 'Under Review'): ?>
                                    <span class="action-info">🕐 Awaiting final decision...</span>
                                <?php elseif ($feedback['status'] === 'Rejected'): ?>
                                    <div class="improvement-section">
                                        <h5>Areas for Improvement</h5>
                                        <ul class="improvement-list">
                                            <?php if ($feedback['technical_skills'] < 4): ?>
                                                <li>💻 Consider strengthening technical skills through practice and learning</li>
                                            <?php endif; ?>
                                            <?php if ($feedback['communication'] < 4): ?>
                                                <li>🗣️ Work on communication skills and clarity of expression</li>
                                            <?php endif; ?>
                                            <?php if ($feedback['problem_solving'] < 4): ?>
                                                <li>🧩 Practice problem-solving and analytical thinking</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                    <span class="action-success">🎉 Great performance! Keep up the excellent work.</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>No Feedback Available</h3>
                        <p>You don't have any interview feedback yet. Complete some interviews to receive feedback from employers.</p>
                        <a href="<?= ROOT ?>/applicant/interviews" class="btn btn-primary">View Interviews</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tips for Improvement -->
            <?php if (!empty($feedback_list)): ?>
                <div class="improvement-tips-section">
                    <div class="tips-card">
                        <h3>Tips for Future Interviews</h3>
                        <div class="tips-content">
                            <div class="tip-category">
                                <h4>🎯 Technical Preparation</h4>
                                <ul>
                                    <li>Practice coding problems and technical questions</li>
                                    <li>Review fundamental concepts in your field</li>
                                    <li>Prepare to explain your past projects in detail</li>
                                    <li>Stay updated with industry trends and technologies</li>
                                </ul>
                            </div>
                            
                            <div class="tip-category">
                                <h4>💬 Communication Skills</h4>
                                <ul>
                                    <li>Practice explaining complex concepts in simple terms</li>
                                    <li>Work on active listening during conversations</li>
                                    <li>Prepare clear examples from your experience</li>
                                    <li>Ask thoughtful questions about the role and company</li>
                                </ul>
                            </div>
                            
                            <div class="tip-category">
                                <h4>🧠 Problem-Solving Approach</h4>
                                <ul>
                                    <li>Break down problems into smaller, manageable parts</li>
                                    <li>Think out loud during problem-solving exercises</li>
                                    <li>Consider multiple approaches before choosing one</li>
                                    <li>Practice behavioral interview questions using STAR method</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/feedback.js"></script>
</body>

</html>
