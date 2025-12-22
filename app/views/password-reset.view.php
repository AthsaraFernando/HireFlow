<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - HireFlow</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/systemadmin/system-admin.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <img src="<?= ROOT ?>/assets/images/logo.png" alt="HireFlow" class="logo">
                <h1>Reset Password</h1>
                <p class="text-muted">Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>

            <div class="auth-form">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success msg-container">
                        <?= esc($success) ?>

                        <?php if (!empty($debug_token)): ?>
                             <hr>
                         <!--   Reset Token: <code><?= esc($debug_token) ?></code><br> -->
                            Reset Link: <a href="<?= esc($debug_link) ?>" target="_blank">Click Here to Reset</a>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <?= esc($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <?= csrf_token_input() ?>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= esc($_POST['email'] ?? '') ?>" placeholder="Enter your email address" required>
                        <?php if (!empty($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($errors['email']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Send Reset Instructions
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Remember your password? <a href="<?= ROOT ?>/signin">Sign In</a></p>
                    <p>Don't have an account? <a href="<?= ROOT ?>/signup">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .auth-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
        }

        .auth-header {
            padding: 40px 30px 20px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }

        .auth-header h1 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 24px;
        }

        .text-muted {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .auth-form {
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .btn-block {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-top: 10px;
        }

        .auth-footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .auth-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        code {
            background: #f8f9fa;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 12px;
        }

        .msg-container {
            display: flex;
            flex-direction: column;
        }
    </style>
</body>

</html>