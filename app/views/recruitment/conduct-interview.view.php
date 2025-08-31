<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Conduct Interview</h1>
        <p class="page-description">Interview with <?= htmlspecialchars($interview['candidate_name']) ?></p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="btn btn-secondary">Back to Schedule</a>
            <a href="<?= $interview['resume_url'] ?>" target="_blank" class="btn btn-outline">View Resume</a>
        </div>
    </div>

    <div class="interview-interface">
        <div class="interview-info-panel">
            <h3>Interview Details</h3>
            <div class="info-grid">
                <div class="info-item"><strong>Candidate:</strong> <?= htmlspecialchars($interview['candidate_name']) ?></div>
                <div class="info-item"><strong>Position:</strong> <?= htmlspecialchars($interview['job_title']) ?></div>
                <div class="info-item"><strong>Date & Time:</strong> <?= date('M j, Y g:i A', strtotime($interview['date'] . ' ' . $interview['time'])) ?></div>
                <div class="info-item"><strong>Duration:</strong> <?= $interview['duration'] ?> minutes</div>
                <div class="info-item"><strong>Type:</strong> <?= $interview['type'] ?></div>
            </div>
        </div>

        <div class="evaluation-form">
            <h3>Live Evaluation</h3>
            <form id="evaluation-form">
                <?php foreach($evaluation_criteria as $criteria): ?>
                <div class="criteria-section">
                    <label><?= $criteria ?></label>
                    <div class="rating-scale">
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <label class="rating-option">
                                <input type="radio" name="<?= strtolower(str_replace(' ', '_', $criteria)) ?>" value="<?= $i ?>">
                                <span class="rating-number"><?= $i ?></span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="notes-section">
                    <label>Interview Notes</label>
                    <textarea name="interview_notes" rows="10" placeholder="Record your observations, candidate responses, and overall impressions..."></textarea>
                </div>

                <div class="recommendation-section">
                    <label>Recommendation</label>
                    <select name="recommendation">
                        <option value="">Select recommendation...</option>
                        <option value="hire">Hire</option>
                        <option value="consider">Consider</option>
                        <option value="reject">Reject</option>
                        <option value="need_more_info">Need More Information</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="saveDraft()">Save Draft</button>
                    <button type="submit" class="btn btn-primary">Submit Evaluation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveDraft() {
    alert('Draft saved successfully!');
}

document.getElementById('evaluation-form').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Submit final evaluation? This cannot be undone.')) {
        alert('Evaluation submitted successfully!');
        window.location.href = '<?= ROOT ?>/recruitment/interview-feedback';
    }
});
</script>

<?php $this->view('components/footer') ?>
