<?php
// Helper function to retrieve old form values
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
    <title>Create Account</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/signup.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="container">
        <div class="signup-wrapper">
            <div class="signup-container">
                <div class="brand-section text-center mb-4">
                    <h1 class="brand-title">Hire<span class="dark">Flow</span></h1>
                    <p class="brand-subtitle">Create Your Job Seeker Account</p>
                </div>

                <div class="form-container">
                    <h2 class="form-title text-center mb-3">Join as an Applicant</h2>
                    <p class="text-center text-muted mb-4">
                        Register to browse and apply for job opportunities
                    </p>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-error mb-3">
                            <?= implode('<br>', $errors) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= ROOT ?>/signup" class="signup-form">

                    
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-input"
                                    placeholder="Enter your first name" value="<?= old_value('first_name') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-input"
                                    placeholder="Enter your last name" value="<?= old_value('last_name') ?>" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-input w-full"
                                placeholder="Enter your email address" value="<?= old_value('email') ?>" required>
                        </div>

                        <div class="form-section">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-input w-full"
                                    placeholder="Create a strong password" required>
                                <small class="form-help">Password must be at least 8 characters and include
                                    uppercase, lowercase, number, and special character</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="form-input w-full" placeholder="Confirm your password" required>
                            </div>
                        </div>

                        <!-- Hidden field to set role as applicant -->
                        <input type="hidden" name="role_id" value="4">

                        <div class="form-group mb-4">
                            <label class="checkbox-label">
                                <input type="checkbox" name="agree_terms" class="form-checkbox" required>
                                <span class="checkbox-text">
                                    I agree to the
                                    <a href="<?= ROOT ?>/terms" class="link link-primary" target="_blank">Terms of
                                        Service</a>
                                    and
                                    <a href="<?= ROOT ?>/privacy" class="link link-primary" target="_blank">Privacy
                                        Policy</a>
                                </span>
                            </label>
                        </div>

                        <div class="info-box mb-4">
                            <p class="text-muted small">
                                <strong>Note:</strong> This registration is for job seekers only. 
                                Staff accounts (HR Admin, Recruitment Manager) are created by System Administrator.
                            </p>
                        </div>

                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-primary w-full">
                                Create Applicant Account
                            </button>
                        </div>

                        <div class="form-links text-center">
                            <p class="text-muted">
                                Already have an account?
                                <a href="<?= ROOT ?>/signin" class="link link-primary">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="signup-footer text-center mt-4">
                    <p class="text-muted small">
                        © <?= date('Y') ?> HireFlow. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
    </script>
</body>

</html>