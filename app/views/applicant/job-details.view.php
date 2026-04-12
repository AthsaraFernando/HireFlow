<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $job['title'] ?> - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/job-details.style.css">
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
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link active">
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
                <div class="breadcrumb">
                    <a href="<?= ROOT ?>/applicant/jobs" class="breadcrumb-link">Browse Jobs</a>
                    <span class="breadcrumb-separator">›</span>
                    <span class="breadcrumb-current">Job Details</span>
                </div>
                <h1 class="page-title"><?= $job['title'] ?></h1>
                <p class="page-subtitle"><?= $job['company'] ?> • <?= $job['location'] ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Smith</span>
                    <div class="user-avatar">JS</div>
                </div>
            </div>
        </header>

        <div class="job-details-content">
            <div class="job-main">
                <!-- Job Header Card -->
                <div class="job-header-card">
                    <div class="job-header-info">
                        <div class="company-logo"><?= strtoupper(substr($job['company'], 0, 2)) ?></div>
                        <div class="job-title-section">
                            <h2><?= $job['title'] ?></h2>
                            <p class="company-name"><?= $job['company'] ?></p>
                            <div class="job-meta">
                                <span class="meta-item">📍 <?= $job['location'] ?></span>
                                <span class="meta-item">💼 <?= $job['type'] ?></span>
                                <?php if($job['remote']): ?>
                                    <span class="meta-item remote">🌐 Remote Work Available</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="job-header-actions">
                        <div class="salary-info">
                            <span class="salary-label">Salary Range</span>
                            <span class="salary-value"><?= $job['salary'] ?></span>
                        </div>
                        <?php if($job['has_applied']): ?>
                            <div class="btn btn-secondary btn-large" style="cursor: default; text-align: center;">
                                ✓ Already Applied
                            </div>
                        <?php elseif($job['form_available']): ?>
                            <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary btn-large">Apply Now</a>
                        <?php else: ?>
                            <div class="btn btn-disabled btn-large" style="cursor: not-allowed; text-align: center; opacity: 0.6;" title="Application form not yet available">
                                Opening Soon
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Job Information Section -->
                <div class="content-card">
                    <h3 class="section-title">Job Information</h3>
                    <div class="job-info-grid">
                        <div class="info-grid-item">
                            <span class="info-label">Department</span>
                            <span class="info-value"><?= $job['department'] ?></span>
                        </div>
                        <div class="info-grid-item">
                            <span class="info-label">Employment Type</span>
                            <span class="info-value"><?= $job['type'] ?></span>
                        </div>
                        <div class="info-grid-item">
                            <span class="info-label">Experience Level</span>
                            <span class="info-value"><?= $job['experience_level'] ?></span>
                        </div>
                        <div class="info-grid-item">
                            <span class="info-label">Location</span>
                            <span class="info-value"><?= $job['location'] ?></span>
                        </div>
                        <div class="info-grid-item">
                            <span class="info-label">Salary Range</span>
                            <span class="info-value"><?= $job['salary'] ?></span>
                        </div>
                        <div class="info-grid-item">
                            <span class="info-label">Application Deadline</span>
                            <span class="info-value"><?= $job['deadline'] ? date('M d, Y', strtotime($job['deadline'])) : 'Not specified' ?></span>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="content-card">
                    <h3 class="section-title">Job Description</h3>
                    <div class="job-description">
                        <p><?= $job['description'] ?></p>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="content-card">
                    <h3 class="section-title">Requirements</h3>
                    <ul class="requirements-list">
                        <?php foreach($job['requirements'] as $requirement): ?>
                            <li><?= $requirement ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Benefits -->
                <div class="content-card">
                    <h3 class="section-title">Benefits & Perks</h3>
                    <div class="benefits-grid">
                        <?php foreach($job['benefits'] as $benefit): ?>
                            <div class="benefit-item">
                                <span class="benefit-icon">✅</span>
                                <span><?= $benefit ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="job-sidebar">
                <!-- Quick Apply Card -->
                <div class="sidebar-card">
                    <h4>Quick Apply</h4>
                    <p>Ready to join <?= $job['company'] ?>?</p>
                    <?php if($job['has_applied']): ?>
                        <div class="btn btn-secondary btn-full" style="cursor: default; text-align: center;">
                            ✓ Already Applied
                        </div>
                    <?php elseif($job['form_available']): ?>
                        <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary btn-full">Apply Now</a>
                    <?php else: ?>
                        <div class="btn btn-disabled btn-full" style="cursor: not-allowed; text-align: center; opacity: 0.6;" title="Application form not yet available">
                            Opening Soon
                        </div>
                    <?php endif; ?>
                    <a href="<?= ROOT ?>/applicant/jobs" class="btn btn-outline btn-full">Back to Jobs</a>
                </div>

                <!-- Job Info Card -->
                <div class="sidebar-card">
                    <h4>Job Information</h4>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Posted Date:</span>
                            <span class="info-value"><?= date('M d, Y', strtotime($job['posted_date'])) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Application Deadline:</span>
                            <span class="info-value"><?= date('M d, Y', strtotime($job['deadline'])) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Job Type:</span>
                            <span class="info-value"><?= $job['type'] ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Location:</span>
                            <span class="info-value"><?= $job['location'] ?></span>
                        </div>
                        <?php if($job['remote']): ?>
                        <div class="info-item">
                            <span class="info-label">Remote Work:</span>
                            <span class="info-value">Available</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Share Job Card -->
                <div class="sidebar-card">
                    <h4>Share This Job</h4>
                    <div class="share-buttons">
                        <button class="share-btn" onclick="shareJob('twitter')">📱 Twitter</button>
                        <button class="share-btn" onclick="shareJob('linkedin')">💼 LinkedIn</button>
                        <button class="share-btn" onclick="shareJob('copy')">🔗 Copy Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareJob(platform) {
            const jobTitle = "<?= $job['title'] ?>";
            const company = "<?= $job['company'] ?>";
            const url = window.location.href;
            
            if (platform === 'copy') {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Job link copied to clipboard!');
                });
            } else {
                alert(`Sharing "${jobTitle}" at ${company} on ${platform}... (Demo mode)`);
            }
        }
    </script>
</body>

</html>
