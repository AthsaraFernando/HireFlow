<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Interview Feedback</h1>
        <p class="page-description">Submit feedback for completed interviews</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="btn btn-outline">Schedule More</a>
        </div>
    </div>

    <div class="feedback-list">
        <?php foreach($pending_feedback as $feedback): ?>
        <div class="feedback-card">
            <div class="feedback-header">
                <h3><?= htmlspecialchars($feedback['candidate_name']) ?></h3>
                <span class="job-title"><?= htmlspecialchars($feedback['job_title']) ?></span>
                <span class="status-badge <?= $feedback['status'] ?>"><?= ucfirst($feedback['status']) ?></span>
            </div>
            <div class="feedback-details">
                <div class="detail-item"><strong>Interview Date:</strong> <?= date('M j, Y', strtotime($feedback['interview_date'])) ?></div>
                <div class="detail-item"><strong>Interview Type:</strong> <?= $feedback['interview_type'] ?></div>
            </div>
            <div class="feedback-actions">
                <button class="btn btn-primary" onclick="submitFeedback(<?= $feedback['interview_id'] ?>)">Submit Feedback</button>
                <button class="btn btn-outline">View Interview Notes</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function submitFeedback(interviewId) {
    window.location.href = '<?= ROOT ?>/recruitment/conduct-interview/' + interviewId;
}
</script>

<?php $this->view('components/footer') ?>
