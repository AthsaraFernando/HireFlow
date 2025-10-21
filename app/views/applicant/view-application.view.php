<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/applications.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <style>
        .application-detail-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .detail-section {
            margin-bottom: 25px;
        }
        .detail-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .detail-item-full {
            grid-column: span 2;
        }
        .detail-item label {
            display: block;
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .detail-item p {
            color: #2c3e50;
            font-size: 15px;
            margin: 0;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .cover-letter-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
            line-height: 1.8;
            color: #2c3e50;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
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
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link active">
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
                <div class="breadcrumb" style="margin-bottom: 10px;">
                    <a href="<?= ROOT ?>/applicant/applications" style="color: #3498db; text-decoration: none;">← Back to Applications</a>
                </div>
                <h1 class="page-title">Application Details</h1>
                <p class="page-subtitle">View your application information</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="applications-content">
            <div class="application-detail-card">
                <div class="detail-section">
                    <h3>Job Information</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Job Title</label>
                            <p><?= htmlspecialchars($application['job_title']) ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Company</label>
                            <p><?= htmlspecialchars($application['company']) ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Location</label>
                            <p><?= htmlspecialchars($application['location']) ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Department</label>
                            <p><?= htmlspecialchars($application['department']) ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Employment Type</label>
                            <p><?= htmlspecialchars($application['employment_type']) ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Salary Range</label>
                            <p><?= htmlspecialchars($application['salary']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Application Status</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Current Status</label>
                            <p><span class="status-badge <?= strtolower(str_replace(' ', '-', $application['status'])) ?>"><?= $application['status'] ?></span></p>
                        </div>
                        <div class="detail-item">
                            <label>Applied Date</label>
                            <p><?= $application['applied_date'] ?></p>
                        </div>
                        <div class="detail-item">
                            <label>Application Deadline</label>
                            <p><?= $application['deadline'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Cover Letter</h3>
                    <div class="cover-letter-box">
                        <?= nl2br(htmlspecialchars($application['cover_letter'])) ?>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Resume</h3>
                    <div class="detail-item-full">
                        <a href="<?= ROOT . $application['resume_path'] ?>" target="_blank" class="btn btn-outline">
                            📄 View Resume (PDF)
                        </a>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="<?= ROOT ?>/applicant/applications" class="btn btn-outline">Back to Applications</a>
                    <?php if(in_array($application['status'], ['Applied', 'Under Review'])): ?>
                        <a href="<?= ROOT ?>/applicant/editApplication/<?= $application['id'] ?>" class="btn btn-primary">Edit Application</a>
                        <button onclick="deleteApplication(<?= $application['id'] ?>)" class="btn btn-danger">Delete Application</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteApplication(id) {
            if (confirm('Are you sure you want to delete this application? This action cannot be undone.')) {
                window.location.href = '<?= ROOT ?>/applicant/deleteApplication/' + id;
            }
        }
    </script>
</body>

</html>
