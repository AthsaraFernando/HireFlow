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
                    <a href="<?= ROOT ?>/hradmin/applicant-database" class="nav-link active">
                        <span class="nav-text">Applicants & Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/departments" class="nav-link">
                        <span class="nav-text">Departments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/categories" class="nav-link">
                        <span class="nav-text">Categories</span>
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
                <h1 class="page-title">Applicants & Applications Management</h1>
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
                    <h1 class="page-title">Applicants & Applications Management</h1>
                    <p class="page-description">Search and manage all candidate profiles and view job applications in one unified interface
                    </p>
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

                <!-- Tab Navigation -->
                <div class="tab-container">
                    <div class="tab-nav">
                        <button class="tab-btn <?= $active_tab === 'applicants' ? 'active' : '' ?>" onclick="switchTab('candidates')">
                            <i class="icon-users"></i>All Candidates Database
                        </button>
                        <button class="tab-btn <?= $active_tab === 'applications' ? 'active' : '' ?>" onclick="switchTab('applications')">
                            <i class="icon-applications"></i>Job Applications
                        </button>
                    </div>

                    <!-- Candidates Database Tab -->
                    <div id="candidatesTab" class="tab-content <?= $active_tab === 'applicants' ? 'active' : '' ?>">
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
                                            <i class="icon-list"></i>
                                            <span>List</span>
                                        </button>
                                        <button class="view-btn" onclick="setView('grid')">
                                            <i class="icon-grid"></i>
                                            <span>Grid</span>
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
                                <?php if(!empty($applicants)): ?>
                                    <?php foreach($applicants as $applicant): ?>
                                        <div class="candidate-card">
                                            <div class="candidate-avatar">
                                                <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                                            </div>
                                            <div class="candidate-info">
                                                <div class="candidate-header">
                                                    <h4 class="candidate-name"><?= htmlspecialchars($applicant['name']) ?></h4>
                                                    <div class="candidate-actions">
                                                        <button class="btn-icon" title="Add to favorites" onclick="toggleFavorite(<?= $applicant['id'] ?>)">
                                                            <i class="icon-heart"></i>
                                                        </button>
                                                        <button class="btn-icon" title="Send message" onclick="sendMessage(<?= $applicant['id'] ?>)">
                                                            <i class="icon-message"></i>
                                                        </button>
                                                        <a href="<?= ROOT ?>/hradmin/applicant-database/viewApplication/<?= $applicant['id'] ?>" class="btn-icon" title="View profile">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="candidate-title">Looking for new opportunities</div>
                                                <div class="candidate-details">
                                                    <span class="detail-item">
                                                        <i class="icon-location"></i><?= htmlspecialchars($applicant['location']) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <i class="icon-experience"></i><?= htmlspecialchars($applicant['experience']) ?> experience
                                                    </span>
                                                    <span class="detail-item">
                                                        <i class="icon-email"></i><?= htmlspecialchars($applicant['email']) ?>
                                                    </span>
                                                </div>
                                                <div class="candidate-skills">
                                                    <?php foreach($applicant['skills'] as $skill): ?>
                                                        <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div class="candidate-meta">
                                                    <span class="status-badge <?= strtolower($applicant['status']) ?>"><?= htmlspecialchars($applicant['status']) ?></span>
                                                    <div class="rating">
                                                        <?php 
                                                        $rating = floor($applicant['rating']);
                                                        for($i = 1; $i <= 5; $i++): 
                                                        ?>
                                                            <span class="star <?= $i > $rating ? 'empty' : '' ?>">★</span>
                                                        <?php endfor; ?>
                                                        <span class="rating-text"><?= $applicant['rating'] ?>/5</span>
                                                    </div>
                                                    <span class="last-activity">Last application: <?= $applicant['last_application'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-state">
                                        <p>No candidates found.</p>
                                    </div>
                                <?php endif; ?>
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

                    <!-- Applications Tab -->
                    <div id="applicationsTab" class="tab-content <?= $active_tab === 'applications' ? 'active' : '' ?>">
                        <!-- Application Statistics -->
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-value"><?= $total_applications ?? '1,847' ?></div>
                                <div class="stat-label">Total Applications</div>
                                <div class="stat-change positive">+25 this week</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><?= $pending_review ?? '156' ?></div>
                                <div class="stat-label">Pending Review</div>
                                <div class="stat-change positive">+12 today</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><?= $shortlisted ?? '89' ?></div>
                                <div class="stat-label">Shortlisted</div>
                                <div class="stat-change positive">+5 this week</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value"><?= $interviews_scheduled ?? '34' ?></div>
                                <div class="stat-label">Interviews Scheduled</div>
                                <div class="stat-change positive">+8 this week</div>
                            </div>
                        </div>

                        <!-- Application Filters -->
                        <div class="application-filters">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label>Job Position</label>
                                    <select class="filter-select">
                                        <option value="">All Positions</option>
                                        <option value="1">Senior Software Engineer</option>
                                        <option value="2">UI/UX Designer</option>
                                        <option value="3">Marketing Manager</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Application Status</label>
                                    <select class="filter-select">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending Review</option>
                                        <option value="reviewed">Reviewed</option>
                                        <option value="shortlisted">Shortlisted</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="interview">Interview Scheduled</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Application Date</label>
                                    <select class="filter-select">
                                        <option value="">Any Time</option>
                                        <option value="today">Today</option>
                                        <option value="week">This Week</option>
                                        <option value="month">This Month</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <button class="btn btn-primary" onclick="filterApplications()">
                                        <i class="icon-filter"></i>Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Applications List -->
                        <div class="applications-section">
                            <div class="applications-header">
                                <div class="applications-info">
                                    <span class="applications-count">Showing 1-10 of 847 applications</span>
                                </div>
                                <div class="applications-actions">
                                    <button class="btn btn-outline" onclick="bulkActions()">Bulk Actions</button>
                                    <select class="sort-select">
                                        <option value="recent">Most Recent</option>
                                        <option value="name">Applicant Name</option>
                                        <option value="position">Job Position</option>
                                        <option value="status">Status</option>
                                    </select>
                                </div>
                            </div>

                            <div class="applications-list">
                                <?php if(!empty($applications)): ?>
                                    <?php foreach($applications as $application): ?>
                                        <div class="application-card">
                                            <div class="application-checkbox">
                                                <input type="checkbox" class="application-select" value="<?= $application['id'] ?>">
                                            </div>
                                            <div class="applicant-avatar">
                                                <img src="<?= ROOT ?>/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                                            </div>
                                            <div class="application-info">
                                                <div class="application-header">
                                                    <h4 class="applicant-name"><?= htmlspecialchars($application['applicant_name']) ?></h4>
                                                    <div class="application-actions">
                                                        <button class="btn-icon" title="View application" onclick="viewApplication(<?= $application['id'] ?>)">
                                                            <i class="icon-eye"></i>
                                                        </button>
                                                        <button class="btn-icon" title="Schedule interview" onclick="scheduleInterview(<?= $application['id'] ?>)">
                                                            <i class="icon-calendar"></i>
                                                        </button>
                                                        <button class="btn-icon" title="Send message" onclick="sendMessage(<?= $application['id'] ?>)">
                                                            <i class="icon-message"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="job-position">Applied for: <?= htmlspecialchars($application['position']) ?></div>
                                                <div class="application-details">
                                                    <span class="detail-item">
                                                        <i class="icon-calendar"></i>Applied: <?= date('M d, Y', strtotime($application['applied_date'])) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <i class="icon-experience"></i><?= htmlspecialchars($application['experience']) ?> experience
                                                    </span>
                                                    <span class="detail-item">
                                                        <i class="icon-location"></i><?= htmlspecialchars($application['location']) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <i class="icon-phone"></i><?= htmlspecialchars($application['phone']) ?>
                                                    </span>
                                                </div>
                                                <div class="application-meta">
                                                    <span class="status-badge <?= strtolower($application['status']) ?>"><?= ucfirst($application['status']) ?></span>
                                                    <span class="match-score">Source: <?= ucfirst($application['source']) ?></span>
                                                    <?php if(isset($application['rating'])): ?>
                                                        <span class="last-activity">Rating: <?= $application['rating'] ?>/5</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-state">
                                        <p>No applications found.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Applications Pagination -->
                        <div class="pagination-container">
                            <div class="pagination-info">
                                Showing 1-2 of 847 applications
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
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Page Styling */
        .dashboard-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .header-section .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            color: white;
        }

        .header-section .page-description {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
        }

        /* Enhanced Tab Styling */
        .tab-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .tab-nav {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .tab-btn {
            flex: 1;
            padding: 1.25rem 2rem;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            font-size: 1rem;
        }

        .tab-btn:hover {
            background: rgba(78, 49, 170, 0.05);
            color: #4e31aa;
        }

        .tab-btn.active {
            background: white;
            color: #4e31aa;
            border-bottom: 3px solid #4e31aa;
        }

        .tab-content {
            padding: 2rem;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Enhanced Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(78, 49, 170, 0.08);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4e31aa;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            display: inline-block;
        }

        .stat-change.positive {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .stat-change.neutral {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

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

        .search-input,
        .search-select {
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
            padding: 0.5rem 0.75rem;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #495057;
        }

        .view-btn:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .view-btn:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .view-btn.active {
            background: #4e31aa;
            color: white;
            border-color: #4e31aa;
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
            gap: 1.5rem;
        }

        .candidate-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            border: 1px solid rgba(78, 49, 170, 0.08);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
        }

        .candidate-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border-color: rgba(78, 49, 170, 0.2);
        }

        .candidate-avatar img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(78, 49, 170, 0.1);
        }

        .candidate-info {
            flex: 1;
        }

        .candidate-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .candidate-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
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
            margin-bottom: 1rem;
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

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .star {
            color: #ffc107;
            font-size: 1rem;
        }

        .star.empty {
            color: #dee2e6;
        }

        .rating-text {
            margin-left: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #495057;
        }

        /* Application Cards */
        .applications-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .application-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            border: 1px solid rgba(78, 49, 170, 0.08);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .application-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border-color: rgba(78, 49, 170, 0.2);
        }

        .application-checkbox {
            margin-top: 0.5rem;
        }

        .application-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .application-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .applicant-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .job-position {
            font-weight: 600;
            color: #4e31aa;
            font-size: 0.875rem;
        }

        .application-details {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .application-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .match-score {
            font-weight: 600;
            color: #28a745;
        }

        /* Status Badge Colors */
        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-badge.shortlisted {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-badge.interviewed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-badge.rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Enhanced Button and Icon Styling */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: #ffffff;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(255,255,255,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,255,255,0.3);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .icon-export::before {
            content: '📤';
        }

        .icon-import::before {
            content: '📥';
        }

        .icon-search::before {
            content: '🔍';
        }

        .icon-eye::before {
            content: '👁';
        }

        .icon-heart::before {
            content: '♡';
        }

        .icon-heart:hover::before,
        .btn-icon.favorited .icon-heart::before {
            content: '♥';
            color: #dc3545;
        }

        .icon-message::before {
            content: '✉';
        }

        .icon-phone::before {
            content: '📞';
        }

        .icon-location::before {
            content: '📍';
        }

        .icon-experience::before {
            content: '💼';
        }

        .icon-email::before {
            content: '✉';
        }

        /* Additional Icons */
        .icon-users::before {
            content: '�';
        }

        .icon-applications::before {
            content: '�';
        }

        .icon-filter::before {
            content: '🔍';
        }

        .icon-calendar::before {
            content: '�';
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tab-nav {
                flex-direction: column;
            }

            .applications-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .application-card {
                flex-direction: column;
            }

            .application-header {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
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

        // Tab switching functionality
        function switchTab(tabName) {
            // Remove active class from all tabs and buttons
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to selected tab and button
            document.getElementById(tabName + 'Tab').classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Application-specific functions
        function filterApplications() {
            alert('Filtering applications...');
            // Implement filter functionality
        }

        function bulkActions() {
            const selectedApps = document.querySelectorAll('.application-select:checked');
            if (selectedApps.length === 0) {
                alert('Please select applications first');
                return;
            }
            alert(`Bulk actions for ${selectedApps.length} applications`);
        }

        function viewApplication(applicationId) {
            window.location.href = `<?= ROOT ?>/hradmin/applicant-database/viewApplication/${applicationId}`;
        }

        function scheduleInterview(applicationId) {
            alert(`Scheduling interview for application ${applicationId}`);
            // Implement interview scheduling
        }

        // Auto-search as user types (debounced)
        let searchTimeout;
        document.querySelectorAll('.search-input').forEach(input => {
            input.addEventListener('input', function () {
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

    <?php $this->view('components/footer') ?>
