<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/apply.style.css">
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
                <div class="breadcrumb">
                    <a href="<?= ROOT ?>/applicant/jobs">Browse Jobs</a>
                    <span>›</span>
                    <a href="<?= ROOT ?>/applicant/applications">My Applications</a>
                    <span>›</span>
                    <span>Apply</span>
                </div>
                <h1 class="page-title">Apply for Position</h1>
                <p class="page-subtitle"><?= $job['title'] ?> at <?= $job['company'] ?></p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span class="user-name">John Doe</span>
                    <div class="user-avatar">JD</div>
                </div>
            </div>
        </header>

        <div class="apply-content">
            <div class="apply-grid">
                <!-- Application Form -->
                <div class="form-section">
                    <div class="form-card">
                        <div class="form-header">
                            <h2>Application Form</h2>
                            <p>Please fill out all required fields to submit your application</p>
                        </div>

                        <form class="application-form" action="<?= ROOT ?>/applicant/applications/submit" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                            
                            <!-- Personal Information -->
                            <div class="form-section-header">
                                <h3>Personal Information</h3>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <input type="text" id="first_name" name="first_name" value="John" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name *</label>
                                    <input type="text" id="last_name" name="last_name" value="Doe" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" value="john.doe@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" value="+94 77 123 4567" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Address *</label>
                                <textarea id="address" name="address" rows="3" required>123 Main Street, Colombo 03, Sri Lanka</textarea>
                            </div>

                            <!-- Professional Information -->
                            <div class="form-section-header">
                                <h3>Professional Information</h3>
                            </div>

                            <div class="form-group">
                                <label for="experience_years">Years of Experience *</label>
                                <select id="experience_years" name="experience_years" required>
                                    <option value="">Select experience level</option>
                                    <option value="0-1">0-1 years</option>
                                    <option value="1-3" selected>1-3 years</option>
                                    <option value="3-5">3-5 years</option>
                                    <option value="5-10">5-10 years</option>
                                    <option value="10+">10+ years</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="current_position">Current Position</label>
                                <input type="text" id="current_position" name="current_position" value="Freelance Web Developer">
                            </div>

                            <div class="form-group">
                                <label for="current_company">Current Company</label>
                                <input type="text" id="current_company" name="current_company" value="Self Employed">
                            </div>

                            <div class="form-group">
                                <label for="expected_salary">Expected Salary (LKR) *</label>
                                <input type="number" id="expected_salary" name="expected_salary" min="0" value="90000" required>
                            </div>

                            <div class="form-group">
                                <label for="skills">Key Skills *</label>
                                <textarea id="skills" name="skills" rows="3" placeholder="List your key skills separated by commas" required>PHP, JavaScript, MySQL, HTML5, CSS3, React, Node.js, Git</textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn Profile</label>
                                    <input type="url" id="linkedin" name="linkedin" value="https://linkedin.com/in/johndoe">
                                </div>
                                <div class="form-group">
                                    <label for="portfolio">Portfolio Website</label>
                                    <input type="url" id="portfolio" name="portfolio" value="https://johndoe.portfolio.com">
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="form-section-header">
                                <h3>Documents</h3>
                            </div>

                            <div class="form-group">
                                <label for="resume">Resume/CV *</label>
                                <div class="file-upload">
                                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                                    <div class="file-upload-text">
                                        <span>Click to upload or drag and drop</span>
                                        <small>PDF, DOC, DOCX up to 5MB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cover_letter">Cover Letter</label>
                                <div class="file-upload">
                                    <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx">
                                    <div class="file-upload-text">
                                        <span>Click to upload or drag and drop</span>
                                        <small>PDF, DOC, DOCX up to 5MB (Optional)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="other_documents">Other Documents</label>
                                <div class="file-upload">
                                    <input type="file" id="other_documents" name="other_documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <div class="file-upload-text">
                                        <span>Click to upload or drag and drop</span>
                                        <small>Certificates, Portfolio samples, etc. (Optional)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Questions -->
                            <div class="form-section-header">
                                <h3>Additional Information</h3>
                            </div>

                            <div class="form-group">
                                <label for="availability">When can you start? *</label>
                                <select id="availability" name="availability" required>
                                    <option value="">Select availability</option>
                                    <option value="immediately" selected>Immediately</option>
                                    <option value="1-week">1 week</option>
                                    <option value="2-weeks">2 weeks</option>
                                    <option value="1-month">1 month</option>
                                    <option value="2-months">2 months</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="motivation">Why are you interested in this position? *</label>
                                <textarea id="motivation" name="motivation" rows="4" placeholder="Tell us why you're interested in this role and what makes you a good fit..." required>I am excited about this opportunity because it aligns perfectly with my skills in PHP and web development. I am particularly drawn to Tech Solutions Inc.'s innovative approach to software development and would love to contribute to your team's success.</textarea>
                            </div>

                            <div class="form-group">
                                <label for="additional_info">Additional Information</label>
                                <textarea id="additional_info" name="additional_info" rows="3" placeholder="Any additional information you'd like to share..."></textarea>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">
                                    I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> *
                                </label>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="updates" name="updates">
                                <label for="updates">
                                    I would like to receive updates about similar job opportunities
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-actions">
                                <a href="<?= ROOT ?>/applicant/jobs/details?id=<?= $job['id'] ?>" class="btn btn-outline">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Job Summary Sidebar -->
                <div class="job-summary-sidebar">
                    <div class="job-summary-card">
                        <h3>Job Summary</h3>
                        <div class="job-info">
                            <h4><?= $job['title'] ?></h4>
                            <p class="company"><?= $job['company'] ?></p>
                            <div class="job-details">
                                <div class="detail-item">
                                    <span class="label">📍 Location:</span>
                                    <span class="value"><?= $job['location'] ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">💼 Type:</span>
                                    <span class="value"><?= $job['type'] ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">📅 Deadline:</span>
                                    <span class="value deadline"><?= date('M d, Y', strtotime($job['deadline'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tips-card">
                        <h3>Application Tips</h3>
                        <ul class="tips-list">
                            <li>✅ Ensure your resume is up-to-date and relevant</li>
                            <li>📝 Write a compelling cover letter</li>
                            <li>🎯 Highlight skills that match the job requirements</li>
                            <li>📄 Double-check all information before submitting</li>
                            <li>⏰ Submit your application before the deadline</li>
                        </ul>
                    </div>

                    <div class="contact-card">
                        <h3>Need Help?</h3>
                        <p>If you have any questions about the application process, feel free to contact us.</p>
                        <div class="contact-info">
                            <p>📧 support@hireflow.com</p>
                            <p>📞 +94 11 234 5678</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/applicant/apply.js"></script>
</body>

</html>
