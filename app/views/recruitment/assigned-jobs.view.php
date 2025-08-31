<?php $this->view('components/header') ?>

<div class="main-container">
    <!-- Header Section -->
    <div class="header-section">
        <h1 class="page-title">My Assigned Jobs</h1>
        <p class="page-description">Manage and review job positions assigned to you for recruitment</p>
        <div class="quick-actions">
            <a href="<?= ROOT ?>/recruitment/dashboard" class="btn btn-secondary">
                <i class="icon-back"></i>Back to Dashboard
            </a>
            <a href="<?= ROOT ?>/recruitment/applications" class="btn btn-primary">
                <i class="icon-applications"></i>Review Applications
            </a>
            <a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="btn btn-outline">
                <i class="icon-users"></i>Manage Shortlist
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

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-container">
            <div class="filter-group">
                <label for="department-filter">Department:</label>
                <select id="department-filter" class="filter-select">
                    <?php foreach($departments as $dept): ?>
                        <option value="<?= strtolower($dept) ?>"><?= $dept ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="status-filter">Status:</label>
                <select id="status-filter" class="filter-select">
                    <?php foreach($statuses as $status): ?>
                        <option value="<?= strtolower($status) ?>"><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="priority-filter">Priority:</label>
                <select id="priority-filter" class="filter-select">
                    <?php foreach($priorities as $priority): ?>
                        <option value="<?= strtolower($priority) ?>"><?= $priority ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <input type="text" id="search-jobs" placeholder="Search jobs..." class="search-input">
            </div>
            <button class="btn btn-outline" onclick="clearFilters()">Clear Filters</button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-section">
        <div class="summary-card">
            <div class="summary-value"><?= count($assigned_jobs) ?></div>
            <div class="summary-label">Total Assigned Jobs</div>
        </div>
        <div class="summary-card warning">
            <div class="summary-value"><?= array_sum(array_column($assigned_jobs, 'pending_reviews')) ?></div>
            <div class="summary-label">Pending Reviews</div>
        </div>
        <div class="summary-card success">
            <div class="summary-value"><?= array_sum(array_column($assigned_jobs, 'shortlisted_count')) ?></div>
            <div class="summary-label">Shortlisted Candidates</div>
        </div>
        <div class="summary-card info">
            <div class="summary-value"><?= array_sum(array_column($assigned_jobs, 'interviewed_count')) ?></div>
            <div class="summary-label">Interviews Conducted</div>
        </div>
    </div>

    <!-- Jobs Grid -->
    <div class="jobs-grid">
        <?php foreach($assigned_jobs as $job): ?>
        <div class="job-card" data-department="<?= strtolower($job['department']) ?>" data-status="<?= strtolower($job['status']) ?>" data-priority="<?= strtolower($job['priority']) ?>">
            <div class="job-header">
                <div class="job-title-section">
                    <h3 class="job-title"><?= htmlspecialchars($job['title']) ?></h3>
                    <span class="job-department"><?= htmlspecialchars($job['department']) ?></span>
                </div>
                <div class="job-badges">
                    <span class="priority-badge <?= $job['priority'] ?>"><?= ucfirst($job['priority']) ?></span>
                    <span class="status-badge <?= $job['status'] ?>"><?= ucfirst($job['status']) ?></span>
                </div>
            </div>

            <div class="job-details">
                <div class="detail-item">
                    <strong>Location:</strong> <?= htmlspecialchars($job['location']) ?>
                </div>
                <div class="detail-item">
                    <strong>Type:</strong> <?= htmlspecialchars($job['employment_type']) ?>
                </div>
                <div class="detail-item">
                    <strong>Assigned:</strong> <?= date('M j, Y', strtotime($job['assigned_date'])) ?>
                </div>
                <div class="detail-item">
                    <strong>Deadline:</strong> <?= date('M j, Y', strtotime($job['deadline'])) ?>
                </div>
            </div>

            <div class="job-metrics">
                <div class="metric-item">
                    <div class="metric-value"><?= $job['applications_count'] ?></div>
                    <div class="metric-label">Applications</div>
                </div>
                <div class="metric-item pending">
                    <div class="metric-value"><?= $job['pending_reviews'] ?></div>
                    <div class="metric-label">Pending</div>
                </div>
                <div class="metric-item success">
                    <div class="metric-value"><?= $job['shortlisted_count'] ?></div>
                    <div class="metric-label">Shortlisted</div>
                </div>
                <div class="metric-item info">
                    <div class="metric-value"><?= $job['interviewed_count'] ?></div>
                    <div class="metric-label">Interviewed</div>
                </div>
            </div>

            <div class="job-actions">
                <a href="<?= ROOT ?>/recruitment/applications?job=<?= $job['id'] ?>" class="btn btn-primary">
                    <i class="icon-review"></i>Review Applications
                </a>
                <a href="<?= ROOT ?>/recruitment/shortlist-candidates?job=<?= $job['id'] ?>" class="btn btn-outline">
                    <i class="icon-shortlist"></i>Manage Shortlist
                </a>
                <a href="<?= ROOT ?>/hradmin/view-job/<?= $job['id'] ?>" class="btn btn-secondary">
                    <i class="icon-view"></i>View Details
                </a>
            </div>

            <div class="job-progress">
                <div class="progress-label">Recruitment Progress</div>
                <div class="progress-bar">
                    <?php 
                    $total = $job['applications_count'];
                    $reviewed = $total - $job['pending_reviews'];
                    $progress = $total > 0 ? ($reviewed / $total) * 100 : 0;
                    ?>
                    <div class="progress-fill" style="width: <?= $progress ?>%"></div>
                </div>
                <div class="progress-text"><?= $reviewed ?>/<?= $total ?> applications reviewed</div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="empty-state" style="display: none;">
        <div class="empty-icon">📋</div>
        <h3>No jobs found</h3>
        <p>No jobs match your current filters. Try adjusting your search criteria.</p>
        <button class="btn btn-outline" onclick="clearFilters()">Clear Filters</button>
    </div>
</div>

<script>
// Filter functionality
function filterJobs() {
    const departmentFilter = document.getElementById('department-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    const priorityFilter = document.getElementById('priority-filter').value;
    const searchTerm = document.getElementById('search-jobs').value.toLowerCase();
    
    const jobCards = document.querySelectorAll('.job-card');
    let visibleCount = 0;
    
    jobCards.forEach(card => {
        const department = card.dataset.department;
        const status = card.dataset.status;
        const priority = card.dataset.priority;
        const title = card.querySelector('.job-title').textContent.toLowerCase();
        
        const matchesDepartment = departmentFilter === 'all' || department === departmentFilter;
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        const matchesPriority = priorityFilter === 'all' || priority === priorityFilter;
        const matchesSearch = searchTerm === '' || title.includes(searchTerm);
        
        if (matchesDepartment && matchesStatus && matchesPriority && matchesSearch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    const emptyState = document.getElementById('empty-state');
    if (visibleCount === 0) {
        emptyState.style.display = 'block';
    } else {
        emptyState.style.display = 'none';
    }
}

function clearFilters() {
    document.getElementById('department-filter').value = 'all';
    document.getElementById('status-filter').value = 'all';
    document.getElementById('priority-filter').value = 'all';
    document.getElementById('search-jobs').value = '';
    filterJobs();
}

// Add event listeners
document.getElementById('department-filter').addEventListener('change', filterJobs);
document.getElementById('status-filter').addEventListener('change', filterJobs);
document.getElementById('priority-filter').addEventListener('change', filterJobs);
document.getElementById('search-jobs').addEventListener('input', filterJobs);
</script>

<?php $this->view('components/footer') ?>
