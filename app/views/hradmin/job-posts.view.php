<?php $this->view('components/header') ?>

<div class="main-container">
    <div class="header-section">
        <h1 class="page-title">Job Posts Management</h1>
        <p class="page-description">Create, edit and manage all job postings</p>
        <div class="action-buttons">
            <a href="<?= ROOT ?>/hradmin/create-job" class="btn btn-primary">
                <i class="icon-plus"></i>Create New Job Post
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
                <button class="search-btn"><i class="icon-search"></i></button>
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
                <tr>
                    <td>
                        <div class="job-info">
                            <div class="job-title">Senior Software Developer</div>
                            <div class="job-location">San Francisco, CA</div>
                        </div>
                    </td>
                    <td><span class="dept-tag engineering">Engineering</span></td>
                    <td>Full-time</td>
                    <td>Jan 15, 2024</td>
                    <td>
                        <span class="application-count">23</span>
                        <a href="<?= ROOT ?>/hradmin/applications?job=1" class="view-applications">View</a>
                    </td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-job/1" class="btn-icon" title="View">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="<?= ROOT ?>/hradmin/edit-job/1" class="btn-icon" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                            <button class="btn-icon danger" title="Delete" onclick="confirmDelete(1)">
                                <i class="icon-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="job-info">
                            <div class="job-title">UI/UX Designer</div>
                            <div class="job-location">Remote</div>
                        </div>
                    </td>
                    <td><span class="dept-tag design">Design</span></td>
                    <td>Full-time</td>
                    <td>Jan 12, 2024</td>
                    <td>
                        <span class="application-count">18</span>
                        <a href="<?= ROOT ?>/hradmin/applications?job=2" class="view-applications">View</a>
                    </td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-job/2" class="btn-icon" title="View">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="<?= ROOT ?>/hradmin/edit-job/2" class="btn-icon" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                            <button class="btn-icon danger" title="Delete" onclick="confirmDelete(2)">
                                <i class="icon-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="job-info">
                            <div class="job-title">Marketing Manager</div>
                            <div class="job-location">New York, NY</div>
                        </div>
                    </td>
                    <td><span class="dept-tag marketing">Marketing</span></td>
                    <td>Full-time</td>
                    <td>Jan 10, 2024</td>
                    <td>
                        <span class="application-count">12</span>
                        <a href="<?= ROOT ?>/hradmin/applications?job=3" class="view-applications">View</a>
                    </td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-job/3" class="btn-icon" title="View">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="<?= ROOT ?>/hradmin/edit-job/3" class="btn-icon" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                            <button class="btn-icon danger" title="Delete" onclick="confirmDelete(3)">
                                <i class="icon-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="job-info">
                            <div class="job-title">Project Manager</div>
                            <div class="job-location">Chicago, IL</div>
                        </div>
                    </td>
                    <td><span class="dept-tag management">Management</span></td>
                    <td>Full-time</td>
                    <td>Jan 8, 2024</td>
                    <td>
                        <span class="application-count">15</span>
                        <a href="<?= ROOT ?>/hradmin/applications?job=4" class="view-applications">View</a>
                    </td>
                    <td><span class="status-badge paused">Paused</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-job/4" class="btn-icon" title="View">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="<?= ROOT ?>/hradmin/edit-job/4" class="btn-icon" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                            <button class="btn-icon danger" title="Delete" onclick="confirmDelete(4)">
                                <i class="icon-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="job-info">
                            <div class="job-title">Sales Representative</div>
                            <div class="job-location">Austin, TX</div>
                        </div>
                    </td>
                    <td><span class="dept-tag sales">Sales</span></td>
                    <td>Full-time</td>
                    <td>Jan 5, 2024</td>
                    <td>
                        <span class="application-count">9</span>
                        <a href="<?= ROOT ?>/hradmin/applications?job=5" class="view-applications">View</a>
                    </td>
                    <td><span class="status-badge closed">Closed</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= ROOT ?>/hradmin/view-job/5" class="btn-icon" title="View">
                                <i class="icon-eye"></i>
                            </a>
                            <a href="<?= ROOT ?>/hradmin/edit-job/5" class="btn-icon" title="Edit">
                                <i class="icon-edit"></i>
                            </a>
                            <button class="btn-icon danger" title="Delete" onclick="confirmDelete(5)">
                                <i class="icon-delete"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing 1-5 of 15 job posts
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this job post? This action cannot be undone.</p>
</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Deletion</h3>
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
        // Here you would make an AJAX call to delete the job
        alert('Job post deleted successfully');
        closeDeleteModal();
        // Refresh the page or remove the row
        location.reload();
    }
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php $this->view('components/footer') ?>
