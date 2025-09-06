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
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/home.style.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="container">
        <div class="signin-wrapper">
            <div class="signin-container">
                <div class="text-center mb-4">
                    <h1 class="brand-title">Hire<span class="dark">Flow</span></h1>
                    <p class="brand-subtitle">Recruitment Management System</p>
                </div>

                <div class="form-container">
                    <h2 class="form-title text-center mb-3">Sign In</h2>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success mb-3">
                            <?= esc($success) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-error mb-3">
                            <?php foreach ($errors as $error): ?>
                                <?= esc($error) ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= ROOT ?>/signin" class="signin-form">
                        <?= csrf_token_input() ?>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-input w-full"
                                placeholder="Enter your email address" value="<?= old_value('email') ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-input w-full"
                                placeholder="Enter your password" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="role_id" class="form-label">User Type</label>
                            <select id="role_id" name="role_id" class="form-select w-full" required>
                                <option value="">Select your role</option>
                                <option value="1" <?= old_value('role_id') == '1' ? 'selected' : '' ?>>System Admin</option>
                                <option value="2" <?= old_value('role_id') == '2' ? 'selected' : '' ?>>HR Admin</option>
                                <option value="3" <?= old_value('role_id') == '3' ? 'selected' : '' ?>>Recruitment Manager</option>
                                <option value="4" <?= old_value('role_id') == '4' ? 'selected' : '' ?>>Applicant</option>
                            </select>
                            <small class="form-text">
                                <strong>Note:</strong> HR Admin & Recruitment Manager accounts are created by System Admin only.
                            </small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember_me" class="form-checkbox">
                                <span class="checkbox-text">Remember me</span>
                            </label>
                        </div>

                        <div class="form-group mb-4">
                            <button type="submit" class="btn btn-primary w-full">
                                Sign In
                            </button>
                        </div>

                        <div class="form-links text-center">
                            <p class="mb-2">
                                <a href="<?= ROOT ?>/password-reset" class="link link-secondary">
                                    Forgot your password?
                                </a>
                            </p>
                            <p class="text-muted">
                                Job seeker looking for opportunities?
                                <a href="<?= ROOT ?>/signup" class="link link-primary">
                                    Create Applicant Account
                                </a>
                            </p>
                            <p class="text-muted small mt-2">
                                <strong>Staff Access:</strong> HR Admin & Recruitment Manager accounts are created by System Admin.
                            </p>
                        </div>
                    </form>
                </div>

                <div class="signin-footer text-center mt-4">
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