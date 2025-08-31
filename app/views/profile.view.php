<?php
// Sample user data - in real implementation this would come from session/database
$user = [
    'id' => 1,
    'full_name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+94771234567',
    'address' => '123 Main Street, Colombo',
    'role' => 'System Admin',
    'created_at' => '2024-01-15'
];

if (!function_exists('old_value')) {
    function old_value($key, $default = '')
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - HireFlow</title>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/input.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/button.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/card.css">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/assets/css/components/alert.css">
    <link rel="icon" type="image/x-icon" href="<?= ROOT ?>/assets/images/logo.png">
    
    <style>
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            margin: 0 auto 15px;
        }
        
        .profile-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .readonly-field {
            background: #f8f9fa;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
            </div>
            <h1><?= htmlspecialchars($user['full_name']) ?></h1>
            <p><?= htmlspecialchars($user['role']) ?></p>
            <small>Member since <?= date('F Y', strtotime($user['created_at'])) ?></small>
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

        <div class="profile-form">
            <h2 class="mb-4">Profile Information</h2>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            class="form-input" 
                            value="<?= old_value('full_name', $user['full_name']) ?>"
                            required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input readonly-field" 
                            value="<?= htmlspecialchars($user['email']) ?>"
                            readonly>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-input" 
                            value="<?= old_value('phone', $user['phone']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input 
                            type="text" 
                            id="role" 
                            name="role" 
                            class="form-input readonly-field" 
                            value="<?= htmlspecialchars($user['role']) ?>"
                            readonly>
                        <small class="text-muted">Role is managed by system admin</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        class="form-input" 
                        rows="3"
                        placeholder="Enter your address"><?= old_value('address', $user['address']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input 
                        type="file" 
                        id="profile_picture" 
                        name="profile_picture" 
                        class="form-input"
                        accept="image/*">
                    <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max 2MB)</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <a href="<?= ROOT ?>/change-password" class="btn btn-outline-secondary ml-2">Change Password</a>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= ROOT ?>" class="link-primary">← Back to Dashboard</a>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/main.js"></script>
</body>
</html>
