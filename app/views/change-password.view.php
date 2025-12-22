<?php
if (!function_exists('old_value')) {
    function old_value($key)
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - HireFlow</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">


    <style>
        .password-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .password-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .requirement i {
            margin-right: 10px;
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="password-container">
        <div class="password-form">
            <h2 class="text-center mb-4">Change Password</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error mb-3">
                    <?= implode('<br>', $errors) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success mb-3">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="change-password-form">
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-input"
                        placeholder="Enter current password" required>
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-input"
                        placeholder="Enter new password" required minlength="8">
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input"
                        placeholder="Confirm new password" required minlength="8">
                </div>

                <div class="password-requirements mb-3">
                    <h6 class="mb-2">Password Requirements:</h6>
                    <div class="requirement">
                        <span>✓</span>
                        <span>At least 8 characters long</span>
                    </div>
                    <div class="requirement">
                        <span>✓</span>
                        <span>Contains at least one uppercase letter</span>
                    </div>
                    <div class="requirement">
                        <span>✓</span>
                        <span>Contains at least one lowercase letter</span>
                    </div>
                    <div class="requirement">
                        <span>✓</span>
                        <span>Contains at least one number</span>
                    </div>
                    <div class="requirement">
                        <span>✓</span>
                        <span>Contains at least one special character</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Change Password</button>
            </form>

            <div class="text-center mt-4">
                <a href="<?= ROOT ?>/profile" class="link-primary">← Back to Profile</a>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
    <script>
        // Password strength validation
        document.getElementById('new_password').addEventListener('input', function () {
            const password = this.value;
            const requirements = document.querySelectorAll('.requirement span:first-child');

            // Check each requirement
            const checks = [
                password.length >= 8,
                /[A-Z]/.test(password),
                /[a-z]/.test(password),
                /\d/.test(password),
                /[!@#$%^&*(),.?":{}|<>]/.test(password)
            ];

            requirements.forEach((req, index) => {
                req.style.color = checks[index] ? '#28a745' : '#dc3545';
                req.textContent = checks[index] ? '✓' : '✗';
            });
        });

        // Confirm password validation
        document.getElementById('confirm_password').addEventListener('input', function () {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;

            if (confirmPassword && newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>

</html>