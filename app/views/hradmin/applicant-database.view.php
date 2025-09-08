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
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link active">
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
                <h1 class="page-title">Applicant Database</h1>
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
        <h1 class="page-title">Applicant Database</h1>
        <p class="page-description">Search and manage all candidate profiles and applications</p>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="exportDatabase()">
                <i class="icon-export"></i>Export Data
            </button>
            <button class="btn btn-secondary" onclick="importCandidates()">
                <i class="icon-import"></i>Import Candidates
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

    <!-- Database Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value"><?= $total_candidates ?? '1,247' ?></div>
            <div class="stat-label">Total Candidates</div>
            <div class="stat-change positive">+18 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $active_candidates ?? '423' ?></div>
            <div class="stat-label">Active in Process</div>
            <div class="stat-change positive">+8 this week</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $hired_candidates ?? '89' ?></div>
            <div class="stat-label">Successfully Hired</div>
            <div class="stat-change positive">+3 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?= $top_skills ?? '156' ?></div>
            <div class="stat-label">JavaScript Developers</div>
            <div class="stat-change neutral">Most common skill</div>
        </div>
    </div>

    <!-- Advanced Search & Filters -->
    <div class="search-section">
        <div class="search-header">
            <h3>Advanced Search</h3>
            <button class="btn btn-outline btn-sm" onclick="resetFilters()">Reset Filters</button>
        </div>
        
        <div class="search-form">
            <div class="search-row">
                <div class="search-group">
                    <label>Keyword Search</label>
                    <input type="text" placeholder="Name, email, skills, company..." class="search-input">
                </div>
                <div class="search-group">
                    <label>Location</label>
                    <input type="text" placeholder="City, state, remote..." class="search-input">
                </div>
                <div class="search-group">
                    <label>Experience Level</label>
                    <select class="search-select">
                        <option value="">All Levels</option>
                        <option value="entry">Entry Level (0-2 years)</option>
                        <option value="mid">Mid Level (3-5 years)</option>
                        <option value="senior">Senior Level (6-10 years)</option>
                        <option value="lead">Lead/Principal (10+ years)</option>
                    </select>
                </div>
            </div>
            
            <div class="search-row">
                <div class="search-group">
                    <label>Skills</label>
                    <input type="text" placeholder="JavaScript, React, Python..." class="search-input">
                </div>
                <div class="search-group">
                    <label>Current Status</label>
                    <select class="search-select">
                        <option value="">All Statuses</option>
                        <option value="new">New Applicant</option>
                        <option value="in_process">In Process</option>
                        <option value="interviewed">Interviewed</option>
                        <option value="offered">Offer Extended</option>
                        <option value="hired">Hired</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="search-group">
                    <label>Application Date</label>
                    <select class="search-select">
                        <option value="">Any Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="quarter">This Quarter</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
            </div>
            
            <div class="search-actions">
                <button class="btn btn-primary" onclick="searchCandidates()">
                    <i class="icon-search"></i>Search Candidates
                </button>
                <button class="btn btn-secondary" onclick="saveSearch()">Save Search</button>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="results-section">
        <div class="results-header">
            <div class="results-info">
                <span class="results-count">Showing 1-10 of 1,247 candidates</span>
                <div class="view-options">
                    <button class="view-btn active" onclick="setView('list')">
                        <i class="icon-list"></i>List
                    </button>
                    <button class="view-btn" onclick="setView('grid')">
                        <i class="icon-grid"></i>Grid
                    </button>
                </div>
            </div>
            <div class="sort-options">
                <select class="sort-select">
                    <option value="recent">Most Recent</option>
                    <option value="name">Name A-Z</option>
                    <option value="experience">Experience</option>
                    <option value="rating">Rating</option>
                    <option value="status">Status</option>
                </select>
            </div>
        </div>

        <!-- List View (Default) -->
        <div id="listView" class="candidates-list">
            <div class="candidate-card">
                <div class="candidate-avatar">
                    <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                </div>
                <div class="candidate-info">
                    <div class="candidate-header">
                        <h4 class="candidate-name">John Smith</h4>
                        <div class="candidate-actions">
                            <button class="btn-icon" title="Add to favorites" onclick="toggleFavorite(1)">
                                <i class="icon-heart"></i>
                            </button>
                            <button class="btn-icon" title="Send message" onclick="sendMessage(1)">
                                <i class="icon-message"></i>
                            </button>
                            <a href="<?= ROOT ?>/hradmin/applications/view/1" class="btn-icon" title="View profile">
                                <i class="icon-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="candidate-title">Senior Software Engineer at Tech Solutions Inc.</div>
                    <div class="candidate-details">
                        <span class="detail-item">
                            <i class="icon-location"></i>San Francisco, CA
                        </span>
                        <span class="detail-item">
                            <i class="icon-experience"></i>5 years experience
                        </span>
                        <span class="detail-item">
                            <i class="icon-email"></i>john.smith@email.com
                        </span>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">Node.js</span>
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">AWS</span>
                    </div>
                    <div class="candidate-meta">
                        <span class="status-badge pending">In Process</span>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star empty">⭐</span>
                            <span class="rating-text">4/5</span>
                        </div>
                        <span class="last-activity">Last activity: 2 days ago</span>
                    </div>
                </div>
            </div>

            <div class="candidate-card">
                <div class="candidate-avatar">
                    <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                </div>
                <div class="candidate-info">
                    <div class="candidate-header">
                        <h4 class="candidate-name">Sarah Johnson</h4>
                        <div class="candidate-actions">
                            <button class="btn-icon favorited" title="Remove from favorites" onclick="toggleFavorite(2)">
                                <i class="icon-heart"></i>
                            </button>
                            <button class="btn-icon" title="Send message" onclick="sendMessage(2)">
                                <i class="icon-message"></i>
                            </button>
                            <a href="<?= ROOT ?>/hradmin/applications/view/2" class="btn-icon" title="View profile">
                                <i class="icon-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="candidate-title">UI/UX Designer at Design Studio Pro</div>
                    <div class="candidate-details">
                        <span class="detail-item">
                            <i class="icon-location"></i>Remote
                        </span>
                        <span class="detail-item">
                            <i class="icon-experience"></i>3 years experience
                        </span>
                        <span class="detail-item">
                            <i class="icon-email"></i>sarah.johnson@email.com
                        </span>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">Adobe XD</span>
                        <span class="skill-tag">Sketch</span>
                        <span class="skill-tag">Prototyping</span>
                        <span class="skill-tag">User Research</span>
                    </div>
                    <div class="candidate-meta">
                        <span class="status-badge shortlisted">Shortlisted</span>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="rating-text">5/5</span>
                        </div>
                        <span class="last-activity">Last activity: 1 day ago</span>
                    </div>
                </div>
            </div>

            <div class="candidate-card">
                <div class="candidate-avatar">
                    <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                </div>
                <div class="candidate-info">
                    <div class="candidate-header">
                        <h4 class="candidate-name">Mike Wilson</h4>
                        <div class="candidate-actions">
                            <button class="btn-icon" title="Add to favorites" onclick="toggleFavorite(3)">
                                <i class="icon-heart"></i>
                            </button>
                            <button class="btn-icon" title="Send message" onclick="sendMessage(3)">
                                <i class="icon-message"></i>
                            </button>
                            <a href="<?= ROOT ?>/hradmin/applications/view/3" class="btn-icon" title="View profile">
                                <i class="icon-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="candidate-title">Marketing Manager at Growth Co.</div>
                    <div class="candidate-details">
                        <span class="detail-item">
                            <i class="icon-location"></i>New York, NY
                        </span>
                        <span class="detail-item">
                            <i class="icon-experience"></i>7 years experience
                        </span>
                        <span class="detail-item">
                            <i class="icon-email"></i>mike.wilson@email.com
                        </span>
                    </div>
                    <div class="candidate-skills">
                        <span class="skill-tag">Digital Marketing</span>
                        <span class="skill-tag">SEO</span>
                        <span class="skill-tag">Google Analytics</span>
                        <span class="skill-tag">Campaign Management</span>
                    </div>
                    <div class="candidate-meta">
                        <span class="status-badge interviewed">Interviewed</span>
                        <div class="rating">
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star">⭐</span>
                            <span class="star empty">⭐</span>
                            <span class="rating-text">4/5</span>
                        </div>
                        <span class="last-activity">Last activity: 3 days ago</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid View (Hidden by default) -->
        <div id="gridView" class="candidates-grid" style="display: none;">
            <!-- Grid view cards would go here -->
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            Showing 1-3 of 1,247 candidates
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
.search-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.search-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.search-header h3 {
    margin: 0;
    color: #2c3e50;
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.search-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.search-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.search-group label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.875rem;
}

.search-input, .search-select {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.875rem;
}

.search-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.results-section {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.results-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.results-count {
    font-weight: 600;
    color: #2c3e50;
}

.view-options {
    display: flex;
    gap: 0.25rem;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.25rem;
}

.view-btn {
    padding: 0.5rem;
    border: none;
    background: none;
    cursor: pointer;
    border-radius: 4px;
    transition: all 0.2s;
}

.view-btn.active {
    background: #4e31aa;
    color: white;
}

.sort-select {
    padding: 0.5rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 0.875rem;
}

.candidates-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.candidate-card {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.2s;
}

.candidate-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-color: #4e31aa;
}

.candidate-avatar .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}

.candidate-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.candidate-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.candidate-name {
    margin: 0;
    color: #2c3e50;
    font-size: 1.125rem;
}

.candidate-actions {
    display: flex;
    gap: 0.25rem;
}

.btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    background: white;
    color: #6c757d;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #f8f9fa;
    color: #495057;
}

.btn-icon.favorited {
    color: #dc3545;
    border-color: #dc3545;
}

.candidate-title {
    color: #6c757d;
    font-size: 0.875rem;
    font-style: italic;
}

.candidate-details {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.875rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #6c757d;
}

.candidate-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.skill-tag {
    padding: 0.25rem 0.75rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #495057;
}

.candidate-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
}

.last-activity {
    color: #6c757d;
}

.candidates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

/* Icon styles */
.icon-export::before { content: '📤'; }
.icon-import::before { content: '📥'; }
.icon-search::before { content: '🔍'; }
.icon-list::before { content: '📋'; }
.icon-grid::before { content: '⊞'; }
.icon-heart::before { content: '🤍'; }
.icon-message::before { content: '💬'; }
.icon-eye::before { content: '👁️'; }
.icon-location::before { content: '📍'; }
.icon-experience::before { content: '💼'; }
.icon-email::before { content: '📧'; }

.btn-icon.favorited .icon-heart::before { content: '❤️'; }

/* Responsive design */
@media (max-width: 768px) {
    .search-row {
        grid-template-columns: 1fr;
    }
    
    .results-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .candidate-card {
        flex-direction: column;
        text-align: center;
    }
    
    .candidate-header {
        flex-direction: column;
        gap: 0.5rem;
        align-items: center;
    }
    
    .candidate-details {
        justify-content: center;
    }
    
    .search-actions {
        flex-direction: column;
    }
}
</style>

<script>
function exportDatabase() {
    alert('Exporting candidate database...');
    // Implement export functionality
}

function importCandidates() {
    alert('Opening import dialog...');
    // Implement import functionality
}

function resetFilters() {
    document.querySelectorAll('.search-input, .search-select').forEach(element => {
        element.value = '';
    });
    searchCandidates();
}

function searchCandidates() {
    alert('Searching candidates with current filters...');
    // Implement search functionality
}

function saveSearch() {
    const searchName = prompt('Enter a name for this search:');
    if (searchName) {
        alert(`Search saved as: ${searchName}`);
    }
}

function setView(viewType) {
    const listView = document.getElementById('listView');
    const gridView = document.getElementById('gridView');
    const viewButtons = document.querySelectorAll('.view-btn');
    
    viewButtons.forEach(btn => btn.classList.remove('active'));
    
    if (viewType === 'list') {
        listView.style.display = 'flex';
        gridView.style.display = 'none';
        document.querySelector('.view-btn').classList.add('active');
    } else {
        listView.style.display = 'none';
        gridView.style.display = 'grid';
        document.querySelectorAll('.view-btn')[1].classList.add('active');
    }
}

function toggleFavorite(candidateId) {
    const button = event.currentTarget;
    const isFavorited = button.classList.contains('favorited');
    
    if (isFavorited) {
        button.classList.remove('favorited');
        button.setAttribute('title', 'Add to favorites');
        alert(`Candidate ${candidateId} removed from favorites`);
    } else {
        button.classList.add('favorited');
        button.setAttribute('title', 'Remove from favorites');
        alert(`Candidate ${candidateId} added to favorites`);
    }
}

function sendMessage(candidateId) {
    alert(`Opening message composer for candidate ${candidateId}`);
    // Implement messaging functionality
}

// Auto-search as user types (debounced)
let searchTimeout;
document.querySelectorAll('.search-input').forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            // Auto-search after 500ms of no typing
            console.log('Auto-searching...');
        }, 500);
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
