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
    <title>Reset Password - HireFlow</title>
    < <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
        <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
        <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
        <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
        <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">
        <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">
        <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-container">
                <div class="text-center mb-4">
                    <h1 class="brand-title">Hire<span class="dark">Flow</span></h1>
                    <p class="brand-subtitle">Create New Password</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error mb-3">
                        <?= implode('<br>', $errors) ?>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST" class="auth-form">
                        <input type="hidden" name="token" value="<?= $token ?? '' ?>">

                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-input"
                                placeholder="Enter new password" required minlength="6">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-input"
                                placeholder="Confirm new password" required minlength="6">
                        </div>

                        <div class="password-requirements mb-3">
                            <small class="text-muted">
                                Password must be at least 6 characters long and contain a mix of letters and numbers.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </form>
                </div>

                <div class="auth-links">
                    <p class="text-center">
                        <a href="<?= ROOT ?>/signin" class="link-primary">Back to Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
</body>

</html>