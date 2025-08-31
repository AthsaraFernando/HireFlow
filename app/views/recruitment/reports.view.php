<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Recruitment Reports</h1>
        <p class="page-description">Analytics and insights for your recruitment activities</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <button class="btn btn-primary">Export Report</button>
        </div>
    </div>

    <div class="analytics-overview">
        <div class="analytics-card">
            <h3>Total Applications</h3>
            <div class="analytics-value"><?= $analytics['total_applications'] ?></div>
        </div>
        <div class="analytics-card">
            <h3>Applications Reviewed</h3>
            <div class="analytics-value"><?= $analytics['applications_reviewed'] ?></div>
        </div>
        <div class="analytics-card">
            <h3>Candidates Shortlisted</h3>
            <div class="analytics-value"><?= $analytics['candidates_shortlisted'] ?></div>
        </div>
        <div class="analytics-card">
            <h3>Interviews Conducted</h3>
            <div class="analytics-value"><?= $analytics['interviews_conducted'] ?></div>
        </div>
        <div class="analytics-card">
            <h3>Candidates Hired</h3>
            <div class="analytics-value"><?= $analytics['candidates_hired'] ?></div>
        </div>
        <div class="analytics-card">
            <h3>Success Rate</h3>
            <div class="analytics-value"><?= $analytics['success_rate'] ?>%</div>
        </div>
    </div>

    <div class="charts-section">
        <div class="chart-card">
            <h3>Monthly Performance</h3>
            <div class="chart-placeholder">
                <div class="chart-bars">
                    <?php foreach($monthly_data as $month): ?>
                    <div class="chart-bar">
                        <div class="bar applications" style="height: <?= $month['applications'] ?>px;"></div>
                        <div class="bar hires" style="height: <?= $month['hires'] * 20 ?>px;"></div>
                        <div class="month-label"><?= $month['month'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="chart-legend">
                    <span class="legend-item"><span class="legend-color applications"></span>Applications</span>
                    <span class="legend-item"><span class="legend-color hires"></span>Hires</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('components/footer') ?>
