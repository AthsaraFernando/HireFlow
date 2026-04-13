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
                    <a href="<?= ROOT ?>/hradmin/job-posts" class="nav-link active">
                        <span class="nav-text">Job Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicants & Applications</span>
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
                <h1 class="page-title">Job Posts Management</h1>
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
                <div class="hero-section">
                    <div class="hero-content">
                        <h1 class="hero-title">Job Posts Management</h1>
                        <p class="hero-description">Create, edit and manage all your job postings in one place. Track performance and attract top talent.</p>
                        <div class="hero-stats">
                            <div class="hero-stat">
                                <span class="stat-number"><?= $total_jobs ?? '24' ?></span>
                                <span class="stat-label">Total Jobs</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $active_jobs ?? '18' ?></span>
                                <span class="stat-label">Active</span>
                            </div>
                            <div class="hero-stat">
                                <span class="stat-number"><?= $draft_jobs ?? '6' ?></span>
                                <span class="stat-label">Drafts</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                            <i class="icon-plus"></i>Create New Job
                        </a>
                        <button class="btn btn-outline" onclick="exportJobs()">
                            <i class="icon-download"></i>Export Jobs
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

    <?php if(!empty($success)): ?>
        <div class="alert alert-success">
            <p><?php echo $success ?></p>
        </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-controls">
            <div class="search-box">
                <input type="text" placeholder="Search job posts..." class="search-input">
                <button class="search-btn">Search</button>
            </div>
            <div class="filter-group">
                <select class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="paused">Paused</option>
                    <option value="closed">Closed</option>
                    <option value="draft">Draft</option>
                </select>
                <select class="filter-select">
                    <option value="">All Departments</option>
                    <option value="engineering">Engineering</option>
                    <option value="design">Design</option>
                    <option value="marketing">Marketing</option>
                    <option value="sales">Sales</option>
                    <option value="hr">Human Resources</option>
                </select>
                <select class="filter-select">
                    <option value="">All Types</option>
                    <option value="full-time">Full-time</option>
                    <option value="part-time">Part-time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Job Posts Table -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Department</th>
                    <th>Type</th>
                    <th>Posted Date</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($job_posts)): ?>
                    <?php foreach($job_posts as $job): ?>
                        <tr>
                            <td>
                                <div class="job-info">
                                    <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                                    <div class="job-location"><?= htmlspecialchars($job['location']) ?></div>
                                </div>
                            </td>
                            <td><span class="dept-tag <?= strtolower(str_replace(' ', '-', $job['department'])) ?>"><?= htmlspecialchars($job['department']) ?></span></td>
                            <td><?= htmlspecialchars($job['type']) ?></td>
                            <td><?= date('M d, Y', strtotime($job['created_date'])) ?></td>
                            <td>
                                <span class="application-count"><?= $job['applications'] ?></span>
                                <a href="<?= ROOT ?>/hradmin/applicant-database?tab=applications&job=<?= $job['id'] ?>" class="view-applications">View</a>
                            </td>
                            <td><span class="status-badge <?= strtolower($job['status']) ?>"><?= htmlspecialchars($job['status']) ?></span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= ROOT ?>/hradmin/view-job/<?= $job['id'] ?>" class="action-btn view-btn" title="View">
                                        View
                                    </a>
                                    <a href="<?= ROOT ?>/hradmin/edit-job/<?= $job['id'] ?>" class="action-btn edit-btn" title="Edit">
                                        Edit
                                    </a>
                                    <button class="action-btn delete-btn" title="Delete" onclick="confirmDelete(<?= $job['id'] ?>)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem;">
                            <p>No job posts found. <a href="<?= ROOT ?>/hradmin/create-job">Create your first job post</a></p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <?= count($job_posts ?? []) ?> job post<?= count($job_posts ?? []) != 1 ? 's' : '' ?>
        </div>
        <div class="pagination">
            <button class="pagination-btn" disabled>Previous</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">Next</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this job post? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" onclick="deleteJob()">Delete</button>
        </div>
    </div>
</div>

<style>
/* Action buttons styling */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-start;
    align-items: center;
}

.action-btn {
    padding: 0.5rem 1rem;
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

.edit-btn {
    background: #f59e0b;
    color: white;
}

.edit-btn:hover {
    background: #d97706;
    box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
    transform: translateY(-1px);
}

.delete-btn {
    background: #ef4444;
    color: white;
}

.delete-btn:hover {
    background: #dc2626;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
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

/* Modern HR Admin Design System */
<style>
    /* Global Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-content {
        background: var(--background-gradient);
        min-height: 100vh;
        padding: 2rem;
    }

    .hero-section {
        background: linear-gradient(135deg, #4c63d2 0%, #5a67d8 50%, #667eea 100%);
        color: white;
        padding: 3rem 2.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2.5rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
        border-radius: var(--border-radius);
        pointer-events: none;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: #ffffff;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .hero-description {
        font-size: 1.125rem;
        opacity: 1;
        margin-bottom: 1.5rem;
        color: rgba(255,255,255,0.95);
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 8px 25px rgba(255,255,255,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255,255,255,0.4);
    }

    .btn-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-outline:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-3px);
    }

    .job-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    /* Icons */
    .icon-plus::before { content: '✚'; }
    .icon-download::before { content: '⬇'; }
    .icon-edit::before { content: '✏️'; }
    .icon-delete::before { content: '🗑️'; }
    .icon-view::before { content: '👁️'; }

    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
        }
        .dashboard-content {
            padding: 1rem;
        }
    }
</style>

<script>
let deleteJobId = null;

function confirmDelete(jobId) {
    deleteJobId = jobId;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    deleteJobId = null;
    document.getElementById('deleteModal').style.display = 'none';
}

function deleteJob() {
    if (deleteJobId) {
        // Redirect to delete action
        window.location.href = '<?= ROOT ?>/hradmin/job-posts/delete/' + deleteJobId;
    }
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
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
