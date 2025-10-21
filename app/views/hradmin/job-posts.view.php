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
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link">
                        <span class="nav-text">Applicant Database</span>
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
    <div class="header-section">
        <h1 class="page-title">Job Posts Management</h1>
        <p class="page-description">Create, edit and manage all job postings</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                Create New Job Post
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
                                <a href="<?= ROOT ?>/hradmin/applications?job=<?= $job['id'] ?>" class="view-applications">View</a>
                            </td>
                            <td><span class="status-badge <?= strtolower($job['status']) ?>"><?= htmlspecialchars($job['status']) ?></span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= ROOT ?>/hradmin/job-posts/viewJob/<?= $job['id'] ?>" class="action-btn view-btn" title="View">
                                        View
                                    </a>
                                    <a href="<?= ROOT ?>/hradmin/job-posts/edit/<?= $job['id'] ?>" class="action-btn edit-btn" title="Edit">
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
