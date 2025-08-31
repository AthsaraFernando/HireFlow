<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Application Details</h1>
        <p class="page-description">Detailed view of candidate application and profile</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/applications" class="btn btn-secondary">
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

        <!-- Similar Candidates - Integrated -->
        <div class="content-card">
            <h3 class="card-title">Similar Candidates</h3>
            <div class="candidates-grid">
                <div class="candidate-card">
                    <div class="candidate-avatar">SJ</div>
                    <div class="candidate-details">
                        <div class="candidate-name">Sarah Johnson</div>
                        <div class="candidate-role">UI/UX Designer</div>
                        <div class="match-score">92% match</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/2" class="view-candidate-btn">View</a>
                </div>
                <div class="candidate-card">
                    <div class="candidate-avatar">MW</div>
                    <div class="candidate-details">
                        <div class="candidate-name">Mike Wilson</div>
                        <div class="candidate-role">Full Stack Developer</div>
                        <div class="match-score">88% match</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/3" class="view-candidate-btn">View</a>
                </div>
                <div class="candidate-card">
                    <div class="candidate-avatar">AL</div>
                    <div class="candidate-details">
                        <div class="candidate-name">Alex Liu</div>
                        <div class="candidate-role">Frontend Developer</div>
                        <div class="match-score">85% match</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/4" class="view-candidate-btn">View</a>
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

.action-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.action-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
    text-align: left;
}

.action-button.primary { background: #4e31aa; color: white; }
.action-button.success { background: #28a745; color: white; }
.action-button.secondary { background: #6c757d; color: white; }
.action-button.warning { background: #dc3545; color: white; }

.action-button:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.timeline {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.timeline-item {
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #4e31aa;
}

.timeline-date {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.timeline-event {
    font-weight: 500;
    color: #2c3e50;
}

.similar-candidates {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.candidate-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.candidate-item .candidate-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.875rem;
}

.candidate-position {
    color: #6c757d;
    font-size: 0.75rem;
}

.view-link {
    color: #4e31aa;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.notes-section {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.notes-textarea {
    width: 100%;
    min-height: 100px;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    resize: vertical;
    font-family: inherit;
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

/* Icon styles */
.icon-back::before { content: '←'; }
.icon-calendar::before { content: '📅'; }
.icon-star::before { content: '⭐'; }
.icon-email::before { content: '📧'; }
.icon-phone::before { content: '📞'; }
.icon-location::before { content: '📍'; }
.icon-linkedin::before { content: '💼'; }
.icon-download::before { content: '⬇️'; }
.icon-reject::before { content: '❌'; }

/* Responsive design */
@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
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
        window.location.href = '<?= ROOT ?>/hradmin/applications';
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
