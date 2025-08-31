<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Candidate Evaluation</h1>
        <p class="page-description">Review and manage candidate evaluations</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <a href="<?= ROOT ?>/recruitment/reports" class="btn btn-outline">View Reports</a>
        </div>
    </div>

    <div class="evaluations-grid">
        <?php foreach($evaluated_candidates as $candidate): ?>
        <div class="evaluation-card">
            <div class="candidate-header">
                <h3><?= htmlspecialchars($candidate['name']) ?></h3>
                <span class="job-title"><?= htmlspecialchars($candidate['job_title']) ?></span>
                <div class="overall-score <?= $candidate['overall_score'] >= 8 ? 'excellent' : ($candidate['overall_score'] >= 7 ? 'good' : 'average') ?>">
                    <?= $candidate['overall_score'] ?>/10
                </div>
            </div>
            <div class="score-breakdown">
                <div class="score-item">
                    <span>Technical:</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: <?= $candidate['technical_score'] * 10 ?>%"></div>
                    </div>
                    <span><?= $candidate['technical_score'] ?>/10</span>
                </div>
                <div class="score-item">
                    <span>Communication:</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: <?= $candidate['communication_score'] * 10 ?>%"></div>
                    </div>
                    <span><?= $candidate['communication_score'] ?>/10</span>
                </div>
                <div class="score-item">
                    <span>Cultural Fit:</span>
                    <div class="score-bar">
                        <div class="score-fill" style="width: <?= $candidate['cultural_fit_score'] * 10 ?>%"></div>
                    </div>
                    <span><?= $candidate['cultural_fit_score'] ?>/10</span>
                </div>
            </div>
            <div class="recommendation">
                <span class="recommendation-badge <?= $candidate['recommendation'] ?>">
                    <?= ucfirst($candidate['recommendation']) ?>
                </span>
                <span class="evaluation-date">Evaluated: <?= date('M j, Y', strtotime($candidate['evaluation_date'])) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->view('components/footer') ?>
