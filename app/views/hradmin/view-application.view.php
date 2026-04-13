<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Application Details</h1>
        <p class="page-description">Detailed view of candidate application and profile</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Applications
            </a>
            <button class="btn btn-primary" onclick="scheduleInterview()">
                <i class="icon-calendar"></i>Schedule Interview
            </button>
            <button class="btn btn-success" onclick="shortlistCandidate()">
                <i class="icon-star"></i>Shortlist
            </button>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Application Status -->
    <div class="status-section">
        <div class="status-card">
            <div class="status-info">
                <span class="status-badge <?= strtolower($application['status'] ?? 'pending') ?>"><?= ucfirst($application['status'] ?? 'Pending Review') ?></span>
                <div class="status-details">
                    <span>Applied: <?= $application['applied_date'] ?? 'Jan 18, 2024' ?></span>
                    <span>Last Updated: <?= $application['updated_date'] ?? 'Jan 19, 2024' ?></span>
                </div>
            </div>
            <div class="rating-section">
                <div class="current-rating">
                    <span class="rating-label">Rating:</span>
                    <div class="rating">
                        <span class="star">⭐</span>
                        <span class="star">⭐</span>
                        <span class="star">⭐</span>
                        <span class="star">⭐</span>
                        <span class="star empty">⭐</span>
                        <span class="rating-text">4/5</span>
                    </div>
                </div>
                <button class="btn btn-outline btn-sm" onclick="editRating()">Edit Rating</button>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bar - Integrated into main content -->
    <div class="page-actions-bar">
        <div class="actions-label">Application Actions:</div>
        <div class="page-actions">
            <a href="#" class="page-action-btn primary" onclick="scheduleInterview(); return false;">
                <i class="icon-calendar"></i>Schedule Interview
            </a>
            <a href="#" class="page-action-btn success" onclick="shortlistCandidate(); return false;">
                <i class="icon-check"></i>Shortlist Candidate
            </a>
            <a href="<?= ROOT ?>/hradmin/applications/download-resume/<?= $application['id'] ?? '1' ?>" class="page-action-btn">
                <i class="icon-download"></i>Download Resume
            </a>
            <a href="#" class="page-action-btn" onclick="sendEmail(); return false;">
                <i class="icon-mail"></i>Send Email
            </a>
            <a href="#" class="page-action-btn danger" onclick="rejectCandidate(); return false;">
                <i class="icon-close"></i>Reject Application
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="single-column-layout">
        <!-- Candidate Information -->
            <div class="content-card">
                <h3 class="card-title">Candidate Information</h3>
                <div class="candidate-profile">
                    <div class="profile-header">
                        <div class="profile-image">
                            <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                        </div>
                        <div class="profile-details">
                            <h2 class="candidate-name"><?= htmlspecialchars($application['name'] ?? 'John Smith') ?></h2>
                            <p class="candidate-title"><?= htmlspecialchars($application['current_title'] ?? 'Senior Software Engineer') ?></p>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="icon-email"></i>
                                    <span><?= htmlspecialchars($application['email'] ?? 'john.smith@email.com') ?></span>
                                </div>
                                <div class="contact-item">
                                    <i class="icon-phone"></i>
                                    <span><?= htmlspecialchars($application['phone'] ?? '+1 (555) 123-4567') ?></span>
                                </div>
                                <div class="contact-item">
                                    <i class="icon-location"></i>
                                    <span><?= htmlspecialchars($application['location'] ?? 'San Francisco, CA') ?></span>
                                </div>
                                <?php if(isset($application['linkedin'])): ?>
                                <div class="contact-item">
                                    <i class="icon-linkedin"></i>
                                    <a href="<?= htmlspecialchars($application['linkedin']) ?>" target="_blank">LinkedIn Profile</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Details -->
            <div class="content-card">
                <h3 class="card-title">Application Details</h3>
                <div class="application-info">
                    <div class="info-row">
                        <strong>Position Applied For:</strong>
                        <span><?= htmlspecialchars($application['position'] ?? 'Senior Software Developer') ?></span>
                    </div>
                    <div class="info-row">
                        <strong>Application Source:</strong>
                        <span class="source-tag <?= strtolower($application['source'] ?? 'website') ?>"><?= ucfirst($application['source'] ?? 'Website') ?></span>
                    </div>
                    <div class="info-row">
                        <strong>Years of Experience:</strong>
                        <span><?= $application['experience'] ?? '5' ?> years</span>
                    </div>
                    <div class="info-row">
                        <strong>Expected Salary:</strong>
                        <span><?= htmlspecialchars($application['expected_salary'] ?? '$120,000 - $140,000') ?></span>
                    </div>
                    <div class="info-row">
                        <strong>Availability:</strong>
                        <span><?= htmlspecialchars($application['availability'] ?? 'Immediate') ?></span>
                    </div>
                </div>
            </div>

            <!-- Cover Letter -->
            <div class="content-card">
                <h3 class="card-title">Cover Letter</h3>
                <div class="cover-letter">
                    <?= nl2br(htmlspecialchars($application['cover_letter'] ?? 'Dear Hiring Manager,

I am writing to express my strong interest in the Senior Software Developer position at your company. With over 5 years of experience in full-stack development and a passion for creating innovative solutions, I believe I would be a valuable addition to your engineering team.

In my current role, I have successfully led the development of several high-impact projects, including a customer portal that increased user engagement by 40% and a microservices architecture that improved system performance by 60%. My expertise includes JavaScript, React, Node.js, Python, and cloud technologies like AWS and Docker.

What excites me most about this opportunity is the chance to work on cutting-edge projects that make a real difference. I am particularly drawn to your company\'s commitment to innovation and user-centric design principles.

I would welcome the opportunity to discuss how my skills and experience can contribute to your team\'s continued success. Thank you for considering my application.

Best regards,
John Smith')) ?>
                </div>
            </div>

            <!-- Skills Assessment -->
            <div class="content-card">
                <h3 class="card-title">Skills & Qualifications</h3>
                <div class="skills-section">
                    <div class="skill-category">
                        <h4>Technical Skills</h4>
                        <div class="skills-grid">
                            <span class="skill-tag expert">JavaScript</span>
                            <span class="skill-tag expert">React</span>
                            <span class="skill-tag proficient">Node.js</span>
                            <span class="skill-tag proficient">Python</span>
                            <span class="skill-tag intermediate">AWS</span>
                            <span class="skill-tag intermediate">Docker</span>
                            <span class="skill-tag beginner">Kubernetes</span>
                        </div>
                    </div>
                    <div class="skill-category">
                        <h4>Certifications</h4>
                        <div class="certifications">
                            <div class="cert-item">
                                <span class="cert-name">AWS Certified Solutions Architect</span>
                                <span class="cert-date">2023</span>
                            </div>
                            <div class="cert-item">
                                <span class="cert-name">React Developer Certification</span>
                                <span class="cert-date">2022</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work Experience -->
            <div class="content-card">
                <h3 class="card-title">Work Experience</h3>
                <div class="experience-timeline">
                    <div class="experience-item">
                        <div class="experience-period">2021 - Present</div>
                        <div class="experience-details">
                            <h4>Senior Software Engineer</h4>
                            <p class="company">Tech Solutions Inc.</p>
                            <ul class="achievements">
                                <li>Led development of customer portal serving 50K+ users</li>
                                <li>Improved system performance by 60% through architecture optimization</li>
                                <li>Mentored 3 junior developers and conducted code reviews</li>
                            </ul>
                        </div>
                    </div>
                    <div class="experience-item">
                        <div class="experience-period">2019 - 2021</div>
                        <div class="experience-details">
                            <h4>Software Developer</h4>
                            <p class="company">StartupXYZ</p>
                            <ul class="achievements">
                                <li>Built and maintained React-based web applications</li>
                                <li>Collaborated with design team to implement user interfaces</li>
                                <li>Participated in agile development processes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Timeline - Integrated -->
        <div class="content-card">
            <h3 class="card-title">Application Timeline</h3>
            <div class="timeline-simple">
                <div class="timeline-event">
                    <div class="timeline-date">Jan 19, 2024</div>
                    <div class="timeline-description">Rating updated to 4/5</div>
                </div>
                <div class="timeline-event">
                    <div class="timeline-date">Jan 18, 2024</div>
                    <div class="timeline-description">Application received</div>
                </div>
                <div class="timeline-event">
                    <div class="timeline-date">Jan 18, 2024</div>
                    <div class="timeline-description">Resume uploaded</div>
                </div>
            </div>
        </div>

        <!-- Notes - Integrated -->
        <div class="content-card">
            <h3 class="card-title">Notes & Comments</h3>
            <div class="notes-section">
                <textarea class="notes-input" placeholder="Add your notes about this candidate...

• Technical skills assessment
• Interview feedback
• Cultural fit evaluation
• Next steps" rows="6"></textarea>
                <div class="notes-actions">
                    <button class="btn btn-primary" onclick="saveNotes()">Save Notes</button>
                    <button class="btn btn-secondary" onclick="clearNotes()">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.main-container {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

.header-section {
    margin-bottom: 2rem;
}

.page-title {
    color: #2c3e50;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.page-description {
    color: #6c757d;
    margin-bottom: 1rem;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: #4e31aa;
    color: white;
}

.btn-primary:hover {
    background: #3d2687;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-outline {
    background: white;
    color: #4e31aa;
    border: 1px solid #4e31aa;
}

.btn-outline:hover {
    background: #4e31aa;
    color: white;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-section {
    margin-bottom: 1.5rem;
}

.status-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.status-badge.pending { background: #fff3cd; color: #856404; }
.status-badge.under.review, .status-badge.reviewing { background: #cfe2ff; color: #004085; }
.status-badge.shortlisted { background: #d4edda; color: #155724; }
.status-badge.interviewed { background: #e2e3e5; color: #383d41; }
.status-badge.offered { background: #d1ecf1; color: #0c5460; }
.status-badge.hired { background: #d4edda; color: #155724; }
.status-badge.rejected { background: #f8d7da; color: #721c24; }

.status-details {
    display: flex;
    gap: 1.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.page-actions-bar {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.actions-label {
    font-weight: 600;
    color: #2c3e50;
    min-width: 140px;
}

.page-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    flex: 1;
}

.page-action-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
    background: white;
    color: #495057;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.page-action-btn:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
}

.page-action-btn.primary {
    background: #4e31aa;
    color: white;
    border-color: #4e31aa;
}

.page-action-btn.primary:hover {
    background: #3d2687;
}

.page-action-btn.success {
    background: #28a745;
    color: white;
    border-color: #28a745;
}

.page-action-btn.success:hover {
    background: #218838;
}

.page-action-btn.danger {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
}

.page-action-btn.danger:hover {
    background: #c82333;
}

.single-column-layout {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.content-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.card-title {
    color: #2c3e50;
    font-size: 1.25rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f3f4;
}

.timeline-simple {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.timeline-event {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #4e31aa;
}

.timeline-date {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    min-width: 100px;
}

.timeline-description {
    color: #2c3e50;
}

.candidates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.candidate-card {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.75rem;
}

.candidate-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #4e31aa;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.125rem;
}

.candidate-details {
    flex: 1;
}

.candidate-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.candidate-role {
    color: #6c757d;
    font-size: 0.75rem;
    margin-bottom: 0.5rem;
}

.match-score {
    color: #28a745;
    font-weight: 600;
    font-size: 0.75rem;
}

.view-candidate-btn {
    padding: 0.375rem 0.75rem;
    background: #4e31aa;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.2s;
}

.view-candidate-btn:hover {
    background: #3d2687;
}

.notes-section {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.notes-input {
    width: 100%;
    min-height: 120px;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    resize: vertical;
    font-family: inherit;
    font-size: 0.875rem;
}

.notes-input:focus {
    outline: none;
    border-color: #4e31aa;
    box-shadow: 0 0 0 3px rgba(78, 49, 170, 0.1);
}

.notes-actions {
    display: flex;
    gap: 0.5rem;
}

.candidate-profile {
    margin-bottom: 1.5rem;
}

.profile-header {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.profile-image .avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
}

.candidate-name {
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
}

.candidate-title {
    color: #6c757d;
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.contact-item a {
    color: #4e31aa;
    text-decoration: none;
}

.contact-item a:hover {
    text-decoration: underline;
}

.application-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-row:last-child {
    border-bottom: none;
}

.source-tag {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.source-tag.website { background: #e3f2fd; color: #1976d2; }
.source-tag.linkedin { background: #e8f5e8; color: #388e3c; }
.source-tag.indeed { background: #fff3e0; color: #f57c00; }
.source-tag.referral { background: #f3e5f5; color: #7b1fa2; }

.cover-letter {
    line-height: 1.6;
    color: #2c3e50;
    white-space: pre-line;
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #4e31aa;
}

.skills-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.skill-category h4 {
    margin-bottom: 0.75rem;
    color: #2c3e50;
}

.skills-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.skill-tag {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.skill-tag.expert { background: #d4edda; color: #155724; }
.skill-tag.proficient { background: #cfe2ff; color: #004085; }
.skill-tag.intermediate { background: #fff3cd; color: #856404; }
.skill-tag.beginner { background: #f8d7da; color: #721c24; }

.certifications {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.cert-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.cert-name {
    font-weight: 500;
}

.cert-date {
    color: #6c757d;
    font-size: 0.875rem;
}

.experience-timeline {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.experience-item {
    display: flex;
    gap: 1rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f1f3f4;
}

.experience-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.experience-period {
    min-width: 120px;
    font-weight: 600;
    color: #4e31aa;
    font-size: 0.875rem;
}

.experience-details h4 {
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.company {
    color: #6c757d;
    margin-bottom: 0.75rem;
    font-style: italic;
}

.achievements {
    margin: 0;
    padding-left: 1.25rem;
}

.achievements li {
    margin-bottom: 0.25rem;
    color: #495057;
}

.rating-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.current-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.rating-label {
    font-weight: 500;
    color: #2c3e50;
}

.rating {
    display: flex;
    align-items: center;
    gap: 0.125rem;
}

.star {
    font-size: 0.875rem;
    color: #ffc107;
}

.star.empty {
    color: #e9ecef;
}

.rating-text {
    margin-left: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Icon styles */
.icon-back::before { content: '←'; margin-right: 0.25rem; }
.icon-calendar::before { content: '📅'; margin-right: 0.25rem; }
.icon-star::before { content: '⭐'; margin-right: 0.25rem; }
.icon-check::before { content: '✓'; margin-right: 0.25rem; }
.icon-email::before { content: '📧'; margin-right: 0.25rem; }
.icon-phone::before { content: '📞'; margin-right: 0.25rem; }
.icon-location::before { content: '📍'; margin-right: 0.25rem; }
.icon-linkedin::before { content: '💼'; margin-right: 0.25rem; }
.icon-download::before { content: '⬇️'; margin-right: 0.25rem; }
.icon-mail::before { content: '✉️'; margin-right: 0.25rem; }
.icon-close::before { content: '❌'; margin-right: 0.25rem; }

/* Responsive design */
@media (max-width: 768px) {
    .main-container {
        padding: 1rem;
    }
    
    .page-actions-bar {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .actions-label {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .status-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
    
    .experience-item {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .candidates-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function scheduleInterview() {
    alert('Redirecting to interview scheduling...');
    window.location.href = '<?= ROOT ?>/hradmin/interviewschedule?candidate=<?= $application["id"] ?? "1" ?>';
}

function shortlistCandidate() {
    if (confirm('Shortlist this candidate?')) {
        alert('Candidate shortlisted successfully');
        location.reload();
    }
}

function downloadResume() {
    alert('Downloading resume...');
    // Implement resume download logic
}

function sendEmail() {
    alert('Opening email composer...');
    // Implement email functionality
}

function rejectCandidate() {
    if (confirm('Are you sure you want to reject this candidate? This action cannot be undone.')) {
        alert('Candidate rejected');
        window.location.href = '<?= ROOT ?>/hradmin/applicant-database?tab=applications';
    }
}

function editRating() {
    const newRating = prompt('Enter new rating (1-5):');
    if (newRating && newRating >= 1 && newRating <= 5) {
        alert(`Rating updated to ${newRating}/5`);
        location.reload();
    }
}

function saveNotes() {
    const notes = document.querySelector('.notes-textarea').value;
    if (notes.trim()) {
        alert('Notes saved successfully');
    } else {
        alert('Please enter some notes first');
    }
}
</script>

<?php $this->view('components/footer') ?>
