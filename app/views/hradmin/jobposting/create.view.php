<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job Posting - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/dashboard.style.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/jobposting.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

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
                    <a href="<?= ROOT ?>/hradmin/jobposting" class="nav-link active">
                        <span class="nav-text">Job Posting</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/reports" class="nav-link">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/hradmin/applications" class="nav-link">
                        <span class="nav-text">Applications</span>
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
                    &#9776;
                </button>
                <h1 class="page-title">Create New Job Posting</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? 'HR Admin' ?>
                        </span>
                        <span class="user-role">HR Administrator</span>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="create-job-container">
                <div class="page-header">
                    <h1>Create New Job Posting</h1>
                    <button class="btn btn-secondary" onclick="window.location.href='<?= ROOT ?>/hradmin/jobposting'">
                        <i class="fas fa-arrow-left"></i> Back to Job Postings
                    </button>
                </div>

                <div class="form-container">
                    <form method="POST" class="job-form" id="jobForm">
                        <div class="form-grid">
                            <!-- Left Column -->
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="title" class="required">Job Title</label>
                                    <input type="text" id="title" name="title" placeholder="e.g. Senior Software Engineer" required>
                                    <div class="error-message" id="titleError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="company" class="required">Company</label>
                                    <input type="text" id="company" name="company" placeholder="e.g. Tech Corp" required>
                                    <div class="error-message" id="companyError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="location" class="required">Location</label>
                                    <input type="text" id="location" name="location" placeholder="e.g. Colombo, Sri Lanka" required>
                                    <div class="error-message" id="locationError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="salary" class="required">Salary</label>
                                    <input type="text" id="salary" name="salary" placeholder="e.g. 50000 LKR" required>
                                    <div class="error-message" id="salaryError"></div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="form-column">
                                <div class="form-group">
                                    <label for="department" class="required">Department</label>
                                    <select id="department" name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Sales">Sales</option>
                                        <option value="HR">Human Resources</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Operations">Operations</option>
                                        <option value="Design">Design</option>
                                        <option value="Product">Product</option>
                                    </select>
                                    <div class="error-message" id="departmentError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="deadline" class="required">Application Deadline</label>
                                    <input type="date" id="deadline" name="deadline" required>
                                    <div class="error-message" id="deadlineError"></div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="Open">Open</option>
                                        <option value="Draft">Draft</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Full Width Description -->
                        <div class="form-group full-width">
                            <label for="description">Job Description</label>
                            <textarea id="description" name="description" rows="8" 
                                placeholder="Provide a detailed description of the job role, responsibilities, requirements, and qualifications..."
                                minlength="50"></textarea>
                            <div class="character-count">
                                <span id="charCount">0</span>/50 characters minimum
                            </div>
                            <div class="error-message" id="descriptionError"></div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= ROOT ?>/hradmin/jobposting'">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Display -->
    <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <script>
        const ROOT = '<?= ROOT ?>';
    </script>
    <script src="<?= ROOT ?>/assets/js/jobposting-form.js"></script>
</body>
</html>
