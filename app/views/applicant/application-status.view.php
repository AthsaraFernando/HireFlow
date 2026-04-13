<?php $this->view('components/header') ?>

<!-- Application Status - To Be Built -->

<?php $this->view('components/footer') ?>

<div class="applicant-container">
    <!-- Header Section -->
    <div class="applicant-header">
        <h1>Application Status</h1>
        <p class="subtitle"><?= $application['job_title'] ?> at <?= $application['company'] ?></p>
        <div class="header-actions">
            <a href="<?= ROOT ?>/applicant/my-applications" class="btn btn-outline-white">← Back to Applications</a>
            <a href="<?= ROOT ?>/applicant/job-details/<?= $application['job_id'] ?>" class="btn btn-white">View Job</a>
        </div>
    </div>

    <!-- Application Overview -->
    <div class="status-overview">
        <div class="status-main">
            <!-- Current Status Card -->
            <div class="status-card">
                <div class="status-header">
                    <h3>Current Status: <span class="status-badge <?= $application['status_class'] ?>"><?= $application['status'] ?></span></h3>
                    <div class="last-updated">Last updated: <?= date('M j, Y', strtotime($application['last_updated'])) ?></div>
                </div>
                <div class="progress-container">
                    <div class="progress-label">
                        <span>Application Progress</span>
                        <span><?= $application['progress_percentage'] ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= $application['progress_percentage'] ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline-card">
                <h3>Application Timeline</h3>
                <div class="timeline">
                    <?php foreach ($timeline as $event): ?>
                        <div class="timeline-item <?= $event['status'] ?>">
                            <div class="timeline-icon"><?= $event['icon'] ?></div>
                            <div class="timeline-content">
                                <div class="timeline-date"><?= $event['date'] ?> <?= $event['time'] ?></div>
                                <div class="timeline-title"><?= $event['title'] ?></div>
                                <div class="timeline-description"><?= $event['description'] ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Upcoming Events -->
            <?php if (!empty($upcoming_events)): ?>
                <div class="events-card">
                    <h3>Upcoming Events</h3>
                    <?php foreach ($upcoming_events as $event): ?>
                        <div class="event-item">
                            <div class="event-header">
                                <h4><?= $event['type'] ?></h4>
                                <div class="event-date"><?= date('M j, Y', strtotime($event['date'])) ?> at <?= date('g:i A', strtotime($event['time'])) ?></div>
                            </div>
                            <div class="event-details">
                                <div class="detail-row">
                                    <span class="detail-label">Duration:</span>
                                    <span><?= $event['duration'] ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Location:</span>
                                    <span><?= $event['location'] ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Interviewer:</span>
                                    <span><?= $event['interviewer'] ?></span>
                                </div>
                            </div>
                            <div class="event-notes">
                                <strong>Preparation Notes:</strong>
                                <p><?= $event['preparation_notes'] ?></p>
                            </div>
                            <div class="event-actions">
                                <a href="<?= $event['meeting_link'] ?>" class="btn btn-primary" target="_blank">Join Meeting</a>
                                <a href="mailto:<?= $event['contact_email'] ?>" class="btn btn-outline">Contact Interviewer</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Messages -->
            <?php if (!empty($messages)): ?>
                <div class="messages-card">
                    <h3>Messages from Recruiter</h3>
                    <?php foreach ($messages as $message): ?>
                        <div class="message-item">
                            <div class="message-header">
                                <span class="message-from"><?= $message['from'] ?></span>
                                <span class="message-time"><?= date('M j, Y g:i A', strtotime($message['date'] . ' ' . $message['time'])) ?></span>
                            </div>
                            <div class="message-content"><?= $message['message'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="status-sidebar">
            <!-- Required Actions -->
            <?php if (!empty($required_actions)): ?>
                <div class="sidebar-card">
                    <h4>Required Actions</h4>
                    <?php foreach ($required_actions as $action): ?>
                        <div class="action-item priority-<?= $action['priority'] ?>">
                            <h5><?= $action['title'] ?></h5>
                            <p><?= $action['description'] ?></p>
                            <div class="action-deadline">Deadline: <?= date('M j, Y', strtotime($action['deadline'])) ?></div>
                            <a href="<?= $action['link'] ?>" class="btn btn-sm btn-primary">Complete Action</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Contact Information -->
            <div class="sidebar-card">
                <h4>Contact Information</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <strong>Recruiter:</strong>
                        <span><?= $application['recruiter_name'] ?></span>
                    </div>
                    <div class="contact-item">
                        <strong>Email:</strong>
                        <span><?= $application['recruiter_email'] ?></span>
                    </div>
                </div>
                <a href="mailto:<?= $application['recruiter_email'] ?>" class="btn btn-outline btn-sm">📧 Send Email</a>
            </div>

            <!-- Quick Actions -->
            <div class="sidebar-card">
                <h4>Quick Actions</h4>
                <div class="quick-actions">
                    <button class="action-btn" onclick="printApplication()">🖨️ Print Status</button>
                    <button class="action-btn" onclick="downloadPDF()">📄 Download PDF</button>
                    <button class="action-btn" onclick="shareStatus()">📤 Share Status</button>
                    <button class="action-btn" onclick="setReminder()">⏰ Set Reminder</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-overview {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.status-card,
.timeline-card,
.events-card,
.messages-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.status-badge {
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 600;
}

.last-updated {
    color: #666;
    font-size: 0.9em;
}

.event-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.event-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.event-date {
    color: #667eea;
    font-weight: 600;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.detail-label {
    color: #666;
    font-weight: 500;
}

.event-notes {
    background: white;
    padding: 15px;
    border-radius: 6px;
    margin: 15px 0;
}

.event-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.message-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.message-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.message-from {
    font-weight: 600;
    color: #2c3e50;
}

.message-time {
    color: #666;
    font-size: 0.9em;
}

.message-content {
    color: #666;
    line-height: 1.6;
}

.action-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 3px solid #dee2e6;
}

.action-item.priority-high {
    border-left-color: #e74c3c;
    background: #fdf2f2;
}

.action-item.priority-medium {
    border-left-color: #f39c12;
    background: #fefaf5;
}

.action-item h5 {
    color: #2c3e50;
    margin-bottom: 8px;
}

.action-item p {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 10px;
}

.action-deadline {
    color: #e74c3c;
    font-size: 0.8em;
    font-weight: 600;
    margin-bottom: 10px;
}

.contact-info {
    margin-bottom: 15px;
}

.contact-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

@media (max-width: 768px) {
    .status-overview {
        grid-template-columns: 1fr;
    }
    
    .status-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .event-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .event-actions {
        flex-direction: column;
    }
}
</style>

<script>
function printApplication() {
    window.print();
}

function downloadPDF() {
    alert('PDF download feature will be available soon!');
}

function shareStatus() {
    if (navigator.share) {
        navigator.share({
            title: 'Application Status',
            text: 'Check out my application status',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Status URL copied to clipboard!');
    }
}

function setReminder() {
    alert('Reminder feature will be added in the next update!');
}
</script>

<?php $this->view('components/footer') ?>
