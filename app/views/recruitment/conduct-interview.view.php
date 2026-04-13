<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Conduct Interview</h1>
        <p class="page-description">Interview with <?= htmlspecialchars($interview['candidate_name']) ?></p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/interview-schedule" class="btn btn-secondary">Back to Schedule</a>
            <?php if (!empty($interview['resume_url']) && $interview['resume_url'] !== '#'): ?>
                <a href="<?= htmlspecialchars($interview['resume_url']) ?>" target="_blank" class="btn btn-outline">View Resume</a>
            <?php endif; ?>
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
                <?php foreach($evaluation_criteria as $field => $criteria): ?>
                <div class="criteria-section">
                    <label><?= $criteria ?></label>
                    <input
                        type="number"
                        name="<?= $field ?>"
                        class="search-input score-input"
                        min="1"
                        max="10"
                        required
                        value="<?= isset($existing_feedback[$field]) ? (int) $existing_feedback[$field] : '' ?>"
                        placeholder="Enter 1 to 10"
                    >
                </div>
                <?php endforeach; ?>

                <div class="criteria-section">
                    <label>Manager Points (0 to 50)</label>
                    <input
                        type="number"
                        name="manager_points"
                        id="manager_points"
                        class="search-input score-input"
                        min="0"
                        max="50"
                        required
                        value="<?= isset($existing_feedback['manager_points']) ? (int) $existing_feedback['manager_points'] : '' ?>"
                        placeholder="Enter manager points"
                    >
                </div>

                <div class="criteria-section">
                    <label>Total Points</label>
                    <input type="text" id="total_points" class="search-input" readonly value="0">
                </div>
                
                <div class="notes-section">
                    <label>Interview Notes</label>
                    <textarea name="interview_notes" rows="8" placeholder="Record your observations, candidate responses, and overall impressions..."><?= htmlspecialchars($existing_feedback['interview_notes'] ?? '') ?></textarea>
                </div>

                <div class="recommendation-section">
                    <label>Recommendation</label>
                    <?php $selectedRecommendation = $existing_feedback['recommendation'] ?? ''; ?>
                    <select name="recommendation" required>
                        <option value="">Select recommendation...</option>
                        <option value="Hire" <?= $selectedRecommendation === 'Hire' ? 'selected' : '' ?>>Hire</option>
                        <option value="Reject" <?= $selectedRecommendation === 'Reject' ? 'selected' : '' ?>>Reject</option>
                        <option value="Pending" <?= $selectedRecommendation === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Submit Evaluation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculateTotalPoints() {
    const scoreInputs = document.querySelectorAll('.score-input');
    let total = 0;

    scoreInputs.forEach(input => {
        const value = parseInt(input.value || '0', 10);
        if (!Number.isNaN(value)) {
            total += value;
        }
    });

    document.getElementById('total_points').value = total;
}

document.querySelectorAll('.score-input').forEach(input => {
    input.addEventListener('input', calculateTotalPoints);
});

calculateTotalPoints();

document.getElementById('evaluation-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?= ROOT ?>/recruitment/conduct-interview/submit/<?= (int) $interview['id'] ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        const contentType = response.headers.get('content-type') || '';

        if (!contentType.includes('application/json')) {
            return response.text().then(text => {
                throw new Error('Invalid server response: ' + text.substring(0, 200));
            });
        }

        return response.json();
    })
    .then(result => {
        if (!result.success) {
            const message = result.message || 'Failed to submit evaluation.';
            alert(message);
            console.error(result.errors || {});
            return;
        }

        document.getElementById('total_points').value = result.total_points;
        alert('Feedback submitted. Total points: ' + result.total_points);
        window.location.href = '<?= ROOT ?>/recruitment/shortlist-candidates';
    })
    .catch(error => {
        console.error(error);
        alert('An error occurred while submitting evaluation.');
    });
});
</script>

<?php $this->view('components/footer') ?>
