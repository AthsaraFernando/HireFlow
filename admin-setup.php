<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HireFlow - Initial Admin Setup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .setup-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #333;
            font-size: 2.5em;
            font-weight: 300;
            margin-bottom: 10px;
        }
        
        .logo p {
            color: #666;
            font-size: 1.1em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="logo">
            <h1>HireFlow</h1>
            <p>Initial System Administrator Setup</p>
        </div>
        
        <div class="warning">
            <strong>⚠️ One-Time Setup</strong><br>
            This page creates the initial System Administrator account. Once created, this page will be disabled and you can create other admin accounts through the User Management system.
        </div>
        
        <?php
        require_once 'app/core/config.php';
        
        $message = '';
        $messageType = '';
        
        // Check if admin already exists
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE role_id = 1");
            $stmt->execute();
            $adminExists = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            
            if ($adminExists) {
                echo '<div class="error">';
                echo '<strong>❌ Setup Already Complete</strong><br>';
                echo 'A System Administrator account already exists. Please use the normal login page: ';
                echo '<a href="public?url=signin">Login Here</a>';
                echo '</div>';
                echo '<script>setTimeout(() => window.location.href = "public?url=signin", 3000);</script>';
                exit;
            }
            
        } catch (PDOException $e) {
            $message = "Database connection error: " . $e->getMessage();
            $messageType = 'error';
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullName = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            
            // Validation
            if (empty($fullName) || empty($email) || empty($password)) {
                $message = "Please fill in all required fields.";
                $messageType = 'error';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Please enter a valid email address.";
                $messageType = 'error';
            } elseif (strlen($password) < 6) {
                $message = "Password must be at least 6 characters long.";
                $messageType = 'error';
            } elseif ($password !== $confirmPassword) {
                $message = "Passwords do not match.";
                $messageType = 'error';
            } else {
                try {
                    // Hash the password properly for security
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Create the admin account with hashed password
                    $stmt = $pdo->prepare("INSERT INTO users (email, password, full_name, role_id, phone, address, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
                    $stmt->execute([$email, $hashedPassword, $fullName, 1, $phone, $address]);
                    
                    $message = "✅ System Administrator account created successfully!<br>You can now login with your credentials.<br>Redirecting to login page...";
                    $messageType = 'success';
                    
                    echo '<script>setTimeout(() => window.location.href = "public?url=signin", 3000);</script>';
                    
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $message = "An account with this email already exists.";
                    } else {
                        $message = "Error creating account: " . $e->getMessage();
                    }
                    $messageType = 'error';
                }
            }
        }
        
        if ($message) {
            echo "<div class=\"$messageType\">$message</div>";
        }
        ?>
        
        <?php if (!$adminExists && $messageType !== 'success'): ?>
        <form method="POST">
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
            </div>
            
            <button type="submit" class="btn-primary">Create System Administrator</button>
        </form>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 20px; color: #666;">
            <small>After setup, you can create other admin accounts through User Management</small>
        </div>
    </div>
</body>
</html>
