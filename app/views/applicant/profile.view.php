<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/profile.style.css">
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
                    <a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link">
                        <span class="nav-text">Interview Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/profile" class="nav-link active">
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
                <h1 class="page-title">My Profile</h1>
                <p class="page-subtitle">Manage your professional information</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'], 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="profile-content">
            <!-- Profile Header Card -->
            <div class="profile-header-card">
                <div class="profile-photo-section">
                    <div class="profile-avatar">
                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                        <button class="avatar-upload" onclick="uploadPhoto()">📷</button>
                    </div>
                </div>
                <div class="profile-basic-info">
                    <h2 class="profile-name"><?= $user['name'] ?></h2>
                    <p class="profile-title"><?= $user['title'] ?></p>
                    <p class="profile-location">📍 <?= $user['location'] ?></p>
                    <div class="profile-contact">
                        <span class="contact-item">📧 <?= $user['email'] ?></span>
                        <span class="contact-item">📱 <?= $user['phone'] ?></span>
                    </div>
                </div>
                <div class="profile-actions">
                    <button class="btn btn-primary" onclick="editProfile()">✏️ Edit Profile</button>
                    <button class="btn btn-outline" onclick="downloadResume()">📄 Download Resume</button>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="profile-main-layout">
                <!-- Left Column -->
                <div class="profile-left-column">
                    <!-- About Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>About Me</h3>
                            <button class="edit-btn" onclick="editSection('about')">✏️</button>
                        </div>
                        <div class="section-content">
                            <p class="profile-bio"><?= $user['bio'] ?></p>
                        </div>
                    </div>

                    <!-- Experience Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Work Experience</h3>
                            <button class="edit-btn" onclick="editSection('experience')">✏️</button>
                        </div>
                        <div class="section-content">
                            <div class="timeline">
                                <?php foreach($user['experience'] as $index => $exp): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <div class="experience-card">
                                                <h4 class="job-title"><?= $exp['title'] ?></h4>
                                                <div class="company-info">
                                                    <span class="company-name"><?= $exp['company'] ?></span>
                                                    <span class="job-duration"><?= $exp['duration'] ?></span>
                                                </div>
                                                <p class="job-description"><?= $exp['description'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Education</h3>
                            <button class="edit-btn" onclick="editSection('education')">✏️</button>
                        </div>
                        <div class="section-content">
                            <div class="education-grid">
                                <?php foreach($user['education'] as $edu): ?>
                                    <div class="education-card">
                                        <div class="education-icon">🎓</div>
                                        <div class="education-details">
                                            <h4><?= $edu['degree'] ?></h4>
                                            <p class="school-name"><?= $edu['school'] ?></p>
                                            <p class="graduation-year"><?= $edu['year'] ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="profile-right-column">
                    <!-- Skills Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Skills</h3>
                            <button class="edit-btn" onclick="editSection('skills')">✏️</button>
                        </div>
                        <div class="section-content">
                            <div class="skills-container">
                                <?php foreach($user['skills'] as $skill): ?>
                                    <span class="skill-tag"><?= $skill ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>


                        </div>
                        <div class="completion-checklist">
                            <div class="checklist-item completed">
                                <span class="check-icon">✅</span>
                                <span>Basic information added</span>
                            </div>
                            <div class="checklist-item completed">
                                <span class="check-icon">✅</span>
                                <span>Work experience added</span>
                            </div>
                            <div class="checklist-item completed">
                                <span class="check-icon">✅</span>
                                <span>Skills listed</span>
                            </div>
                            <div class="checklist-item pending">
                                <span class="check-icon">⏳</span>
                                <span>Profile photo uploaded</span>
                            </div>
                            <div class="checklist-item pending">
                                <span class="check-icon">⏳</span>
                                <span>Resume uploaded</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="profile-section">
                        <h3>Quick Actions</h3>
                        <div class="action-buttons">
                            <button class="action-btn" onclick="shareProfile()">
                                <span class="action-icon">�</span>
                                <span>Share Profile</span>
                            </button>
                            <button class="action-btn" onclick="exportData()">
                                <span class="action-icon">�</span>
                                <span>Export Data</span>
                            </button>
                            <button class="action-btn" onclick="printProfile()">
                                <span class="action-icon">�️</span>
                                <span>Print Profile</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editProfile() {
            alert('Opening profile editor... (Demo mode)');
        }
        
        function editSection(section) {
            alert(`Editing ${section} section... (Demo mode)`);
        }
        
        function uploadPhoto() {
            alert('Photo upload functionality... (Demo mode)');
        }
        
        function downloadResume() {
            alert('Downloading resume... (Demo mode)');
        }
        
        function shareProfile() {
            alert('Sharing profile... (Demo mode)');
        }
        
        function exportData() {
            alert('Exporting profile data... (Demo mode)');
        }
        
        function printProfile() {
            window.print();
        }
    </script>
</body>

</html>
