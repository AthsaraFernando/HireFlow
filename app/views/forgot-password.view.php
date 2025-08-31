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
    <title>Forgot Password - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
</head>

<body>
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-container">
                <div class="text-center mb-4">
                    <h1 class="brand-title">Hire<span class="dark">Flow</span></h1>
                    <p class="brand-subtitle">Reset Your Password</p>
                </div>

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

                <div class="form-container">
                    <form method="POST" class="auth-form">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                value="<?= old_value('email') ?>"
                                placeholder="Enter your email address"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                    </form>
                </div>

                <div class="auth-links">
                    <p class="text-center">
                        Remember your password? <a href="<?= ROOT ?>/signin" class="link-primary">Sign In</a>
                    </p>
                    <p class="text-center">
                        Don't have an account? <a href="<?= ROOT ?>/signup" class="link-primary">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
</body>
</html>
