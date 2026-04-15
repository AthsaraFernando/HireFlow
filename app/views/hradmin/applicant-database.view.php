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
        </header>

        <div class="dashboard-content">
            <div class="main-container">
                <div class="header-section">
                    <h1 class="page-title">Applicants & Applications Management</h1>
                    <p class="page-description">Search and manage all candidate profiles and view job applications in one unified interface
                    </p>
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
                        <button class="tab-btn <?= $active_tab === 'applicants' ? 'active' : '' ?>" onclick="switchTab('candidates', this)">
                            All Candidates Database
                        </button>
                        <button class="tab-btn <?= $active_tab === 'applications' ? 'active' : '' ?>" onclick="switchTab('applications', this)">
                            Job Applications
                        </button>
                    </div>

                    <!-- Candidates Database Tab -->
                    <div id="candidatesTab" class="tab-content <?= $active_tab === 'applicants' ? 'active' : '' ?>">
                        <!-- Database Statistics -->
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-value" id="candidates-total"><?= (int)($total_candidates ?? 0) ?></div>
                                <div class="stat-label">Total Candidates</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="candidates-active"><?= (int)($active_candidates ?? 0) ?></div>
                                <div class="stat-label">Active in Process</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="candidates-hired"><?= (int)($hired_candidates ?? 0) ?></div>
                                <div class="stat-label">Successfully Hired</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                        </div>

                        <!-- Advanced Search & Filters -->
                        <div class="search-section">
                            <div class="search-header">
                                <h3>Advanced Search</h3>
                                <button class="btn btn-outline btn-sm" onclick="resetFilters()">Reset Filters</button>
                                    <div class="search-group">
                                        <label>Location</label>
                                        <input type="text" id="filter-location" placeholder="City, state, remote..." class="search-input">
                                    </div>
                                    <div class="search-group">
                                        <label>Experience Level</label>
                                        <select id="filter-experience" class="search-select">
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
                                        <input type="text" id="filter-skills" placeholder="JavaScript, React, Python..." class="search-input">
                                    </div>
                                    <div class="search-group">
                                        <label>Current Status</label>
                                        <select id="filter-status" class="search-select">
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
                                        <select id="filter-date" class="search-select">
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
                                        Search Candidates
                                    </button>
                                    <button class="btn btn-secondary" onclick="saveSearch()">Save Search</button>
                                </div>
                            </div>
                        </div>

                        <!-- Results Section -->
                        <div class="results-section">
                            <div class="results-header">
                                <div class="results-info">
                                    <span class="results-count" id="candidates-results-count">Showing 1-<?= count($applicants ?? []) ?> of <?= count($applicants ?? []) ?> candidates</span>
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
                                                        <a href="<?= ROOT ?>/hradmin/applicant-database/viewApplication/<?= $applicant['id'] ?>" class="btn-icon" title="View profile">
                                                            View
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="candidate-title">Looking for new opportunities</div>
                                                <div class="candidate-details">
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($applicant['location']) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($applicant['experience']) ?> experience
                                                    </span>
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($applicant['email']) ?>
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
                            <div class="pagination-info" id="candidates-pagination-info">
                                Showing 1-<?= count($applicants ?? []) ?> of <?= count($applicants ?? []) ?> candidates
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
                                <div class="stat-value" id="applications-total"><?= (int)($total_applications ?? 0) ?></div>
                                <div class="stat-label">Total Applications</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="applications-pending"><?= (int)($pending_review ?? 0) ?></div>
                                <div class="stat-label">Pending Review</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="applications-shortlisted"><?= (int)($shortlisted ?? 0) ?></div>
                                <div class="stat-label">Shortlisted</div>
                                <div class="stat-change positive">Live from database</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="applications-interviewed"><?= (int)($interviewed ?? 0) ?></div>
                                <div class="stat-label">Interviews Scheduled</div>
                                <div class="stat-change positive">Live from database</div>
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
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Applications List -->
                        <div class="applications-section">
                            <div class="applications-header">
                                <div class="applications-info">
                                    <span class="applications-count" id="applications-results-count">Showing 1-<?= count($applications ?? []) ?> of <?= count($applications ?? []) ?> applications</span>
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

                            <div class="applications-list" id="applications-list-container">
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
                                                            View
                                                        </button>
                                                        <button class="btn-icon" title="Schedule interview" onclick="scheduleInterview(<?= $application['id'] ?>)">
                                                            Interview
                                                        </button>
                                                        <button class="btn-icon" title="Send message" onclick="sendMessage(<?= $application['id'] ?>)">
                                                            Msg
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="job-position">Applied for: <?= htmlspecialchars($application['position']) ?></div>
                                                <div class="application-details">
                                                    <span class="detail-item">
                                                        Applied: <?= date('M d, Y', strtotime($application['applied_date'])) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($application['experience']) ?> experience
                                                    </span>
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($application['location']) ?>
                                                    </span>
                                                    <span class="detail-item">
                                                        <?= htmlspecialchars($application['phone']) ?>
                                                    </span>
                                                </div>
                                                <div class="application-meta">
                                                    <span class="status-badge <?= htmlspecialchars(strtolower($application['status'])) ?>"><?= htmlspecialchars($application['status_label'] ?? ucfirst(str_replace('-', ' ', $application['status']))) ?></span>
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
                            <div class="pagination-info" id="applications-pagination-info">
                                Showing 1-<?= count($applications ?? []) ?> of <?= count($applications ?? []) ?> applications
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
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --background-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --card-border: #e7e9f3;
            --card-shadow: 0 8px 24px rgba(86, 76, 207, 0.08);
            --hover-shadow: 0 14px 28px rgba(86, 76, 207, 0.14);
            --text-primary: #2f3552;
            --text-secondary: #6d7485;
            --accent: #5a4ccf;
            --accent-soft: #edf1ff;
        }

        /* Enhanced Page Styling */
        .dashboard-content {
            background: var(--background-gradient);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 14px 28px rgba(86, 76, 207, 0.22);
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
            box-shadow: var(--card-shadow);
            border: 1px solid var(--card-border);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .tab-nav {
            display: flex;
            background: linear-gradient(135deg, #fafaff 0%, #f4f5ff 100%);
            border-bottom: 1px solid #ececf5;
        }

        .tab-btn {
            flex: 1;
            padding: 1.25rem 2rem;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            font-size: 1rem;
        }

        .tab-btn:hover {
            background: #f1efff;
            color: var(--accent);
        }

        .tab-btn.active {
            background: white;
            color: var(--accent);
            border-bottom: 3px solid var(--accent);
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
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--card-border);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--hover-shadow);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3d3e8e;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
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
            background: #e9f8ef;
            color: #1f8d56;
        }

        .stat-change.neutral {
            background: #eef1f7;
            color: #5a647a;
        }

        .search-section {
            background: white;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .search-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #ececf5;
        }

        .search-header h3 {
            margin: 0;
            color: var(--text-primary);
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
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .search-input,
        .search-select {
            padding: 0.75rem;
            border: 1px solid #d8deef;
            border-radius: 6px;
            font-size: 0.875rem;
            color: var(--text-primary);
            background: #fff;
        }

        .search-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ececf5;
        }

        .results-section {
            background: white;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #ececf5;
        }

        .results-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .results-count {
            font-weight: 600;
            color: var(--text-primary);
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
            box-shadow: var(--card-shadow);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
        }

        .candidate-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--hover-shadow);
            border-color: #d6d2ff;
        }

        .candidate-avatar img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e7e4ff;
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
            color: var(--text-primary);
            margin: 0;
        }

        .candidate-title {
            color: var(--text-secondary);
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
            color: var(--text-secondary);
        }

        .candidate-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .skill-tag {
            padding: 0.25rem 0.75rem;
            background: #f6f7ff;
            border: 1px solid #e1e6ff;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #4a5294;
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
            color: var(--text-primary);
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
            box-shadow: var(--card-shadow);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .application-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--hover-shadow);
            border-color: #d6d2ff;
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
            color: var(--text-primary);
            margin: 0;
        }

        .job-position {
            font-weight: 600;
            color: var(--accent);
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
            color: #1f8d56;
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
            border-radius: 10px;
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
            color: var(--accent);
            box-shadow: 0 6px 18px rgba(53, 49, 113, 0.18);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(53, 49, 113, 0.24);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.45);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: #f6f7ff;
            color: #4650a0;
            border: 1px solid #dce2ff;
        }

        .btn-outline:hover {
            background: #edf0ff;
            color: #3946a0;
        }

        .search-input:focus,
        .search-select:focus,
        .filter-select:focus,
        .sort-select:focus {
            outline: none;
            border-color: #a7aeef;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.16);
        }

        .applications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            width: 100%;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .filter-group label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .filter-select {
            padding: 0.7rem;
            border: 1px solid #d8deef;
            border-radius: 8px;
            background: #fff;
            color: var(--text-primary);
        }

        .btn-icon {
            border: 1px solid #d7dcf2;
            background: #f7f8ff;
            color: #4550a0;
            border-radius: 8px;
            padding: 0.45rem 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: #ecefff;
            border-color: #bfc8ff;
            color: #323b83;
        }

        .pagination-container {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #ececf5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .pagination {
            display: flex;
            gap: 0.45rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            border: 1px solid #d7dcf2;
            background: #f8f9ff;
            color: #4753a6;
            border-radius: 8px;
            padding: 0.45rem 0.75rem;
            font-weight: 600;
            cursor: pointer;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #ecefff;
            border-color: #bec7ff;
        }

        .pagination-btn.active {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .pagination-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .empty-state {
            border: 1px dashed #cfd5ef;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: var(--text-secondary);
            background: #fafbff;
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
        window.__candidateFilterState = {
            allApplicants: [],
            allApplications: []
        };

        function exportDatabase() {
            alert('Exporting candidate database...');
            // Implement export functionality
        }

        function importCandidates() {
            alert('Opening import dialog...');
            // Implement import functionality
        }

        function resetFilters() {
            const fields = ['filter-keyword', 'filter-location', 'filter-experience', 'filter-skills', 'filter-status', 'filter-date'];
            fields.forEach((fieldId) => {
                const element = document.getElementById(fieldId);
                if (element) {
                    element.value = '';
                }
            });

            if (typeof window.__applyCandidateFilters === 'function') {
                window.__applyCandidateFilters();
            }
        }

        function searchCandidates() {
            if (typeof window.__applyCandidateFilters === 'function') {
                window.__applyCandidateFilters();
            }
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
        function switchTab(tabName, button) {
            // Remove active class from all tabs and buttons
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to selected tab and button
            document.getElementById(tabName + 'Tab').classList.add('active');
            if (button) {
                button.classList.add('active');
            }
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
        document.querySelectorAll('#filter-keyword, #filter-location, #filter-skills').forEach(input => {
            input.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchCandidates();
                }, 500);
            });
        });

        document.querySelectorAll('#filter-experience, #filter-status, #filter-date').forEach(select => {
            select.addEventListener('change', function () {
                searchCandidates();
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
            const rootUrl = '<?= ROOT ?>';
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href').includes(currentPath)) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });

            const escapeHtml = (value) => {
                const text = String(value ?? '');
                return text
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            };

            const formatDate = (dateValue) => {
                if (!dateValue) {
                    return '';
                }

                const date = new Date(dateValue);
                if (Number.isNaN(date.getTime())) {
                    return dateValue;
                }

                return date.toLocaleDateString(undefined, {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                });
            };

            const setText = (id, value) => {
                const node = document.getElementById(id);
                if (node) {
                    node.textContent = value;
                }
            };

            const normalize = (value) => String(value ?? '').trim().toLowerCase();

            const parseExperienceYears = (experienceValue) => {
                const raw = String(experienceValue ?? '');
                const match = raw.match(/(\d+(?:\.\d+)?)/);
                if (!match) {
                    return null;
                }

                const years = Number(match[1]);
                return Number.isFinite(years) ? years : null;
            };

            const matchesExperienceLevel = (applicant, selectedLevel) => {
                if (!selectedLevel) {
                    return true;
                }

                const years = parseExperienceYears(applicant.experience);
                if (years === null) {
                    return false;
                }

                if (selectedLevel === 'entry') {
                    return years <= 2;
                }
                if (selectedLevel === 'mid') {
                    return years >= 3 && years <= 5;
                }
                if (selectedLevel === 'senior') {
                    return years >= 6 && years <= 10;
                }
                if (selectedLevel === 'lead') {
                    return years > 10;
                }

                return true;
            };

            const matchesCandidateStatus = (applicant, selectedStatus) => {
                if (!selectedStatus) {
                    return true;
                }

                const latestApplicationStatus = normalize(applicant.latest_application_status);
                const userStatus = normalize(applicant.status);

                const statusMap = {
                    new: ['applied'],
                    in_process: ['under review', 'shortlisted'],
                    interviewed: ['interview scheduled', 'interview completed'],
                    offered: ['offered'],
                    hired: ['hired'],
                    archived: ['rejected']
                };

                if (selectedStatus === 'archived' && userStatus === 'inactive') {
                    return true;
                }

                const mappedStatuses = statusMap[selectedStatus] || [];
                return mappedStatuses.includes(latestApplicationStatus);
            };

            const matchesDateRange = (applicant, selectedDateRange) => {
                if (!selectedDateRange) {
                    return true;
                }

                const lastApplicationDate = new Date(applicant.last_application || '');
                if (Number.isNaN(lastApplicationDate.getTime())) {
                    return false;
                }

                const now = new Date();
                const start = new Date(now);

                if (selectedDateRange === 'today') {
                    start.setHours(0, 0, 0, 0);
                    return lastApplicationDate >= start;
                }

                if (selectedDateRange === 'week') {
                    start.setDate(now.getDate() - 7);
                    return lastApplicationDate >= start;
                }

                if (selectedDateRange === 'month') {
                    start.setMonth(now.getMonth() - 1);
                    return lastApplicationDate >= start;
                }

                if (selectedDateRange === 'quarter') {
                    start.setMonth(now.getMonth() - 3);
                    return lastApplicationDate >= start;
                }

                if (selectedDateRange === 'year') {
                    start.setFullYear(now.getFullYear() - 1);
                    return lastApplicationDate >= start;
                }

                return true;
            };

            const updateCountText = (total, type) => {
                const normalizedTotal = Number(total || 0);
                if (normalizedTotal <= 0) {
                    return `Showing 0 of 0 ${type}`;
                }
                return `Showing 1-${normalizedTotal} of ${normalizedTotal} ${type}`;
            };

            window.__applyCandidateFilters = () => {
                const keyword = normalize(document.getElementById('filter-keyword')?.value || '');
                const location = normalize(document.getElementById('filter-location')?.value || '');
                const skills = normalize(document.getElementById('filter-skills')?.value || '');
                const experience = normalize(document.getElementById('filter-experience')?.value || '');
                const status = normalize(document.getElementById('filter-status')?.value || '');
                const dateRange = normalize(document.getElementById('filter-date')?.value || '');

                const applicants = Array.isArray(window.__candidateFilterState.allApplicants)
                    ? window.__candidateFilterState.allApplicants
                    : [];

                const filtered = applicants.filter((applicant) => {
                    const searchableText = normalize([
                        applicant.name,
                        applicant.email,
                        applicant.phone,
                        applicant.location,
                        applicant.latest_application_status,
                        ...(Array.isArray(applicant.skills) ? applicant.skills : [])
                    ].join(' '));

                    const locationText = normalize(applicant.location);
                    const skillsText = normalize((Array.isArray(applicant.skills) ? applicant.skills : []).join(' '));

                    if (keyword && !searchableText.includes(keyword)) {
                        return false;
                    }

                    if (location && !locationText.includes(location)) {
                        return false;
                    }

                    if (skills && !skillsText.includes(skills)) {
                        return false;
                    }

                    if (!matchesExperienceLevel(applicant, experience)) {
                        return false;
                    }

                    if (!matchesCandidateStatus(applicant, status)) {
                        return false;
                    }

                    if (!matchesDateRange(applicant, dateRange)) {
                        return false;
                    }

                    return true;
                });

                renderApplicants(filtered);
                setText('candidates-results-count', updateCountText(filtered.length, 'candidates'));
                setText('candidates-pagination-info', updateCountText(filtered.length, 'candidates'));
            };

            const renderApplicants = (applicants) => {
                const listView = document.getElementById('listView');
                if (!listView) {
                    return;
                }

                if (!Array.isArray(applicants) || applicants.length === 0) {
                    listView.innerHTML = '<div class="empty-state"><p>No candidates found.</p></div>';
                    return;
                }

                listView.innerHTML = applicants.map((applicant) => {
                    const rating = Math.floor(Number(applicant.rating || 0));
                    const stars = Array.from({ length: 5 }, (_, index) => {
                        return `<span class="star ${index + 1 > rating ? 'empty' : ''}">★</span>`;
                    }).join('');

                    return `
                        <div class="candidate-card">
                            <div class="candidate-avatar">
                                <img src="${rootUrl}/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                            </div>
                            <div class="candidate-info">
                                <div class="candidate-header">
                                    <h4 class="candidate-name">${escapeHtml(applicant.name || '')}</h4>
                                    <div class="candidate-actions">
                                        <a href="${rootUrl}/hradmin/applicant-database/viewApplication/${Number(applicant.id || 0)}" class="btn-icon" title="View profile">
                                            View
                                        </a>
                                    </div>
                                </div>
                                <div class="candidate-title">Looking for new opportunities</div>
                                <div class="candidate-details">
                                    <span class="detail-item">${escapeHtml(applicant.location || 'N/A')}</span>
                                    <span class="detail-item">${escapeHtml(applicant.experience || 'N/A')} experience</span>
                                    <span class="detail-item">${escapeHtml(applicant.email || 'N/A')}</span>
                                </div>
                                <div class="candidate-skills"></div>
                                <div class="candidate-meta">
                                    <span class="status-badge ${escapeHtml(String(applicant.status || '').toLowerCase())}">${escapeHtml(applicant.status || '')}</span>
                                    <div class="rating">${stars}<span class="rating-text">${Number(applicant.rating || 0)}/5</span></div>
                                    <span class="last-activity">Last application: ${escapeHtml(applicant.last_application || 'Never')}</span>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const renderApplications = (applications) => {
                const container = document.getElementById('applications-list-container');
                if (!container) {
                    return;
                }

                if (!Array.isArray(applications) || applications.length === 0) {
                    container.innerHTML = '<div class="empty-state"><p>No applications found.</p></div>';
                    return;
                }

                container.innerHTML = applications.map((application) => {
                    const statusClass = String(application.status || '').toLowerCase();
                    const statusLabel = application.status_label || statusClass.replace('-', ' ');

                    return `
                        <div class="application-card">
                            <div class="application-checkbox">
                                <input type="checkbox" class="application-select" value="${Number(application.id || 0)}">
                            </div>
                            <div class="applicant-avatar">
                                <img src="${rootUrl}/assets/images/avatar-placeholder.png" alt="Profile" class="avatar">
                            </div>
                            <div class="application-info">
                                <div class="application-header">
                                    <h4 class="applicant-name">${escapeHtml(application.applicant_name || '')}</h4>
                                    <div class="application-actions">
                                        <button class="btn-icon" title="View application" onclick="viewApplication(${Number(application.id || 0)})">View</button>
                                        <button class="btn-icon" title="Schedule interview" onclick="scheduleInterview(${Number(application.id || 0)})">Interview</button>
                                        <button class="btn-icon" title="Send message" onclick="sendMessage(${Number(application.id || 0)})">Msg</button>
                                    </div>
                                </div>
                                <div class="job-position">Applied for: ${escapeHtml(application.position || 'N/A')}</div>
                                <div class="application-details">
                                    <span class="detail-item">Applied: ${escapeHtml(formatDate(application.applied_date || ''))}</span>
                                    <span class="detail-item">${escapeHtml(application.experience || 'N/A')} experience</span>
                                    <span class="detail-item">${escapeHtml(application.location || 'N/A')}</span>
                                    <span class="detail-item">${escapeHtml(application.phone || 'N/A')}</span>
                                </div>
                                <div class="application-meta">
                                    <span class="status-badge ${escapeHtml(statusClass)}">${escapeHtml(statusLabel)}</span>
                                    <span class="match-score">Source: ${escapeHtml(String(application.source || 'website').replace(/^./, (c) => c.toUpperCase()))}</span>
                                    <span class="last-activity">Rating: ${Number(application.rating || 0)}/5</span>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const applyLiveData = (payload) => {
                window.__candidateFilterState.allApplicants = Array.isArray(payload.applicants) ? payload.applicants : [];
                window.__candidateFilterState.allApplications = Array.isArray(payload.applications) ? payload.applications : [];

                setText('candidates-total', Number(payload.total_candidates || 0));
                setText('candidates-active', Number(payload.active_candidates || 0));
                setText('candidates-hired', Number(payload.hired_candidates || 0));

                setText('applications-total', Number(payload.total_applications || 0));
                setText('applications-pending', Number(payload.pending_review || 0));
                setText('applications-shortlisted', Number(payload.shortlisted || 0));
                setText('applications-interviewed', Number(payload.interviewed || 0));

                setText('candidates-results-count', updateCountText(payload.total_candidates || 0, 'candidates'));
                setText('candidates-pagination-info', updateCountText(payload.total_candidates || 0, 'candidates'));

                setText('applications-results-count', updateCountText(payload.total_applications || 0, 'applications'));
                setText('applications-pagination-info', updateCountText(payload.total_applications || 0, 'applications'));

                window.__applyCandidateFilters();
                renderApplications(payload.applications || []);
            };

            const refreshLiveData = async () => {
                try {
                    const response = await fetch(`${rootUrl}/hradmin/applicant-database/liveData`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        cache: 'no-store'
                    });

                    if (!response.ok) {
                        return;
                    }

                    const payload = await response.json();
                    if (!payload || payload.success !== true || !payload.data) {
                        return;
                    }

                    applyLiveData(payload.data);
                } catch (error) {
                }
            };

            refreshLiveData();
            setInterval(refreshLiveData, 30000);
        });
    </script>

    <?php $this->view('components/footer') ?>
