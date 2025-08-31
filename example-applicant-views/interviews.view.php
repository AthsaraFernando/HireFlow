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
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="interviews-content">
            <!-- Interview Status Summary -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon upcoming">📅</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($interviews, function($interview) { return $interview['status'] === 'Scheduled'; })) ?></h3>
                            <p>Upcoming Interviews</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon completed">✅</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($interviews, function($interview) { return $interview['status'] === 'Completed'; })) ?></h3>
                            <p>Completed Interviews</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon total">📊</div>
                        <div class="summary-info">
                            <h3><?= count($interviews) ?></h3>
                            <p>Total Interviews</p>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-icon this-week">🗓️</div>
                        <div class="summary-info">
                            <h3><?= count(array_filter($interviews, function($interview) { 
                                return $interview['status'] === 'Scheduled' && 
                                       strtotime($interview['interview_date']) <= strtotime('+7 days'); 
                            })) ?></h3>
                            <p>This Week</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-container">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">All Interviews</button>
                        <button class="filter-tab" data-filter="scheduled">Upcoming</button>
                        <button class="filter-tab" data-filter="completed">Completed</button>
                    </div>
                    <div class="filter-options">
                        <select class="filter-select">
                            <option value="">All Types</option>
                            <option value="virtual">Virtual</option>
                            <option value="in-person">In-person</option>
                            <option value="phone">Phone</option>
                        </select>
                        <select class="filter-select">
                            <option value="">Sort by</option>
                            <option value="date-asc">Date (Earliest)</option>
                            <option value="date-desc">Date (Latest)</option>
                            <option value="company">Company</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Interviews List -->
            <div class="interviews-list">
                <?php if (!empty($interviews)): ?>
                    <?php foreach ($interviews as $interview): ?>
                        <div class="interview-card <?= strtolower($interview['status']) ?>">
                            <div class="interview-header">
                                <div class="interview-title-section">
                                    <h3 class="job-title"><?= $interview['job_title'] ?></h3>
                                    <p class="company-name"><?= $interview['company'] ?></p>
                                </div>
                                <div class="interview-status-section">
                                    <span class="status-badge <?= strtolower($interview['status']) ?>">
                                        <?= $interview['status'] ?>
                                    </span>
                                    <span class="interview-type-badge <?= strtolower(str_replace('-', '', $interview['interview_type'])) ?>">
                                        <?= $interview['interview_type'] ?>
                                    </span>
                                </div>
                            </div>

                            <div class="interview-details">
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <span class="detail-label">📅 Date:</span>
                                        <span class="detail-value"><?= date('l, M d, Y', strtotime($interview['interview_date'])) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">⏰ Time:</span>
                                        <span class="detail-value"><?= $interview['interview_time'] ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">👤 Interviewer:</span>
                                        <span class="detail-value"><?= $interview['interviewer'] ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">📍 <?= $interview['interview_type'] === 'Virtual' ? 'Meeting Link' : 'Location' ?>:</span>
                                        <span class="detail-value">
                                            <?php if ($interview['interview_type'] === 'Virtual' && isset($interview['meeting_link'])): ?>
                                                <a href="<?= $interview['meeting_link'] ?>" target="_blank" class="meeting-link">
                                                    Join Meeting
                                                </a>
                                            <?php elseif (isset($interview['location'])): ?>
                                                <?= $interview['location'] ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <?php if (isset($interview['instructions']) && !empty($interview['instructions'])): ?>
                                <div class="interview-instructions">
                                    <h4>Instructions:</h4>
                                    <p><?= $interview['instructions'] ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="interview-actions">
                                <?php if ($interview['status'] === 'Scheduled'): ?>
                                    <div class="action-buttons">
                                        <?php if ($interview['interview_type'] === 'Virtual' && isset($interview['meeting_link'])): ?>
                                            <a href="<?= $interview['meeting_link'] ?>" target="_blank" class="btn btn-primary">
                                                Join Meeting
                                            </a>
                                        <?php endif; ?>
                                        <button class="btn btn-outline" onclick="addToCalendar('<?= $interview['id'] ?>')">
                                            Add to Calendar
                                        </button>
                                        <button class="btn btn-outline" onclick="showPrepTips('<?= $interview['id'] ?>')">
                                            Preparation Tips
                                        </button>
                                    </div>
                                    
                                    <!-- Countdown Timer -->
                                    <div class="countdown-timer">
                                        <div class="countdown" data-date="<?= $interview['interview_date'] ?>" data-time="<?= $interview['interview_time'] ?>">
                                            <div class="countdown-item">
                                                <span class="countdown-number days">0</span>
                                                <span class="countdown-label">Days</span>
                                            </div>
                                            <div class="countdown-item">
                                                <span class="countdown-number hours">0</span>
                                                <span class="countdown-label">Hours</span>
                                            </div>
                                            <div class="countdown-item">
                                                <span class="countdown-number minutes">0</span>
                                                <span class="countdown-label">Minutes</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="completed-info">
                                        <span class="completed-text">✅ Interview completed on <?= date('M d, Y', strtotime($interview['interview_date'])) ?></span>
                                        <a href="<?= ROOT ?>/applicant/interviews/feedback" class="btn btn-outline">View Feedback</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📅</div>
                        <h3>No Interviews Scheduled</h3>
                        <p>You don't have any interviews scheduled yet. Keep applying to jobs to get interview opportunities!</p>
                        <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-primary">Browse Jobs</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Preparation Tips Modal -->
    <div id="prepTipsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Interview Preparation Tips</h3>
                <span class="close" onclick="closePrepTipsModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="tips-section">
                    <h4>Before the Interview</h4>
                    <ul>
                        <li>Research the company and the role thoroughly</li>
                        <li>Review your resume and be ready to discuss your experience</li>
                        <li>Prepare examples of your work and achievements</li>
                        <li>Practice common interview questions</li>
                        <li>Prepare thoughtful questions to ask the interviewer</li>
                        <li>Test your technology (for virtual interviews)</li>
                    </ul>
                </div>
                
                <div class="tips-section">
                    <h4>During the Interview</h4>
                    <ul>
                        <li>Join the meeting 5 minutes early</li>
                        <li>Speak clearly and confidently</li>
                        <li>Listen carefully to questions</li>
                        <li>Provide specific examples in your answers</li>
                        <li>Ask clarifying questions if needed</li>
                        <li>Show enthusiasm and interest</li>
                    </ul>
                </div>
                
                <div class="tips-section">
                    <h4>What to Bring/Have Ready</h4>
                    <ul>
                        <li>Copies of your resume</li>
                        <li>Portfolio or work samples</li>
                        <li>List of references</li>
                        <li>Questions for the interviewer</li>
                        <li>Notebook and pen</li>
                        <li>Valid ID (for in-person interviews)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/interviews.js"></script>
</body>

</html>
