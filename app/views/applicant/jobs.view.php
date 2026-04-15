<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/applicant/jobs.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">Applicant Portal</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/dashboard" class="nav-link">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/jobs" class="nav-link active">
                        <span class="nav-text">Browse Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/applications" class="nav-link">
                        <span class="nav-text">My Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/savedJobs" class="nav-link">
                        <span class="nav-text">Saved Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews" class="nav-link">
                        <span class="nav-text">Interview Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/interviews/feedback" class="nav-link">
                        <span class="nav-text">Interview Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/applicant/profile" class="nav-link">
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
        <header class="header">
            <div class="header-left">
                <h1 class="page-title">Browse Jobs</h1>
                <p class="page-subtitle">Find your next opportunity</p>
            </div>
            <div class="header-right">
                <?php include __DIR__ . '/components/notification-bell.view.php'; ?>
                <div class="user-info">
                    <span class="user-name"><?= $user['name'] ?? 'User' ?></span>
                    <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
                </div>
            </div>
        </header>

        <div class="jobs-content">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background-color: #d4edda; color: #155724; border-radius: 8px;">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-bottom: 20px; padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 8px;">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Search and Filter Section -->
            <div class="search-section">
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" placeholder="Search jobs by title, company, or keywords..." class="search-input" id="jobSearch">
                        <button class="search-btn">🔍</button>
                    </div>
                    <div class="filter-container">
                        <select class="filter-select" id="locationFilter">
                            <option value="">All Locations</option>
                            <option value="san-francisco">San Francisco, CA</option>
                            <option value="new-york">New York, NY</option>
                            <option value="los-angeles">Los Angeles, CA</option>
                            <option value="remote">Remote</option>
                        </select>
                        <select class="filter-select" id="typeFilter">
                            <option value="">All Job Types</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                        <select class="filter-select" id="departmentFilter">
                            <option value="">All Departments</option>
                            <option value="engineering">Engineering</option>
                            <option value="development">Development</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                        </select>
                        <button class="filter-btn">Apply Filters</button>
                    </div>
                </div>
            </div>

            <!-- Jobs Grid -->
            <div class="jobs-grid">
                <?php foreach($jobs as $job): ?>
                <div class="job-card">
                    <div class="job-header">
                        <div class="job-company">
                            <div class="company-logo"><?= strtoupper(substr($job['company'], 0, 2)) ?></div>
                            <div class="job-basic-info">
                                <h3 class="job-title"><?= $job['title'] ?></h3>
                                <p class="job-company-name"><?= $job['company'] ?></p>
                                <p class="job-location">📍 <?= $job['location'] ?></p>
                            </div>
                        </div>
                        <div class="job-badges">
                            <span class="job-type-badge <?= strtolower(str_replace(' ', '-', $job['type'])) ?>"><?= $job['type'] ?></span>
                            <?php if($job['remote']): ?>
                                <span class="remote-badge">Remote</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="job-content">
                        <div class="job-description">
                            <p><?= substr($job['description'], 0, 150) ?>...</p>
                        </div>
                        
                        <div class="job-requirements">
                            <h5>Key Requirements:</h5>
                            <ul>
                                <?php 
                                if (isset($job['requirements']) && is_array($job['requirements']) && !empty($job['requirements'])):
                                    foreach(array_slice($job['requirements'], 0, 3) as $req): 
                                ?>
                                    <li><?= htmlspecialchars($req) ?></li>
                                <?php 
                                    endforeach;
                                else: 
                                ?>
                                    <li>Requirements will be discussed during interview</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="job-footer">
                        <div class="job-meta">
                            <span class="job-salary">💰 <?= $job['salary'] ?></span>
                            <span class="job-posted">📅 Posted <?= date('M d', strtotime($job['posted_date'])) ?></span>
                        </div>
                        <div class="job-actions">
                            <a href="<?= ROOT ?>/applicant/jobs/details/<?= $job['id'] ?>" class="btn btn-outline">View Details</a>
                            <?php if(!$job['is_saved']): ?>
                                <form method="POST" action="<?= ROOT ?>/applicant/savedJobs/save" class="inline-action-form">
                                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                                    <input type="hidden" name="return_to" value="applicant/jobs">
                                    <button type="submit" class="btn btn-outline">Save Job</button>
                                </form>
                            <?php else: ?>
                                <a href="<?= ROOT ?>/applicant/savedJobs" class="btn btn-outline">Saved</a>
                            <?php endif; ?>
                            <?php if($job['form_available'] && !$job['has_applied']): ?>
                                <a href="<?= ROOT ?>/applicant/applications/apply?job_id=<?= $job['id'] ?>" class="btn btn-primary">Apply Now</a>
                            <?php elseif($job['has_applied']): ?>
                                <div class="btn btn-secondary" style="cursor: default; text-align: center;">
                                    ✓ Applied
                                </div>
                            <?php else: ?>
                                <div class="btn btn-disabled" style="cursor: not-allowed; text-align: center;" title="Application form not yet available">
                                    Opening Soon
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button -->
            <div class="load-more-section">
                <button class="btn btn-outline load-more-btn">Load More Jobs</button>
            </div>
        </div>
    </div>

    <script>
        // Simple search functionality
        document.getElementById('jobSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const jobCards = document.querySelectorAll('.job-card');
            
            jobCards.forEach(card => {
                const title = card.querySelector('.job-title').textContent.toLowerCase();
                const company = card.querySelector('.job-company-name').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || company.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-btn').addEventListener('click', function() {
            const locationFilter = document.getElementById('locationFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const departmentFilter = document.getElementById('departmentFilter').value;
            
            // Simple filter implementation for demo
            alert('Filters applied! (Demo mode)');
        });
        
        // Load more functionality
        document.querySelector('.load-more-btn').addEventListener('click', function() {
            alert('Loading more jobs... (Demo mode)');
        });
    </script>
</body>

</html>
