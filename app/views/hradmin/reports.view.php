<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">HR Reports & Analytics</h1>
        <p class="page-description">Comprehensive recruitment analytics and performance insights</p>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="exportReport()">
                <i class="icon-export"></i>Export Report
            </button>
            <button class="btn btn-secondary" onclick="scheduleReport()">
                <i class="icon-schedule"></i>Schedule Report
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

    <!-- Report Filters -->
    <div class="filter-section">
        <div class="filter-header">
            <h3>Report Filters</h3>
            <button class="btn btn-outline btn-sm" onclick="resetFilters()">Reset</button>
        </div>
        <div class="filter-controls">
            <div class="filter-group">
                <label>Date Range</label>
                <select class="filter-select">
                    <option value="7d">Last 7 days</option>
                    <option value="30d" selected>Last 30 days</option>
                    <option value="90d">Last 90 days</option>
                    <option value="1y">Last year</option>
                    <option value="custom">Custom range</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Department</label>
                <select class="filter-select">
                    <option value="">All Departments</option>
                    <option value="engineering">Engineering</option>
                    <option value="design">Design</option>
                    <option value="marketing">Marketing</option>
                    <option value="sales">Sales</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Position Level</label>
                <select class="filter-select">
                    <option value="">All Levels</option>
                    <option value="entry">Entry Level</option>
                    <option value="mid">Mid Level</option>
                    <option value="senior">Senior Level</option>
                    <option value="lead">Lead/Executive</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Report Type</label>
                <select class="filter-select" onchange="changeReportType(this.value)">
                    <option value="overview">Overview</option>
                    <option value="recruitment">Recruitment Funnel</option>
                    <option value="performance">Performance Metrics</option>
                    <option value="diversity">Diversity & Inclusion</option>
                    <option value="cost">Cost Analysis</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Key Metrics Dashboard -->
    <div class="metrics-dashboard">
        <div class="metrics-grid">
            <div class="metric-card primary">
                <div class="metric-header">
                    <h4>Total Applications</h4>
                    <i class="metric-icon">📊</i>
                </div>
                <div class="metric-value">1,247</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>+12.5% vs last month</span>
                </div>
            </div>
            
            <div class="metric-card success">
                <div class="metric-header">
                    <h4>Successful Hires</h4>
                    <i class="metric-icon">✅</i>
                </div>
                <div class="metric-value">89</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>+8.2% vs last month</span>
                </div>
            </div>
            
            <div class="metric-card warning">
                <div class="metric-header">
                    <h4>Avg. Time to Hire</h4>
                    <i class="metric-icon">⏱️</i>
                </div>
                <div class="metric-value">23 days</div>
                <div class="metric-change negative">
                    <span class="change-icon">↘</span>
                    <span>+2 days vs last month</span>
                </div>
            </div>
            
            <div class="metric-card info">
                <div class="metric-header">
                    <h4>Cost per Hire</h4>
                    <i class="metric-icon">💰</i>
                </div>
                <div class="metric-value">$3,450</div>
                <div class="metric-change positive">
                    <span class="change-icon">↗</span>
                    <span>-5.2% vs last month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="charts-grid">
            <!-- Recruitment Funnel Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>Recruitment Funnel</h4>
                    <div class="chart-actions">
                        <button class="chart-btn" onclick="toggleChartView('funnel')">📊</button>
                        <button class="chart-btn" onclick="exportChart('funnel')">💾</button>
                    </div>
                </div>
                <div class="chart-content">
                    <div class="funnel-chart">
                        <div class="funnel-stage" style="width: 100%;">
                            <div class="stage-label">Applications</div>
                            <div class="stage-value">1,247</div>
                        </div>
                        <div class="funnel-stage" style="width: 45%;">
                            <div class="stage-label">Screening</div>
                            <div class="stage-value">562</div>
                        </div>
                        <div class="funnel-stage" style="width: 25%;">
                            <div class="stage-label">Interviews</div>
                            <div class="stage-value">312</div>
                        </div>
                        <div class="funnel-stage" style="width: 15%;">
                            <div class="stage-label">Offers</div>
                            <div class="stage-value">187</div>
                        </div>
                        <div class="funnel-stage" style="width: 7%;">
                            <div class="stage-label">Hires</div>
                            <div class="stage-value">89</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Over Time -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>Applications Over Time</h4>
                    <div class="chart-actions">
                        <button class="chart-btn" onclick="toggleChartView('timeline')">📈</button>
                        <button class="chart-btn" onclick="exportChart('timeline')">💾</button>
                    </div>
                </div>
                <div class="chart-content">
                    <div class="line-chart">
                        <div class="chart-placeholder">
                            <div class="chart-line"></div>
                            <div class="chart-data">
                                <div class="data-point" style="left: 10%; height: 40%;" title="Week 1: 45 applications"></div>
                                <div class="data-point" style="left: 25%; height: 60%;" title="Week 2: 68 applications"></div>
                                <div class="data-point" style="left: 40%; height: 80%;" title="Week 3: 89 applications"></div>
                                <div class="data-point" style="left: 55%; height: 70%;" title="Week 4: 78 applications"></div>
                                <div class="data-point" style="left: 70%; height: 95%;" title="Week 5: 105 applications"></div>
                                <div class="data-point" style="left: 85%; height: 65%;" title="Week 6: 72 applications"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Performance -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>Hiring by Department</h4>
                    <div class="chart-actions">
                        <button class="chart-btn" onclick="toggleChartView('department')">🍰</button>
                        <button class="chart-btn" onclick="exportChart('department')">💾</button>
                    </div>
                </div>
                <div class="chart-content">
                    <div class="pie-chart">
                        <div class="pie-slice engineering" data-percentage="40" title="Engineering: 40%"></div>
                        <div class="pie-slice design" data-percentage="25" title="Design: 25%"></div>
                        <div class="pie-slice marketing" data-percentage="20" title="Marketing: 20%"></div>
                        <div class="pie-slice sales" data-percentage="15" title="Sales: 15%"></div>
                    </div>
                    <div class="pie-legend">
                        <div class="legend-item">
                            <div class="legend-color engineering"></div>
                            <span>Engineering (40%)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color design"></div>
                            <span>Design (25%)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color marketing"></div>
                            <span>Marketing (20%)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color sales"></div>
                            <span>Sales (15%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Source Effectiveness -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4>Application Sources</h4>
                    <div class="chart-actions">
                        <button class="chart-btn" onclick="toggleChartView('sources')">📊</button>
                        <button class="chart-btn" onclick="exportChart('sources')">💾</button>
                    </div>
                </div>
                <div class="chart-content">
                    <div class="bar-chart">
                        <div class="bar-item">
                            <div class="bar-label">Company Website</div>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: 85%;" data-value="425"></div>
                                <div class="bar-value">425</div>
                            </div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-label">LinkedIn</div>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: 65%;" data-value="312"></div>
                                <div class="bar-value">312</div>
                            </div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-label">Indeed</div>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: 45%;" data-value="187"></div>
                                <div class="bar-value">187</div>
                            </div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-label">Referrals</div>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: 30%;" data-value="123"></div>
                                <div class="bar-value">123</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="tables-section">
        <!-- Top Performing Jobs -->
        <div class="table-card">
            <div class="table-header">
                <h4>Top Performing Job Posts</h4>
                <a href="<?= ROOT ?>/hradmin/jobposts" class="view-all-link">View All Jobs</a>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Applications</th>
                            <th>Interviews</th>
                            <th>Hires</th>
                            <th>Conversion Rate</th>
                            <th>Avg. Time to Hire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senior Software Developer</td>
                            <td>156</td>
                            <td>45</td>
                            <td>12</td>
                            <td><span class="rate-good">26.7%</span></td>
                            <td>18 days</td>
                        </tr>
                        <tr>
                            <td>UI/UX Designer</td>
                            <td>89</td>
                            <td>28</td>
                            <td>8</td>
                            <td><span class="rate-excellent">28.6%</span></td>
                            <td>21 days</td>
                        </tr>
                        <tr>
                            <td>Marketing Manager</td>
                            <td>67</td>
                            <td>18</td>
                            <td>5</td>
                            <td><span class="rate-good">27.8%</span></td>
                            <td>25 days</td>
                        </tr>
                        <tr>
                            <td>Project Manager</td>
                            <td>45</td>
                            <td>12</td>
                            <td>3</td>
                            <td><span class="rate-average">25.0%</span></td>
                            <td>30 days</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Interviewer Performance -->
        <div class="table-card">
            <div class="table-header">
                <h4>Interviewer Performance</h4>
                <button class="btn btn-outline btn-sm" onclick="viewInterviewerDetails()">View Details</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Interviewer</th>
                            <th>Interviews Conducted</th>
                            <th>Avg. Rating</th>
                            <th>Hire Rate</th>
                            <th>Feedback Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sarah Johnson</td>
                            <td>28</td>
                            <td>4.3/5</td>
                            <td><span class="rate-excellent">32%</span></td>
                            <td>4.7/5</td>
                        </tr>
                        <tr>
                            <td>Mike Wilson</td>
                            <td>22</td>
                            <td>4.1/5</td>
                            <td><span class="rate-good">28%</span></td>
                            <td>4.5/5</td>
                        </tr>
                        <tr>
                            <td>Emily Chen</td>
                            <td>19</td>
                            <td>4.2/5</td>
                            <td><span class="rate-good">26%</span></td>
                            <td>4.6/5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.filter-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.filter-header h3 {
    margin: 0;
    color: #2c3e50;
}

.filter-controls {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.875rem;
}

.filter-select {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.875rem;
}

.metrics-dashboard {
    margin-bottom: 1.5rem;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.metric-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.metric-card.primary::before { background: #4e31aa; }
.metric-card.success::before { background: #28a745; }
.metric-card.warning::before { background: #ffc107; }
.metric-card.info::before { background: #17a2b8; }

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-header h4 {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
}

.metric-icon {
    font-size: 1.25rem;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.metric-change {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.metric-change.positive {
    color: #28a745;
}

.metric-change.negative {
    color: #dc3545;
}

.change-icon {
    font-weight: bold;
}

.charts-section {
    margin-bottom: 1.5rem;
}

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.chart-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f3f4;
}

.chart-header h4 {
    margin: 0;
    color: #2c3e50;
}

.chart-actions {
    display: flex;
    gap: 0.5rem;
}

.chart-btn {
    padding: 0.5rem;
    border: 1px solid #e9ecef;
    border-radius: 4px;
    background: white;
    cursor: pointer;
    font-size: 0.875rem;
}

.chart-content {
    height: 300px;
    position: relative;
}

/* Funnel Chart */
.funnel-chart {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 1rem 0;
}

.funnel-stage {
    background: linear-gradient(135deg, #4e31aa, #6c49d1);
    color: white;
    padding: 0.75rem;
    margin: 0.25rem 0;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-width: 120px;
    transition: all 0.3s ease;
}

.funnel-stage:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.stage-label {
    font-weight: 600;
}

.stage-value {
    font-weight: 700;
    font-size: 1.125rem;
}

/* Line Chart */
.line-chart {
    height: 100%;
    position: relative;
    background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 6px;
    padding: 1rem;
}

.chart-placeholder {
    height: 100%;
    position: relative;
}

.data-point {
    position: absolute;
    width: 12px;
    height: 12px;
    background: #4e31aa;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    cursor: pointer;
    transform: translateX(-50%);
    bottom: 0;
}

.data-point:hover {
    background: #3d2688;
    transform: translateX(-50%) scale(1.2);
}

/* Pie Chart */
.pie-chart {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: conic-gradient(
        #4e31aa 0% 40%,
        #7b1fa2 40% 65%,
        #388e3c 65% 85%,
        #f57c00 85% 100%
    );
    margin: 0 auto 1rem;
    position: relative;
}

.pie-chart::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100px;
    height: 100px;
    background: white;
    border-radius: 50%;
    transform: translate(-50%, -50%);
}

.pie-legend {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}

.legend-color.engineering { background: #4e31aa; }
.legend-color.design { background: #7b1fa2; }
.legend-color.marketing { background: #388e3c; }
.legend-color.sales { background: #f57c00; }

/* Bar Chart */
.bar-chart {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding: 1rem 0;
}

.bar-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.bar-label {
    min-width: 120px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #2c3e50;
}

.bar-container {
    flex: 1;
    height: 24px;
    background: #f1f3f4;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(135deg, #4e31aa, #6c49d1);
    border-radius: 12px;
    transition: width 0.3s ease;
    position: relative;
}

.bar-value {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: #2c3e50;
}

.tables-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 1.5rem;
}

.table-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f3f4;
}

.table-header h4 {
    margin: 0;
    color: #2c3e50;
}

.view-all-link {
    color: #4e31aa;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

.rate-excellent { color: #28a745; font-weight: 600; }
.rate-good { color: #17a2b8; font-weight: 600; }
.rate-average { color: #ffc107; font-weight: 600; }
.rate-poor { color: #dc3545; font-weight: 600; }

/* Icon styles */
.icon-export::before { content: '📤'; }
.icon-schedule::before { content: '📅'; }

/* Responsive design */
@media (max-width: 768px) {
    .filter-controls {
        grid-template-columns: 1fr;
    }
    
    .metrics-grid {
        grid-template-columns: 1fr;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .tables-section {
        grid-template-columns: 1fr;
    }
    
    .chart-content {
        height: 250px;
    }
    
    .funnel-stage {
        margin: 0.5rem 0;
    }
    
    .bar-label {
        min-width: 80px;
        font-size: 0.75rem;
    }
}
</style>

<script>
function exportReport() {
    alert('Exporting current report as PDF...');
    // Implement export functionality
}

function scheduleReport() {
    alert('Opening report scheduling dialog...');
    // Implement report scheduling
}

function resetFilters() {
    document.querySelectorAll('.filter-select').forEach(select => {
        select.selectedIndex = 0;
    });
    generateReport();
}

function changeReportType(type) {
    alert(`Switching to ${type} report view...`);
    // Implement report type switching
}

function toggleChartView(chartType) {
    alert(`Toggling ${chartType} chart view...`);
    // Implement chart view toggling
}

function exportChart(chartType) {
    alert(`Exporting ${chartType} chart...`);
    // Implement chart export
}

function viewInterviewerDetails() {
    alert('Opening detailed interviewer performance...');
    // Implement detailed view
}

function generateReport() {
    alert('Regenerating report with current filters...');
    // Implement report generation
}

// Auto-refresh data every 5 minutes
setInterval(() => {
    console.log('Refreshing report data...');
    // Implement data refresh
}, 300000);

// Animate charts on load
document.addEventListener('DOMContentLoaded', function() {
    // Animate funnel stages
    document.querySelectorAll('.funnel-stage').forEach((stage, index) => {
        setTimeout(() => {
            stage.style.opacity = '0';
            stage.style.transform = 'translateX(-50px)';
            stage.style.transition = 'all 0.5s ease';
            setTimeout(() => {
                stage.style.opacity = '1';
                stage.style.transform = 'translateX(0)';
            }, 100);
        }, index * 200);
    });
    
    // Animate bar fills
    document.querySelectorAll('.bar-fill').forEach((bar, index) => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500 + index * 100);
    });
});
</script>

<?php $this->view('components/footer') ?>
