<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Data Analytics & Reports</h1>
        <p class="page-description">Comprehensive view of system data and analytics</p>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <p><?php echo $success ?></p>
        </div>
    <?php endif; ?>

    <!-- Data Overview Cards -->
    <div class="card-grid">
        <div class="metric-card">
            <div class="metric-value">24,567</div>
            <div class="metric-label">Total Records</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">3.2 GB</div>
            <div class="metric-label">Database Size</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">98.7%</div>
            <div class="metric-label">Data Integrity</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">156</div>
            <div class="metric-label">Active Connections</div>
        </div>
    </div>

    <!-- Data Navigation Tabs -->
    <div class="tab-container">
        <div class="tab-nav">
            <button class="tab-btn active" onclick="showTab('users')">Users Data</button>
            <button class="tab-btn" onclick="showTab('jobs')">Jobs Data</button>
            <button class="tab-btn" onclick="showTab('applications')">Applications Data</button>
            <button class="tab-btn" onclick="showTab('interviews')">Interviews Data</button>
        </div>

        <!-- Users Data Tab -->
        <div id="users-tab" class="tab-content active">
            <div class="data-section">
                <div class="section-header">
                    <h3>Users Overview</h3>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" onclick="exportUserData()">
                            Export
                        </button>
                    
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">156</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">12</div>
                        <div class="stat-label">System Admins</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">28</div>
                        <div class="stat-label">HR Admins</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">45</div>
                        <div class="stat-label">Recruiters</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">71</div>
                        <div class="stat-label">Applicants</div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="usersChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Jobs Data Tab -->
        <div id="jobs-tab" class="tab-content">
            <div class="data-section">
                <div class="section-header">
                    <h3>Job Postings Overview</h3>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" onclick="exportJobData()">
                            <i class="icon-download"></i>Export
                        </button>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">342</div>
                        <div class="stat-label">Total Jobs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">89</div>
                        <div class="stat-label">Active Jobs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">156</div>
                        <div class="stat-label">Filled Positions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">97</div>
                        <div class="stat-label">Closed Jobs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">23</div>
                        <div class="stat-label">Draft Jobs</div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="jobsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Applications Data Tab -->
        <div id="applications-tab" class="tab-content">
            <div class="data-section">
                <div class="section-header">
                    <h3>Applications Overview</h3>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" onclick="exportApplicationData()">
                            <i class="icon-download"></i>Export
                        </button>

                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">1,247</div>
                        <div class="stat-label">Total Applications</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">342</div>
                        <div class="stat-label">Under Review</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">156</div>
                        <div class="stat-label">Shortlisted</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">89</div>
                        <div class="stat-label">Interviewed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">67</div>
                        <div class="stat-label">Hired</div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="applicationsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Interviews Data Tab -->
        <div id="interviews-tab" class="tab-content">
            <div class="data-section">
                <div class="section-header">
                    <h3>Interviews Overview</h3>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" onclick="exportInterviewData()">
                            <i class="icon-download"></i>Export
                        </button>

                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">456</div>
                        <div class="stat-label">Total Interviews</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">89</div>
                        <div class="stat-label">Scheduled</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">234</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">23</div>
                        <div class="stat-label">Cancelled</div>
                    </div>

                </div>

                <div class="chart-container">
                    <canvas id="interviewsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Analytics Tab -->
        <div id="analytics-tab" class="tab-content">
            <div class="data-section">
                <div class="section-header">
                    <h3>Advanced Analytics</h3>
                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="generateReport()">
                            <i class="icon-chart"></i>Generate Report
                        </button>
                        <button class="btn btn-secondary" onclick="exportAnalytics()">
                            <i class="icon-download"></i>Export Analytics
                        </button>
                    </div>
                </div>
                
                <div class="analytics-grid">
                    <div class="analytics-card">
                        <h4>Hiring Funnel</h4>
                        <div class="funnel-stats">
                            <div class="funnel-item">
                                <span class="funnel-label">Applications</span>
                                <span class="funnel-value">1,247</span>
                                <div class="funnel-bar" style="width: 100%"></div>
                            </div>
                            <div class="funnel-item">
                                <span class="funnel-label">Screening</span>
                                <span class="funnel-value">623</span>
                                <div class="funnel-bar" style="width: 50%"></div>
                            </div>
                            <div class="funnel-item">
                                <span class="funnel-label">Interviews</span>
                                <span class="funnel-value">312</span>
                                <div class="funnel-bar" style="width: 25%"></div>
                            </div>
                            <div class="funnel-item">
                                <span class="funnel-label">Offers</span>
                                <span class="funnel-value">89</span>
                                <div class="funnel-bar" style="width: 7%"></div>
                            </div>
                            <div class="funnel-item">
                                <span class="funnel-label">Hires</span>
                                <span class="funnel-value">67</span>
                                <div class="funnel-bar" style="width: 5%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="analytics-card">
                        <h4>Time-to-Hire Metrics</h4>
                        <div class="metric-item">
                            <span class="metric-name">Average Time-to-Hire</span>
                            <span class="metric-value">23 days</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Fastest Hire</span>
                            <span class="metric-value">7 days</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Longest Hire</span>
                            <span class="metric-value">67 days</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Target Time</span>
                            <span class="metric-value">21 days</span>
                        </div>
                    </div>

                    <div class="analytics-card">
                        <h4>Success Rates</h4>
                        <div class="metric-item">
                            <span class="metric-name">Application Success Rate</span>
                            <span class="metric-value">5.4%</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Interview Success Rate</span>
                            <span class="metric-value">21.5%</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Offer Acceptance Rate</span>
                            <span class="metric-value">75.3%</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-name">Employee Retention (1yr)</span>
                            <span class="metric-value">89.2%</span>
                        </div>
                    </div>
                </div>

                <div class="trend-analysis">
                    <h4>Trend Analysis (Last 6 Months)</h4>
                    <canvas id="trendChart" width="800" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Export Modal -->
    <div id="exportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Export Data</h2>
                <span class="close" onclick="closeExportModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="form-group">
                        <label for="exportFormat">Export Format</label>
                        <select id="exportFormat" name="exportFormat">
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel (XLSX)</option>
                            <option value="pdf">PDF Report</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="dateRange">Date Range</label>
                        <select id="dateRange" name="dateRange">
                            <option value="all">All Time</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_3months">Last 3 Months</option>
                            <option value="last_6months">Last 6 Months</option>
                            <option value="last_year">Last Year</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    
                    <div id="customDateRange" class="form-row" style="display: none;">
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" name="startDate">
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" name="endDate">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Include Columns</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="columns" value="id" checked> ID</label>
                            <label><input type="checkbox" name="columns" value="name" checked> Name</label>
                            <label><input type="checkbox" name="columns" value="email" checked> Email</label>
                            <label><input type="checkbox" name="columns" value="date" checked> Date</label>
                            <label><input type="checkbox" name="columns" value="status" checked> Status</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeExportModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="processExport()">Export Data</button>
            </div>
        </div>
    </div>
</div>

<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('active'));
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => btn.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
    
    // Load chart for the selected tab
    loadChart(tabName);
}

// Chart loading functions
function loadChart(chartType) {
    // Simulated chart loading - in real implementation, you'd use Chart.js or similar
    console.log(`Loading ${chartType} chart...`);
    
    // Example with Canvas API (basic bars)
    const canvas = document.getElementById(chartType + 'Chart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Draw simple bar chart
    const data = getChartData(chartType);
    drawBarChart(ctx, data, canvas.width, canvas.height);
}

function getChartData(type) {
    const chartData = {
        users: [12, 28, 45, 71],
        jobs: [89, 156, 97, 23],
        applications: [342, 156, 89, 67],
        interviews: [89, 234, 23, 110]
    };
    return chartData[type] || [];
}

function drawBarChart(ctx, data, width, height) {
    const barWidth = width / data.length;
    const maxValue = Math.max(...data);
    
    data.forEach((value, index) => {
        const barHeight = (value / maxValue) * (height - 40);
        const x = index * barWidth + 10;
        const y = height - barHeight - 20;
        
        ctx.fillStyle = '#4CAF50';
        ctx.fillRect(x, y, barWidth - 20, barHeight);
        
        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';
        ctx.textAlign = 'center';
        ctx.fillText(value, x + (barWidth - 20) / 2, y - 5);
    });
}

// Export functions
function exportUserData() {
    openExportModal('users');
}

function exportJobData() {
    openExportModal('jobs');
}

function exportApplicationData() {
    openExportModal('applications');
}

function exportInterviewData() {
    openExportModal('interviews');
}

function exportAnalytics() {
    openExportModal('analytics');
}

function openExportModal(dataType) {
    document.getElementById('exportModal').style.display = 'block';
    window.currentExportType = dataType;
}

function closeExportModal() {
    document.getElementById('exportModal').style.display = 'none';
}

function processExport() {
    const format = document.getElementById('exportFormat').value;
    const dateRange = document.getElementById('dateRange').value;
    
    showToast(`Export started for ${window.currentExportType} data in ${format.toUpperCase()} format`, 'info');
    closeExportModal();
    
    // Simulate export process
    setTimeout(() => {
        showToast('Export completed successfully! Download will begin shortly.', 'success');
    }, 2000);
}

// Refresh data
function refreshData(dataType) {
    showToast(`${dataType.charAt(0).toUpperCase() + dataType.slice(1)} data refreshed`, 'success');
    loadChart(dataType);
}

// Generate report
function generateReport() {
    showToast('Generating comprehensive report...', 'info');
    
    setTimeout(() => {
        showToast('Report generated successfully! Check your downloads folder.', 'success');
    }, 3000);
}

// Date range handling
document.getElementById('dateRange').addEventListener('change', function() {
    const customRange = document.getElementById('customDateRange');
    if (this.value === 'custom') {
        customRange.style.display = 'flex';
    } else {
        customRange.style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadChart('users'); // Load default chart
    
    // Set default date range
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('endDate').value = today;
    
    const monthAgo = new Date();
    monthAgo.setMonth(monthAgo.getMonth() - 1);
    document.getElementById('startDate').value = monthAgo.toISOString().split('T')[0];
});

// Toast notification function
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

<style>
.tab-container {
    margin-top: 2rem;
}

.tab-nav {
    display: flex;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 2rem;
}

.tab-btn {
    padding: 1rem 1.5rem;
    border: none;
    background: none;
    color: var(--text-secondary);
    font-weight: 500;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.tab-btn:hover {
    color: var(--primary-color);
}

.tab-btn.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--card-background);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.chart-container {
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.analytics-card {
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
}

.analytics-card h4 {
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.funnel-stats {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.funnel-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
}

.funnel-label {
    min-width: 80px;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.funnel-value {
    min-width: 50px;
    font-weight: 600;
    color: var(--text-primary);
}

.funnel-bar {
    height: 8px;
    background: var(--primary-color);
    border-radius: 4px;
    flex: 1;
    max-width: 200px;
}

.metric-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.metric-item:last-child {
    border-bottom: none;
}

.metric-name {
    color: var(--text-secondary);
}

.metric-value {
    font-weight: 600;
    color: var(--text-primary);
}

.trend-analysis {
    background: var(--card-background);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 0.5rem;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}
</style>

<?php $this->view('components/footer') ?>