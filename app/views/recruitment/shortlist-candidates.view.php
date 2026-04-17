<?php $this->view('components/header') ?>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Recruitment Manager</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/dashboard" class="nav-link"><span class="nav-text">Dashboard</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/applicationforms" class="nav-link"><span class="nav-text">Application Forms</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/applications" class="nav-link"><span class="nav-text">Applications</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/shortlist-candidates" class="nav-link active"><span class="nav-text">Shortlist</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/interview-schedule" class="nav-link"><span class="nav-text">Interviews</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/reports" class="nav-link"><span class="nav-text">Reports</span></a></li>
                <li class="nav-item"><a href="<?= ROOT ?>/recruitment/profile" class="nav-link"><span class="nav-text">My Profile</span></a></li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= ROOT ?>/signout" class="logout-btn"><span>Logout</span></a>
        </div>
    </div>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle"><</button>
                <h1 class="page-title">Shortlist Feedback</h1>
            </div>
            <div class="header-right">
                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name"><?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">Recruitment Manager</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="filters-section">
                    <form method="GET" action="<?= ROOT ?>/recruitment/shortlist-candidates" class="filters-container">
                        <div class="filter-group">
                            <label for="name">Candidate Name</label>
                            <input id="name" type="text" name="name" class="search-input" placeholder="Search by candidate name" value="<?= htmlspecialchars($filters['name'] ?? '') ?>">
                        </div>
                        <div class="filter-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="filter-select">
                                <option value="">All</option>
                                <option value="Hire" <?= ($filters['status'] ?? '') === 'Hire' ? 'selected' : '' ?>>Hire</option>
                                <option value="Reject" <?= ($filters['status'] ?? '') === 'Reject' ? 'selected' : '' ?>>Reject</option>
                                <option value="Pending" <?= ($filters['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">Feedback List</h3>
                    </div>

                    <?php if (!empty($feedback_list)): ?>
                        <div class="table-responsive" style="padding: 1rem; overflow-x: auto;">
                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="text-align:left; padding: 0.75rem;">Candidate</th>
                                        <th style="text-align:left; padding: 0.75rem;">Job</th>
                                        <th style="text-align:left; padding: 0.75rem;">Interview Date</th>
                                        <th style="text-align:left; padding: 0.75rem;">Recommendation</th>
                                        <th style="text-align:left; padding: 0.75rem;">Total Points</th>
                                        <th style="text-align:left; padding: 0.75rem;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feedback_list as $row): ?>
                                        <tr>
                                            <td style="padding: 0.75rem;"><?= htmlspecialchars($row['candidate_name']) ?></td>
                                            <td style="padding: 0.75rem;"><?= htmlspecialchars($row['job_title']) ?></td>
                                            <td style="padding: 0.75rem;"><?= date('M j, Y', strtotime($row['scheduled_date'])) ?></td>
                                            <td style="padding: 0.75rem;">
                                                <span class="recommendation-badge <?= strtolower($row['recommendation']) ?>">
                                                    <?= htmlspecialchars($row['recommendation']) ?>
                                                </span>
                                            </td>
                                            <td style="padding: 0.75rem;"><?= (int) $row['total_points'] ?></td>
                                            <td style="padding: 0.75rem;">
                                                <button class="btn btn-outline" onclick="openFeedbackModal(<?= (int) $row['id'] ?>)">View</button>
                                                <button class="btn btn-danger" onclick="deleteFeedback(<?= (int) $row['id'] ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" style="padding: 1.5rem;">
                            <p>No completed interview feedback records found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="interview-modal-overlay" id="feedback-modal" style="display:none;">
        <div class="interview-modal-container" style="max-width: 740px;">
            <div class="interview-modal-header">
                <h3 class="interview-modal-title">Interview Feedback Details</h3>
                <button class="interview-modal-close" onclick="closeFeedbackModal()">&times;</button>
            </div>

            <div class="interview-modal-body">
                <form id="feedback-form">
                    <input type="hidden" id="feedback_id" name="feedback_id">

                    <div class="interview-form-section">
                        <label class="interview-form-label">Candidate</label>
                        <input type="text" id="candidate_name" class="interview-input" readonly>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Job Title</label>
                        <input type="text" id="job_title" class="interview-input" readonly>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Technical Skills (1-10)</label>
                        <input type="number" name="technical_skills" id="technical_skills" class="interview-input score-input" min="1" max="10" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Problem Solving (1-10)</label>
                        <input type="number" name="problem_solving" id="problem_solving" class="interview-input score-input" min="1" max="10" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Communication (1-10)</label>
                        <input type="number" name="communication" id="communication" class="interview-input score-input" min="1" max="10" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Cultural Fit (1-10)</label>
                        <input type="number" name="cultural_fit" id="cultural_fit" class="interview-input score-input" min="1" max="10" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Experience Relevance (1-10)</label>
                        <input type="number" name="experience_relevance" id="experience_relevance" class="interview-input score-input" min="1" max="10" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Manager Points (0-50)</label>
                        <input type="number" name="manager_points" id="manager_points" class="interview-input score-input" min="0" max="50" required>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Total Points</label>
                        <input type="text" id="total_points" class="interview-input" readonly>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Interview Notes</label>
                        <textarea name="interview_notes" id="interview_notes" class="interview-input" rows="5"></textarea>
                    </div>

                    <div class="interview-form-section">
                        <label class="interview-form-label">Recommendation</label>
                        <select name="recommendation" id="recommendation" class="interview-input" required>
                            <option value="">Select recommendation</option>
                            <option value="Hire">Hire</option>
                            <option value="Reject">Reject</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="interview-modal-footer">
                <button class="interview-btn interview-btn-cancel" onclick="closeFeedbackModal()">Close</button>
                <button class="interview-btn interview-btn-cancel" id="edit-btn" onclick="enableEdit()">Edit</button>
                <button class="interview-btn interview-btn-schedule" id="save-btn" style="display:none;" onclick="saveFeedbackChanges()">Save Changes</button>
            </div>
        </div>
    </div>

<script>
let currentFeedbackId = null;

function setEditMode(isEditable) {
    const editableFields = document.querySelectorAll('#feedback-form input[name], #feedback-form textarea, #feedback-form select');
    editableFields.forEach(field => {
        if (field.id !== 'feedback_id') {
            field.disabled = !isEditable;
        }
    });

    document.getElementById('edit-btn').style.display = isEditable ? 'none' : 'inline-block';
    document.getElementById('save-btn').style.display = isEditable ? 'inline-block' : 'none';
}

function calculateModalTotal() {
    const fields = ['technical_skills', 'problem_solving', 'communication', 'cultural_fit', 'experience_relevance', 'manager_points'];
    let total = 0;

    fields.forEach(id => {
        const value = parseInt(document.getElementById(id).value || '0', 10);
        if (!Number.isNaN(value)) {
            total += value;
        }
    });

    document.getElementById('total_points').value = total;
}

function openFeedbackModal(feedbackId) {
    currentFeedbackId = feedbackId;

    fetch('<?= ROOT ?>/recruitment/shortlist-candidates/getFeedback/' + feedbackId)
        .then(response => response.json())
        .then(result => {
            if (!result.success) {
                alert(result.message || 'Failed to load feedback details.');
                return;
            }

            const data = result.data;
            document.getElementById('feedback_id').value = data.id;
            document.getElementById('candidate_name').value = data.candidate_name;
            document.getElementById('job_title').value = data.job_title;
            document.getElementById('technical_skills').value = data.technical_skills;
            document.getElementById('problem_solving').value = data.problem_solving;
            document.getElementById('communication').value = data.communication;
            document.getElementById('cultural_fit').value = data.cultural_fit;
            document.getElementById('experience_relevance').value = data.experience_relevance;
            document.getElementById('manager_points').value = data.manager_points;
            document.getElementById('interview_notes').value = data.interview_notes || '';
            document.getElementById('recommendation').value = data.recommendation;
            document.getElementById('total_points').value = data.total_points;

            document.getElementById('feedback-modal').style.display = 'flex';
            setEditMode(false);
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred while loading feedback details.');
        });
}

function closeFeedbackModal() {
    document.getElementById('feedback-modal').style.display = 'none';
    currentFeedbackId = null;
}

function enableEdit() {
    setEditMode(true);
}

function saveFeedbackChanges() {
    if (!currentFeedbackId) {
        return;
    }

    const form = document.getElementById('feedback-form');
    const formData = new FormData(form);

    fetch('<?= ROOT ?>/recruitment/shortlist-candidates/updateFeedback/' + currentFeedbackId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            alert(result.message || 'Failed to update feedback.');
            console.error(result.errors || {});
            return;
        }

        alert('Feedback updated successfully.');
        window.location.reload();
    })
    .catch(error => {
        console.error(error);
        alert('An error occurred while updating feedback.');
    });
}

function deleteFeedback(feedbackId) {
    if (!confirm('Are you sure you want to delete this feedback record?')) {
        return;
    }

    const formData = new FormData();
    formData.append('id', feedbackId);

    fetch('<?= ROOT ?>/recruitment/shortlist-candidates/deleteFeedback/' + feedbackId, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            alert(result.message || 'Failed to delete feedback.');
            return;
        }

        alert('Feedback deleted successfully.');
        window.location.reload();
    })
    .catch(error => {
        console.error(error);
        alert('An error occurred while deleting feedback.');
    });
}

document.querySelectorAll('.score-input').forEach(input => {
    input.addEventListener('input', calculateModalTotal);
});

window.addEventListener('click', function (event) {
    const modal = document.getElementById('feedback-modal');
    if (event.target === modal) {
        closeFeedbackModal();
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
</script>

<?php $this->view('components/footer') ?>
