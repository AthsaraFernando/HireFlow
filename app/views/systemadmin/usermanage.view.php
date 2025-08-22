<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/usermanage.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    <script type="module" src="<?= ROOT ?>/assets/js/systemadmin/usermanage.script.js" defer></script>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2 class="brand-title">Hire<span class="dark">Flow</span></h2>
            <p class="brand-subtitle">System Admin</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/dashboard" class="nav-link active">
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/usermanage" class="nav-link">
                        <span class="nav-text">Manage Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/viewdata" class="nav-link">
                        <span class="nav-text">Reports & Analytics</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/accesslogs" class="nav-link">
                        <span class="nav-text">Access Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= ROOT ?>/systemadmin/profile" class="nav-link">
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
                    < </button>
                        <h1 class="page-title">Manage Users</h1>
            </div>

            <div class="header-right">
                <div class="header-notifications">
                    <button class="notification-btn"></button>
                </div>

                <div class="header-user">
                    <div class="user-info">
                        <span class="user-name">
                            <?= $_SESSION['USER']['full_name'] ?? '' ?></span>
                        <span class="user-role">System Administrator</span>
                    </div>
                    <div class="user-avatar">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <div class="dashboard-sections">
                <!-- Create section -->
                <div class="dashboard-section create-section">
                    <div class="section-header">
                        <h2 class="section-title">Create System Accounts</h2>
                        <p class="section-description">Create HR Admin and Recruitment Manager accounts</p>
                    </div>

                    <form method="POST" action="<?= ROOT ?>/systemadmin/createuser" class="create-user-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-input"
                                    placeholder="Enter first name" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-input"
                                    placeholder="Enter last name" required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-input"
                                    placeholder="Enter email address" required>
                            </div>

                            <div class="form-group">
                                <label for="role_id" class="form-label">User Role</label>
                                <select id="role_id" name="role_id" class="form-select" required>
                                    <option value="">Select Role</option>
                                    <option value="2">HR Admin</option>
                                    <option value="3">Recruitment Manager</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="temp_password" class="form-label">Temporary Password</label>
                            <div class="password-input-group">
                                <input type="password" id="temp_password" name="temp_password" class="form-input"
                                    placeholder="Generate temporary password" required>
                                <button type="button" class="btn btn-secondary" id="generatePassword">
                                    Generate
                                </button>
                            </div>
                            <small class="form-help">User will be required to change password on first login</small>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                Create Account
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                Reset Form
                            </button>
                        </div>
                    </form>

                </div>

                <!-- Update section -->
                <div class="dashboard-section update-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            Update User Accounts
                        </h2>
                        <div class="section-controls">
                            <div class="search-box">
                                <input type="text" id="userSearch" class="search-input" placeholder="Search users...">
                            </div>
                            <select id="roleFilter" class="search-select">
                                <option value="">All Roles</option>
                                <option value="2">HR Admin</option>
                                <option value="3">Recruitment Manager</option>
                                <option value="4">Applicant</option>
                            </select>
                        </div>
                    </div>

                    <div class="users-table-container">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr data-user-id="<?= $user['id'] ?>" data-role="<?= $user['role_id'] ?>">
                                            <td><?= str_pad($user['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                            <td>
                                                <div class="user-name-cell">
                                                    <div class="user-avatar-small">
                                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                                    </div>
                                                    <span><?= htmlspecialchars($user['full_name']) ?></span>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <!-- <span class="abc"></span> -->
                                                <span class="role-badge role-<?= $user['role_id'] ?>">
                                                    <?= match ((string) ($user['role_id'])) {
                                                        "1" => 'System Admin',
                                                        "2" => 'HR Admin',
                                                        "3" => 'Recruitment Manager',
                                                        "4" => 'Applicant',
                                                        default => 'Unknown Role'
                                                    } ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="status-badge <?= $user['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                                                    <?= ucfirst($user['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M j, Y H:i', strtotime($user['created_at'])) ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <?php if ($user['role_id'] != 1): // Can't delete system admin ?>
                                                        <button class="btn-action btn-edit"
                                                            onclick="editUser(<?= $user['id'] ?>)">Edit
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <p>No users found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Delete section -->
                <div class="dashboard-section update-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            Delete User Accounts
                        </h2>
                        <div class="section-controls">
                            <div class="search-box">
                                <input type="text" id="userSearch" class="search-input" placeholder="Search users...">
                            </div>
                            <select id="roleFilter" class="search-select">
                                <option value="">All Roles</option>
                                <option value="2">HR Admin</option>
                                <option value="3">Recruitment Manager</option>
                                <option value="4">Applicant</option>
                            </select>
                        </div>
                    </div>

                    <div class="users-table-container">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr data-user-id="<?= $user['id'] ?>" data-role="<?= $user['role_id'] ?>">
                                            <td><?= str_pad($user['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                            <td>
                                                <div class="user-name-cell">
                                                    <div class="user-avatar-small">
                                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                                    </div>
                                                    <span><?= htmlspecialchars($user['full_name']) ?></span>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <span class="role-badge role-<?= $user['role_id'] ?>">
                                                    <?= match ((string) ($user['role_id'])) {
                                                        "1" => 'System Admin',
                                                        "2" => 'HR Admin',
                                                        "3" => 'Recruitment Manager',
                                                        "4" => 'Applicant',
                                                        default => 'Unknown Role'
                                                    } ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="status-badge <?= $user['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                                                    <?= ucfirst($user['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M j, Y H:i', strtotime($user['created_at'])) ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <?php if ($user['role_id'] != 1): // Can't delete system admin ?>
                                                        <button class="btn-action btn-delete"
                                                            onclick="deleteUser(<?= $user['id'] ?>)">Delete
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <p>No users found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dislayed when user clicks on the edit button -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit User Account</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <!-- <input type="hidden" id="edit_user_id" name="user_id"> -->

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" id="edit_first_name" name="first_name" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" id="edit_last_name" name="last_name" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_email" class="form-label">Email Address</label>
                            <input type="email" id="edit_email" name="email" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_role_id" class="form-label">Role</label>
                            <select id="edit_role_id" name="role_id" class="form-select" required>
                                <option value="2">HR Admin</option>
                                <option value="3">Recruitment Manager</option>
                                <option value="4">Applicant</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_status" class="form-label">Status</label>
                            <select id="edit_status" name="is_active" class="form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update
                            User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Delete User Account</h3>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="delete-label-body">
                    <label class="delete-label">Are you sure you want to delete the user ?</label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" id="userDeleteConfirm" class="btn btn-primary">Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- <script>
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

        function editUser(userId) {
            const modal = document.getElementById('editUserModal');
            modal.style.display = 'flex';
            modal.classList.add('show');

            const modalContent = modal.querySelector('.modal-content');
            modalContent.setAttribute('tabindex', '-1');
            modalContent.focus();
            // console.log(userId);

            fetchUserData(userId);
            updateUserData(userId);

        }

        function fetchUserData(userId) {
            // Simulate loading state
            // const modalBody = document.querySelector('.modal-body');
            // modalBody.classList.add('loading');


            fetch('http://localhost/HireFlow_Local/public/systemadmin/updateuser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'user_id=' + encodeURIComponent(userId) + '&action=fetch'
            })
                .then(response => response.json())
                .then(data => {
                    // console.log(data)
                    if (data.success) {
                        document.getElementById('edit_first_name').value = data.user[0].full_name.trim().split(" ")[0];
                        document.getElementById('edit_last_name').value = data.user[0].full_name.trim().split(" ")[1];
                        document.getElementById('edit_email').value = data.user[0].email;
                        document.getElementById('edit_role_id').value = data.user[0].role_id;
                        document.getElementById('edit_status').value = (data.user[0].status.toLowerCase() === 'active') ? '1' : '0';

                        document.getElementById('editUserModal').style.display = 'flex';
                    } else {
                        alert('User not found.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        function updateUserData(userId) {
            document.getElementById('editUserForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const params = new URLSearchParams();
                for (const pair of formData.entries()) {
                    params.append(pair[0], pair[1]);
                }
                // console.log(e);
                params.append('user_id', userId);
                params.append('action', 'update');
                // console.log(params.toString());

                fetch('http://localhost/HireFlow_Local/public/systemadmin/updateuser', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params.toString()
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User updated successfully!');
                            closeEditModal();
                            location.reload(); // Refresh the page to show updated data
                        } else {
                            alert('Update failed: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating user.');
                    });

            });
        }

        function closeEditModal() {
            const modal = document.getElementById('editUserModal');
            modal.classList.add('closing');

            setTimeout(() => {
                modal.style.display = 'none';
                modal.classList.remove('show', 'closing');
            }, 200);
        }

        function deleteUser(userId) {
            const modal = document.getElementById('deleteUserModal');
            modal.style.display = 'flex';
            modal.classList.add('show');
            const modalContent = modal.querySelector('.modal-content');
            modalContent.setAttribute('tabindex', '-1');
            modalContent.focus();

            deleteUserData(userId)
        }

        function deleteUserData(userId) {
            document.getElementById('userDeleteConfirm').addEventListener('click', function (e) {
                // e.preventDefault();


                fetch('http://localhost/HireFlow_Local/public/systemadmin/updateuser', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'user_id=' + encodeURIComponent(userId) + '&action=delete'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('User deleted successfully.');
                            closeDeleteModal();
                            location.reload(); // Refresh the page to show updated data
                        } else {
                            alert('Failed to delete the user.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting user.');
                    });
            });
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteUserModal');
            modal.classList.add('closing');

            setTimeout(() => {
                modal.style.display = 'none';
                modal.classList.remove('show', 'closing');
            }, 200);
        }

    </script> -->

</body>

</html>