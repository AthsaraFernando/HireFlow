<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title"><?= htmlspecialchars($job['title'] ?? 'Senior Software Developer') ?></h1>
        <p class="page-description">Job posting details and information</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/job-posts" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Job Posts
            </a>
            <a href="<?= ROOT ?>/hradmin/edit-job/<?= $job['id'] ?? '1' ?>" class="btn btn-primary">
                <i class="icon-edit"></i>Edit Job
            </a>
            <a href="<?= ROOT ?>/hradmin/applications?job=<?= $job['id'] ?? '1' ?>" class="btn btn-outline">
                <i class="icon-applications"></i>View Applications (<?= $job['applications_count'] ?? '23' ?>)
            </a>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Job Status and Metrics -->
    <div class="status-section">
        <div class="status-card">
            <div class="status-info">
                <span class="status-badge <?= strtolower($job['status'] ?? 'active') ?>"><?= ucfirst($job['status'] ?? 'Active') ?></span>
                <div class="status-details">
                    <span>Posted: <?= $job['posted_date'] ?? 'Jan 15, 2024' ?></span>
                    <?php if(isset($job['application_deadline'])): ?>
                        <span>Deadline: <?= $job['application_deadline'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="quick-actions">
                <?php if(($job['status'] ?? 'active') == 'active'): ?>
                    <button class="btn btn-warning btn-sm" onclick="pauseJob()">Pause Job</button>
                <?php elseif(($job['status'] ?? '') == 'paused'): ?>
                    <button class="btn btn-success btn-sm" onclick="activateJob()">Activate Job</button>
                <?php endif; ?>
                <button class="btn btn-info btn-sm" onclick="shareJob()">Share Job</button>
            </div>
        </div>
        
        <div class="metrics-grid">
            <div class="metric-item">
                <div class="metric-value"><?= $job['views_count'] ?? '456' ?></div>
                <div class="metric-label">Views</div>
            </div>
            <div class="metric-item">
                <div class="metric-value"><?= $job['applications_count'] ?? '23' ?></div>
                <div class="metric-label">Applications</div>
            </div>
            <div class="metric-item">
                <div class="metric-value"><?= $job['shortlisted_count'] ?? '8' ?></div>
                <div class="metric-label">Shortlisted</div>
            </div>
            <div class="metric-item">
                <div class="metric-value"><?= $job['interviewed_count'] ?? '5' ?></div>
                <div class="metric-label">Interviewed</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bar - Integrated into main content -->
    <div class="page-actions-bar">
        <div class="actions-label">Available Actions:</div>
        <div class="page-actions">
            <a href="<?= ROOT ?>/hradmin/job-posts/duplicate/<?= $job['id'] ?? '1' ?>" class="page-action-btn">
                <i class="icon-copy"></i>Duplicate Job
            </a>
            <a href="<?= ROOT ?>/hradmin/interview-schedule?job=<?= $job['id'] ?? '1' ?>" class="page-action-btn primary">
                <i class="icon-calendar"></i>Schedule Interviews
            </a>
            <a href="<?= ROOT ?>/hradmin/reports?job=<?= $job['id'] ?? '1' ?>" class="page-action-btn">
                <i class="icon-chart"></i>View Analytics
            </a>
            <button class="page-action-btn danger" onclick="confirmArchive()">
                <i class="icon-archive"></i>Archive Job
            </button>
        </div>
    </div>

    <!-- Job Details - Simplified Structure -->
    <div class="job-details-section">
        <!-- Basic Information -->
        <div class="content-card">
            <h3 class="card-title">Job Information</h3>
            <div class="info-list">
                <div class="info-item">
                    <strong>Department:</strong>
                    <span class="dept-tag <?= strtolower($job['department'] ?? 'engineering') ?>"><?= ucfirst($job['department'] ?? 'Engineering') ?></span>
                </div>
                    <div class="info-item">
                        <strong>Employment Type:</strong>
                        <span><?= ucfirst($job['employment_type'] ?? 'Full-time') ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Experience Level:</strong>
                        <span><?= ucfirst($job['experience_level'] ?? 'Senior') ?> Level</span>
                    </div>
                    <div class="info-item">
                        <strong>Location:</strong>
                        <span><?= htmlspecialchars($job['location'] ?? 'San Francisco, CA') ?></span>
                    </div>
                    <?php if(isset($job['salary_range']) && !empty($job['salary_range'])): ?>
                    <div class="info-item">
                        <strong>Salary Range:</strong>
                        <span><?= htmlspecialchars($job['salary_range']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="info-item">
                        <strong>Openings:</strong>
                        <span><?= $job['openings'] ?? '2' ?> position(s)</span>
                    </div>
                </div>
            </div>

        <!-- Job Description -->
        <div class="content-card">
            <h3 class="card-title">Job Summary</h3>
            <div class="job-content">
                <?= nl2br(htmlspecialchars($job['summary'] ?? $job['description'] ?? 'No summary available.')) ?>
            </div>
        </div>

        <div class="content-card">
            <h3 class="card-title">Key Responsibilities</h3>
            <div class="job-content">
                <?= nl2br(htmlspecialchars($job['responsibilities'] ?? 'No responsibilities specified.')) ?>
                </div>
            </div>

            <div class="content-card">
                <h3 class="card-title">Requirements</h3>
                <div class="job-content">
                    <?= nl2br(htmlspecialchars($job['requirements'] ?? 'No requirements specified.')) ?>
                </div>
            </div>

            <?php if(isset($job['preferred_qualifications']) && !empty($job['preferred_qualifications'])): ?>
            <div class="content-card">
                <h3 class="card-title">Preferred Qualifications</h3>
                <div class="job-content">
                    <?= nl2br(htmlspecialchars($job['preferred_qualifications'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($job['benefits']) && !empty($job['benefits'])): ?>
            <div class="content-card">
                <h3 class="card-title">Benefits & Perks</h3>
                <div class="job-content">
                    <?= nl2br(htmlspecialchars($job['benefits'])) ?>
                </div>
            </div>
            <?php endif; ?>

        <!-- Recent Applications -->
        <div class="content-card">
            <h3 class="card-title">Recent Applications</h3>
            <div class="applications-preview">
                <div class="application-preview-item">
                    <div class="applicant-summary">
                        <div class="applicant-name">John Smith</div>
                        <div class="applicant-details">2 hours ago • 5 years experience</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/1" class="view-btn">View Application</a>
                </div>
                <div class="application-preview-item">
                    <div class="applicant-summary">
                        <div class="applicant-name">Sarah Johnson</div>
                        <div class="applicant-details">5 hours ago • 7 years experience</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/2" class="view-btn">View Application</a>
                </div>
                <div class="application-preview-item">
                    <div class="applicant-summary">
                        <div class="applicant-name">Mike Wilson</div>
                        <div class="applicant-details">1 day ago • 4 years experience</div>
                    </div>
                    <a href="<?= ROOT ?>/hradmin/applications/view/3" class="view-btn">View Application</a>
                </div>
            </div>
            <div class="section-footer">
                <a href="<?= ROOT ?>/hradmin/applications?job=<?= $job['id'] ?? '1' ?>" class="view-all-applications">View All Applications (<?= $job['applications_count'] ?? '23' ?>)</a>
            </div>
        </div>

        <!-- Job Settings - Integrated -->
        <div class="content-card">
            <h3 class="card-title">Job Settings & Information</h3>
            <div class="settings-grid">
                <div class="setting-row">
                    <strong>Hiring Manager:</strong>
                    <span><?= $job['hiring_manager_name'] ?? 'John Smith' ?></span>
                </div>
                <div class="setting-row">
                    <strong>Created by:</strong>
                    <span><?= $job['created_by'] ?? 'HR Admin' ?></span>
                </div>
                <div class="setting-row">
                    <strong>Last Updated:</strong>
                    <span><?= $job['updated_at'] ?? 'Jan 16, 2024' ?></span>
                </div>
                <?php if(isset($job['application_deadline'])): ?>
                <div class="setting-row">
                    <strong>Application Deadline:</strong>
                    <span><?= $job['application_deadline'] ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Share Job Modal -->
<div id="shareModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Share Job Post</h3>
            <button class="modal-close" onclick="closeShareModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="share-option">
                <label>Job URL:</label>
                <div class="url-copy">
                    <input type="text" value="<?= ROOT ?>/jobs/<?= $job['id'] ?? '1' ?>" readonly class="url-input">
                    <button class="copy-btn" onclick="copyUrl()">Copy</button>
                </div>
            </div>
            <div class="share-buttons">
                <button class="share-btn linkedin">Share on LinkedIn</button>
                <button class="share-btn email">Email to Team</button>
                <button class="share-btn internal">Post to Internal Board</button>
            </div>
        </div>
    </div>
</div>

<!-- Close job-details-section and main-container -->
</div>
</div>

<style>
.status-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.status-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.status-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.active { background: #d4edda; color: #155724; }
.status-badge.paused { background: #fff3cd; color: #856404; }
.status-badge.closed { background: #f8d7da; color: #721c24; }
.status-badge.draft { background: #e2e3e5; color: #383d41; }

.quick-actions {
    display: flex;
    gap: 0.5rem;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.metric-item {
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.metric-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4e31aa;
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.main-content, .sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.content-card, .sidebar-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.card-title, .sidebar-title {
    color: #2c3e50;
    margin-bottom: 1rem;
    font-size: 1.125rem;
    font-weight: 600;
    border-bottom: 2px solid #f1f3f4;
    padding-bottom: 0.5rem;
}

.sidebar-title {
    font-size: 1rem;
    margin-bottom: 0.75rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item strong {
    color: #6c757d;
    font-size: 0.875rem;
}

.dept-tag {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    display: inline-block;
    width: fit-content;
}

.dept-tag.engineering { background: #e3f2fd; color: #1976d2; }
.dept-tag.design { background: #f3e5f5; color: #7b1fa2; }
.dept-tag.marketing { background: #e8f5e8; color: #388e3c; }
.dept-tag.sales { background: #fff3e0; color: #f57c00; }
.dept-tag.management { background: #fce4ec; color: #c2185b; }

.job-content {
    line-height: 1.6;
    color: #2c3e50;
    white-space: pre-line;
}

.application-list {
    margin-bottom: 1rem;
}

.application-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.application-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.applicant-name {
    font-weight: 600;
    color: #2c3e50;
}

.applicant-time {
    font-size: 0.875rem;
    color: #6c757d;
}

.view-btn {
    color: #4e31aa;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.view-btn:hover {
    text-decoration: underline;
}

.view-all-link {
    color: #4e31aa;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

.view-all-link:hover {
    text-decoration: underline;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
    font-size: 0.875rem;
}

.setting-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.action-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.action-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    text-decoration: none;
    color: #495057;
    background: white;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.action-link:hover {
    background: #f8f9fa;
    border-color: #ced4da;
}

.action-link.danger {
    border-color: #dc3545;
    color: #dc3545;
}

.action-link.danger:hover {
    background: #dc3545;
    color: white;
}

.btn-outline {
    border: 1px solid #4e31aa;
    color: #4e31aa;
    background: transparent;
}

.btn-outline:hover {
    background: #4e31aa;
    color: white;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.share-option {
    margin-bottom: 1.5rem;
}

.url-copy {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.url-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 0.875rem;
}

.copy-btn {
    padding: 0.5rem 1rem;
    background: #4e31aa;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.share-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.share-btn {
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
}

.share-btn.linkedin { background: #0077b5; color: white; }
.share-btn.email { background: #6c757d; color: white; }
.share-btn.internal { background: #28a745; color: white; }

/* Icon styles */
.icon-back::before { content: '←'; }
.icon-edit::before { content: '✏️'; }
.icon-applications::before { content: '📋'; }
.icon-copy::before { content: '📄'; }
.icon-calendar::before { content: '📅'; }
.icon-chart::before { content: '📊'; }
.icon-archive::before { content: '📦'; }

/* Responsive design */
@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .metrics-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .status-card {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function pauseJob() {
    if (confirm('Are you sure you want to pause this job posting?')) {
        // Make AJAX call to pause job
        alert('Job paused successfully');
        location.reload();
    }
}

function activateJob() {
    if (confirm('Are you sure you want to activate this job posting?')) {
        // Make AJAX call to activate job
        alert('Job activated successfully');
        location.reload();
    }
}

function shareJob() {
    document.getElementById('shareModal').style.display = 'flex';
}

function closeShareModal() {
    document.getElementById('shareModal').style.display = 'none';
}

function copyUrl() {
    const urlInput = document.querySelector('.url-input');
    urlInput.select();
    document.execCommand('copy');
    alert('URL copied to clipboard!');
}

function confirmArchive() {
    if (confirm('Are you sure you want to archive this job? This will remove it from active listings.')) {
        // Make AJAX call to archive job
        alert('Job archived successfully');
        window.location.href = '<?= ROOT ?>/hradmin/jobposts';
    }
}

// Close modal when clicking outside
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeShareModal();
    }
});
</script>

<?php $this->view('components/footer') ?>
