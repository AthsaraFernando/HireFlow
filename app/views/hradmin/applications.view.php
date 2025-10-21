<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">HR Admin</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/create-job" class="nav-link">
                        <span class="nav-text">Create Job</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link">
                        <span class="nav-text">Job Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link active">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/interview-schedule" class="nav-link">
                        <span class="nav-text">Interviews</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/profile" class="nav-link">
                        <span class="nav-text">My Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn">
                <span>Logout</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <
                </button>
                <h1 class="page-title">Applications Management</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Applications Management</h1>
        <p class="page-description">Review and manage job applications from candidates</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/applicant-database" class="btn btn-secondary">
                Applicant Database
            </a>
            <a href="<?= ROOT ?>/hradmin/interview-schedule" class="btn btn-secondary">
                Schedule Interviews
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

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <p><?php echo $success ?></p>
        </div>
    <?php endif; ?>

    <!-- Application Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?= $total_applications ?? '156' ?></div>
            <div class="stat-label">Total Applications</div>
            <div class="stat-change positive">+12 today</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $pending_review ?? '34' ?></div>
            <div class="stat-label">Pending Review</div>
            <div class="stat-change neutral">Needs attention</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $shortlisted ?? '28' ?></div>
            <div class="stat-label">Shortlisted</div>
            <div class="stat-change positive">+5 this week</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $interviewed ?? '15' ?></div>
            <div class="stat-label">Interviewed</div>
            <div class="stat-change positive">+3 this week</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-controls">
            <div class="search-box">
                <input type="text" placeholder="Search applicants..." class="search-input">
                <button class="search-btn">Search</button>
            </div>
            <div class="filter-group">
                <select class="filter-select">
                    <option value="">All Positions</option>
                    <option value="1">Senior Software Developer</option>
                    <option value="2">UI/UX Designer</option>
                    <option value="3">Marketing Manager</option>
                    <option value="4">Project Manager</option>
                </select>
                <select class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending Review</option>
                    <option value="reviewing">Under Review</option>
                    <option value="shortlisted">Shortlisted</option>
                    <option value="interviewed">Interviewed</option>
                    <option value="offered">Offer Extended</option>
                    <option value="hired">Hired</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select class="filter-select">
                    <option value="">All Sources</option>
                    <option value="website">Company Website</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="indeed">Indeed</option>
                    <option value="referral">Employee Referral</option>
                </select>
                <select class="filter-select">
                    <option value="">Date Applied</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAll" class="checkbox">
                    </th>
                    <th>Applicant</th>
                    <th>Position</th>
                    <th>Applied Date</th>
                    <th>Source</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" class="checkbox row-checkbox" value="1"></td>
                    <td>
                        <div class="applicant-info">
                            <div class="applicant-name">John Smith</div>
                            <div class="applicant-email">john.smith@email.com</div>
                            <div class="applicant-phone">+1 (555) 123-4567</div>
                        </div>
                    </td>
                    <td>Senior Software Developer</td>
                    <td>Jan 18, 2024</td>
                    <td><span class="source-tag website">Website</span></td>
                    <td>5 years</td>
                    <td><span class="status-badge pending">Pending Review</span></td>
                    <td>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star empty">⭐</span>
                            <span class="rating-text">4/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-application/1" class="action-btn view-btn" title="View Details">
                                View
                            </a>
                            <button class="action-btn download-btn" title="Download Resume" onclick="downloadResume(1)">
                                Download
                            </button>
                            <div class="dropdown">
                                <button class="action-btn status-btn dropdown-toggle" title="Change Status">
                                    Status
                                </button>
                                <div class="dropdown-menu">
                                    <button onclick="updateStatus(1, 'reviewing')">Mark as Reviewing</button>
                                    <button onclick="updateStatus(1, 'shortlisted')">Shortlist</button>
                                    <button onclick="updateStatus(1, 'interviewed')">Mark Interviewed</button>
                                    <button onclick="updateStatus(1, 'rejected')">Reject</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="checkbox row-checkbox" value="2"></td>
                    <td>
                        <div class="applicant-info">
                            <div class="applicant-name">Sarah Johnson</div>
                            <div class="applicant-email">sarah.johnson@email.com</div>
                            <div class="applicant-phone">+1 (555) 234-5678</div>
                        </div>
                    </td>
                    <td>UI/UX Designer</td>
                    <td>Jan 17, 2024</td>
                    <td><span class="source-tag linkedin">LinkedIn</span></td>
                    <td>3 years</td>
                    <td><span class="status-badge shortlisted">Shortlisted</span></td>
                    <td>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="rating-text">5/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-application/2" class="action-btn view-btn" title="View Details">
                                View
                            </a>
                            <button class="action-btn download-btn" title="Download Resume" onclick="downloadResume(2)">
                                Download
                            </button>
                            <div class="dropdown">
                                <button class="action-btn status-btn dropdown-toggle" title="Change Status">
                                    Status
                                </button>
                                <div class="dropdown-menu">
                                    <button onclick="updateStatus(2, 'interviewed')">Mark Interviewed</button>
                                    <button onclick="updateStatus(2, 'offered')">Extend Offer</button>
                                    <button onclick="updateStatus(2, 'rejected')">Reject</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="checkbox row-checkbox" value="3"></td>
                    <td>
                        <div class="applicant-info">
                            <div class="applicant-name">Mike Wilson</div>
                            <div class="applicant-email">mike.wilson@email.com</div>
                            <div class="applicant-phone">+1 (555) 345-6789</div>
                        </div>
                    </td>
                    <td>Marketing Manager</td>
                    <td>Jan 16, 2024</td>
                    <td><span class="source-tag indeed">Indeed</span></td>
                    <td>7 years</td>
                    <td><span class="status-badge interviewed">Interviewed</span></td>
                    <td>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star empty">⭐</span>
                            <span class="rating-text">4/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-application/3" class="action-btn view-btn" title="View Details">
                                View
                            </a>
                            <button class="action-btn download-btn" title="Download Resume" onclick="downloadResume(3)">
                                Download
                            </button>
                            <div class="dropdown">
                                <button class="action-btn status-btn dropdown-toggle" title="Change Status">
                                    Status
                                </button>
                                <div class="dropdown-menu">
                                    <button onclick="updateStatus(3, 'offered')">Extend Offer</button>
                                    <button onclick="updateStatus(3, 'hired')">Mark as Hired</button>
                                    <button onclick="updateStatus(3, 'rejected')">Reject</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" class="checkbox row-checkbox" value="4"></td>
                    <td>
                        <div class="applicant-info">
                            <div class="applicant-name">Emily Chen</div>
                            <div class="applicant-email">emily.chen@email.com</div>
                            <div class="applicant-phone">+1 (555) 456-7890</div>
                        </div>
                    </td>
                    <td>Project Manager</td>
                    <td>Jan 15, 2024</td>
                    <td><span class="source-tag referral">Referral</span></td>
                    <td>4 years</td>
                    <td><span class="status-badge offered">Offer Extended</span></td>
                    <td>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="rating-text">5/5</span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-application/4" class="action-btn view-btn" title="View Details">
                                View
                            </a>
                            <button class="action-btn download-btn" title="Download Resume" onclick="downloadResume(4)">
                                Download
                            </button>
                            <div class="dropdown">
                                <button class="action-btn status-btn dropdown-toggle" title="Change Status">
                                    Status
                                </button>
                                <div class="dropdown-menu">
                                    <button onclick="updateStatus(4, 'hired')">Mark as Hired</button>
                                    <button onclick="updateStatus(4, 'rejected')">Reject</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions" style="display: none;">
        <div class="bulk-info">
            <span id="selectedCount">0</span> applications selected
        </div>
        <div class="bulk-buttons">
            <button class="btn btn-secondary" onclick="bulkDownload()">
                Download Resumes
            </button>
            <button class="btn btn-primary" onclick="bulkShortlist()">
                Bulk Shortlist
            </button>
            <button class="btn btn-warning" onclick="bulkReject()">
                Bulk Reject
            </button>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing 1-4 of 156 applications
        </div>
        <div class="pagination">
            <button class="pagination-btn" disabled>Previous</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">Next</button>
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #4e31aa;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.stat-change {
    font-size: 0.75rem;
    font-weight: 500;
}

.stat-change.positive { color: #28a745; }
.stat-change.neutral { color: #6c757d; }

.applicant-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.applicant-name {
    font-weight: 600;
    color: #2c3e50;
}

.applicant-email, .applicant-phone {
    font-size: 0.875rem;
    color: #6c757d;
}

.source-tag {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.source-tag.website { background: #e3f2fd; color: #1976d2; }
.source-tag.linkedin { background: #e8f5e8; color: #388e3c; }
.source-tag.indeed { background: #fff3e0; color: #f57c00; }
.source-tag.referral { background: #f3e5f5; color: #7b1fa2; }

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-badge.pending { background: #fff3cd; color: #856404; }
.status-badge.reviewing { background: #cfe2ff; color: #004085; }
.status-badge.shortlisted { background: #d4edda; color: #155724; }
.status-badge.interviewed { background: #e2e3e5; color: #383d41; }
.status-badge.offered { background: #d1ecf1; color: #0c5460; }
.status-badge.hired { background: #d4edda; color: #155724; }
.status-badge.rejected { background: #f8d7da; color: #721c24; }

.rating {
    display: flex;
    align-items: center;
    gap: 0.125rem;
}

.star {
    font-size: 0.875rem;
    color: #ffc107;
}

.star.empty {
    color: #e9ecef;
}

.rating-text {
    margin-left: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.action-buttons {
    display: flex;
    gap: 0.25rem;
    align-items: center;
}

.dropdown {
    position: relative;
}

.dropdown-toggle {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    z-index: 100;
    min-width: 150px;
    display: none;
}

.dropdown-menu button {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: none;
    background: none;
    text-align: left;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.2s;
}

.dropdown-menu button:hover {
    background: #f8f9fa;
}

.dropdown.active .dropdown-menu {
    display: block;
}

.bulk-actions {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 1000;
}

.bulk-info {
    font-weight: 600;
    color: #2c3e50;
}

.bulk-buttons {
    display: flex;
    gap: 0.5rem;
}

.checkbox {
    width: 16px;
    height: 16px;
    border-radius: 3px;
}

/* Icon styles - removed emojis */

/* Action buttons styling */
.action-btn {
    padding: 0.4rem 0.9rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 70px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    background: white;
}

.view-btn {
    background: #3b82f6;
    color: white;
}

.view-btn:hover {
    background: #2563eb;
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    transform: translateY(-1px);
}

.download-btn {
    background: #10b981;
    color: white;
}

.download-btn:hover {
    background: #059669;
    box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
    transform: translateY(-1px);
}

.status-btn {
    background: #6366f1;
    color: white;
}

.status-btn:hover {
    background: #4f46e5;
    box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
    transform: translateY(-1px);
}

/* Search button styling */
.search-btn {
    padding: 0.625rem 1.25rem;
    background: #4e31aa;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.search-btn:hover {
    background: #3d2687;
}
</style>

<script>
// Checkbox selection handling
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedCheckboxes.length > 0) {
        bulkActions.style.display = 'flex';
        selectedCount.textContent = selectedCheckboxes.length;
    } else {
        bulkActions.style.display = 'none';
    }
}

// Dropdown handling
document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = this.closest('.dropdown');
        
        // Close other dropdowns
        document.querySelectorAll('.dropdown.active').forEach(d => {
            if (d !== dropdown) d.classList.remove('active');
        });
        
        dropdown.classList.toggle('active');
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', function() {
    document.querySelectorAll('.dropdown.active').forEach(dropdown => {
        dropdown.classList.remove('active');
    });
});

// Action functions
function downloadResume(id) {
    alert(`Downloading resume for application ${id}`);
}

function updateStatus(id, status) {
    alert(`Updating application ${id} status to: ${status}`);
    // Here you would make an AJAX call to update the status
    location.reload();
}

function bulkDownload() {
    const selected = document.querySelectorAll('.row-checkbox:checked');
    alert(`Downloading resumes for ${selected.length} applications`);
}

function bulkShortlist() {
    const selected = document.querySelectorAll('.row-checkbox:checked');
    if (confirm(`Shortlist ${selected.length} applications?`)) {
        alert('Applications shortlisted successfully');
        location.reload();
    }
}

function bulkReject() {
    const selected = document.querySelectorAll('.row-checkbox:checked');
    if (confirm(`Reject ${selected.length} applications? This action cannot be undone.`)) {
        alert('Applications rejected successfully');
        location.reload();
    }
}

// Filter functionality
document.querySelectorAll('.filter-select, .search-input').forEach(element => {
    element.addEventListener('change', function() {
        // Implement filtering logic
        console.log('Filtering applications...');
    });
});

// Sidebar toggle functionality
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
});

document.querySelector('.sidebar-toggle').addEventListener('click', function (e) {
    if (e.target.textContent.trim() === ">") {
        e.target.textContent = "<";
    } else {
        e.target.textContent = ">";
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href').includes(currentPath)) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
});
</script>

        </div>
    </div>

<?php $this->view('components/footer') ?>
