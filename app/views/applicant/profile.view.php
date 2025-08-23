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
                <p class="page-subtitle">Manage your personal and professional information</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name"><?= $profile['first_name'] ?> <?= $profile['last_name'] ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($profile['first_name'], 0, 1) . substr($profile['last_name'], 0, 1)) ?></div>
                </div>
            </div>
        </header>

        <div class="profile-content">
            <div class="profile-grid">
                <!-- Profile Overview Card -->
                <div class="profile-overview-card">
                    <div class="profile-header">
                        <div class="profile-avatar-section">
                            <div class="profile-avatar-large">
                                <?= strtoupper(substr($profile['first_name'], 0, 1) . substr($profile['last_name'], 0, 1)) ?>
                            </div>
                            <button class="upload-avatar-btn">📷 Change Photo</button>
                        </div>
                        <div class="profile-basic-info">
                            <h2><?= $profile['first_name'] ?> <?= $profile['last_name'] ?></h2>
                            <p class="profile-email"><?= $profile['email'] ?></p>
                            <p class="profile-phone"><?= $profile['phone'] ?></p>
                            <p class="profile-location"><?= $profile['address'] ?></p>
                        </div>
                    </div>
                    
                    <div class="profile-links">
                        <h4>Professional Links</h4>
                        <div class="links-grid">
                            <?php if (!empty($profile['linkedin'])): ?>
                                <a href="<?= $profile['linkedin'] ?>" target="_blank" class="profile-link">
                                    <span class="link-icon">💼</span>
                                    <span>LinkedIn</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($profile['github'])): ?>
                                <a href="<?= $profile['github'] ?>" target="_blank" class="profile-link">
                                    <span class="link-icon">💻</span>
                                    <span>GitHub</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (!empty($profile['portfolio'])): ?>
                                <a href="<?= $profile['portfolio'] ?>" target="_blank" class="profile-link">
                                    <span class="link-icon">🌐</span>
                                    <span>Portfolio</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="profile-completion">
                        <h4>Profile Completion</h4>
                        <div class="completion-bar">
                            <div class="completion-fill" style="width: 85%"></div>
                        </div>
                        <p class="completion-text">85% Complete</p>
                        <ul class="completion-tips">
                            <li>✅ Basic information added</li>
                            <li>✅ Professional links added</li>
                            <li>⏳ Add more work experience</li>
                            <li>⏳ Upload profile photo</li>
                        </ul>
                    </div>
                </div>

                <!-- Main Profile Content -->
                <div class="profile-main-content">
                    <!-- Personal Information -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Personal Information</h3>
                            <button class="edit-btn" onclick="toggleEdit('personal')">✏️ Edit</button>
                        </div>
                        
                        <div class="section-content" id="personal-view">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>First Name</label>
                                    <span><?= $profile['first_name'] ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Last Name</label>
                                    <span><?= $profile['last_name'] ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Email</label>
                                    <span><?= $profile['email'] ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Phone</label>
                                    <span><?= $profile['phone'] ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Date of Birth</label>
                                    <span><?= date('M d, Y', strtotime($profile['date_of_birth'])) ?></span>
                                </div>
                                <div class="info-item">
                                    <label>Gender</label>
                                    <span><?= $profile['gender'] ?></span>
                                </div>
                                <div class="info-item full-width">
                                    <label>Address</label>
                                    <span><?= $profile['address'] ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-content edit-form" id="personal-edit" style="display: none;">
                            <form class="profile-form">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" value="<?= $profile['first_name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" value="<?= $profile['last_name'] ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" value="<?= $profile['email'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="tel" id="phone" value="<?= $profile['phone'] ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth</label>
                                        <input type="date" id="date_of_birth" value="<?= $profile['date_of_birth'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select id="gender">
                                            <option value="Male" <?= $profile['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= $profile['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                            <option value="Other" <?= $profile['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea id="address" rows="3"><?= $profile['address'] ?></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline" onclick="cancelEdit('personal')">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Professional Links -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Professional Links</h3>
                            <button class="edit-btn" onclick="toggleEdit('links')">✏️ Edit</button>
                        </div>
                        
                        <div class="section-content" id="links-view">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>LinkedIn</label>
                                    <span><?= !empty($profile['linkedin']) ? $profile['linkedin'] : 'Not provided' ?></span>
                                </div>
                                <div class="info-item">
                                    <label>GitHub</label>
                                    <span><?= !empty($profile['github']) ? $profile['github'] : 'Not provided' ?></span>
                                </div>
                                <div class="info-item full-width">
                                    <label>Portfolio</label>
                                    <span><?= !empty($profile['portfolio']) ? $profile['portfolio'] : 'Not provided' ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="section-content edit-form" id="links-edit" style="display: none;">
                            <form class="profile-form">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn Profile</label>
                                    <input type="url" id="linkedin" value="<?= $profile['linkedin'] ?>" placeholder="https://linkedin.com/in/yourprofile">
                                </div>
                                <div class="form-group">
                                    <label for="github">GitHub Profile</label>
                                    <input type="url" id="github" value="<?= $profile['github'] ?>" placeholder="https://github.com/yourusername">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio">Portfolio Website</label>
                                    <input type="url" id="portfolio" value="<?= $profile['portfolio'] ?>" placeholder="https://yourportfolio.com">
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline" onclick="cancelEdit('links')">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Education</h3>
                            <button class="add-btn" onclick="addEducation()">+ Add Education</button>
                        </div>
                        
                        <div class="section-content">
                            <div class="education-list">
                                <?php foreach ($education as $edu): ?>
                                    <div class="education-item">
                                        <div class="education-info">
                                            <h4><?= $edu['degree'] ?></h4>
                                            <p class="institution"><?= $edu['institution'] ?></p>
                                            <p class="duration"><?= $edu['start_year'] ?> - <?= $edu['end_year'] ?></p>
                                            <p class="gpa">GPA: <?= $edu['gpa'] ?></p>
                                        </div>
                                        <div class="education-actions">
                                            <button class="action-btn edit" onclick="editEducation(<?= $edu['id'] ?>)">✏️</button>
                                            <button class="action-btn delete" onclick="deleteEducation(<?= $edu['id'] ?>)">🗑️</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Work Experience</h3>
                            <button class="add-btn" onclick="addExperience()">+ Add Experience</button>
                        </div>
                        
                        <div class="section-content">
                            <div class="experience-list">
                                <?php foreach ($experience as $exp): ?>
                                    <div class="experience-item">
                                        <div class="experience-info">
                                            <h4><?= $exp['position'] ?></h4>
                                            <p class="company"><?= $exp['company'] ?></p>
                                            <p class="duration">
                                                <?= date('M Y', strtotime($exp['start_date'])) ?> - 
                                                <?= $exp['current'] ? 'Present' : date('M Y', strtotime($exp['end_date'])) ?>
                                                <?php if ($exp['current']): ?>
                                                    <span class="current-badge">Current</span>
                                                <?php endif; ?>
                                            </p>
                                            <p class="description"><?= $exp['description'] ?></p>
                                        </div>
                                        <div class="experience-actions">
                                            <button class="action-btn edit" onclick="editExperience(<?= $exp['id'] ?>)">✏️</button>
                                            <button class="action-btn delete" onclick="deleteExperience(<?= $exp['id'] ?>)">🗑️</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h3>Skills</h3>
                            <button class="edit-btn" onclick="toggleEdit('skills')">✏️ Edit</button>
                        </div>
                        
                        <div class="section-content" id="skills-view">
                            <div class="skills-grid">
                                <?php foreach ($skills as $skill): ?>
                                    <span class="skill-tag"><?= $skill ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="section-content edit-form" id="skills-edit" style="display: none;">
                            <form class="profile-form">
                                <div class="form-group">
                                    <label for="skills">Skills (comma-separated)</label>
                                    <textarea id="skills" rows="4" placeholder="Enter your skills separated by commas"><?= implode(', ', $skills) ?></textarea>
                                    <small>Enter your skills separated by commas (e.g., PHP, JavaScript, MySQL)</small>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-outline" onclick="cancelEdit('skills')">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Education Modal -->
    <div id="educationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="educationModalTitle">Add Education</h3>
                <span class="close" onclick="closeEducationModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="educationForm" class="modal-form">
                    <div class="form-group">
                        <label for="degree">Degree/Qualification</label>
                        <input type="text" id="degree" required>
                    </div>
                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" id="institution" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_year">Start Year</label>
                            <input type="number" id="start_year" min="1980" max="2030" required>
                        </div>
                        <div class="form-group">
                            <label for="end_year">End Year</label>
                            <input type="number" id="end_year" min="1980" max="2030" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gpa">GPA/Grade</label>
                        <input type="text" id="gpa">
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="closeEducationModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add/Edit Experience Modal -->
    <div id="experienceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="experienceModalTitle">Add Experience</h3>
                <span class="close" onclick="closeExperienceModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="experienceForm" class="modal-form">
                    <div class="form-group">
                        <label for="position">Position/Title</label>
                        <input type="text" id="position" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" id="company" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date">
                        </div>
                    </div>
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="current_position">
                        <label for="current_position">I currently work here</label>
                    </div>
                    <div class="form-group">
                        <label for="description">Job Description</label>
                        <textarea id="description" rows="4" placeholder="Describe your responsibilities and achievements..."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" onclick="closeExperienceModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/profile.js"></script>
</body>

</html>
