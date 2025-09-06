<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - HireFlow</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/alert.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <img src="<?= ROOT ?>/assets/images/logo.png" alt="HireFlow" class="logo">
                <h1>Set New Password</h1>
                <p class="text-muted">Enter your new password below.</p>
            </div>

            <div class="auth-form">
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger">
                        <?= esc($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <?= csrf_token_input() ?>
                    <input type="hidden" name="token" value="<?= esc($token) ?>">
                    
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>"
                            placeholder="Enter new password"
                            required
                        >
                        <?php if (!empty($errors['password'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($errors['password']) ?>
                            </div>
                        <?php endif; ?>
                        <small class="form-text text-muted">
                            Password must be at least 8 characters with uppercase, lowercase, number, and special character.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control <?= !empty($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                            placeholder="Confirm new password"
                            required
                        >
                        <?php if (!empty($errors['confirm_password'])): ?>
                            <div class="invalid-feedback">
                                <?= esc($errors['confirm_password']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Reset Password
                    </button>
                </form>

                <div class="auth-footer">
                    <p><a href="<?= ROOT ?>/signin">Back to Sign In</a></p>
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
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

        .form-text {
            font-size: 12px;
            margin-top: 5px;
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
    </style>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const isStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password);
            
            if (password.length > 0) {
                if (isStrong) {
                    this.style.borderColor = '#28a745';
                } else {
                    this.style.borderColor = '#dc3545';
                }
            } else {
                this.style.borderColor = '';
            }
        });

        confirmInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirm = this.value;
            
            if (confirm.length > 0) {
                if (password === confirm) {
                    this.style.borderColor = '#28a745';
                } else {
                    this.style.borderColor = '#dc3545';
                }
            } else {
                this.style.borderColor = '';
            }
        });
    </script>
</body>
</html>
