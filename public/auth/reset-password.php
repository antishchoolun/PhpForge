<?php
/**
 * Reset Password Page
 * Handles password reset using the reset token
 */

require_once __DIR__ . '/../../src/config/init.php';

$token = cleanInput($_GET['token'] ?? '');
$errors = [];
$success = false;

// Verify token first
try {
    $stmt = $db->prepare("
        SELECT id, email 
        FROM users 
        WHERE password_reset_token = ? 
        AND password_reset_expires > CURRENT_TIMESTAMP 
        AND is_active = 1
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $errors['token'] = 'Invalid or expired reset link. Please request a new one.';
    }
} catch (PDOException $e) {
    error_log("Token Verification Error: " . $e->getMessage());
    $errors['system'] = 'System error occurred. Please try again later.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate password
    $passwordValidation = validatePassword($password);
    if (!$passwordValidation['valid']) {
        $errors['password'] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long and contain uppercase, lowercase, number, and special character';
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // If no errors, update password
    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("
                UPDATE users 
                SET password = ?,
                    password_reset_token = NULL,
                    password_reset_expires = NULL
                WHERE id = ?
            ");
            $stmt->execute([$hashedPassword, $user['id']]);

            // Log out any existing sessions for this user
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $user['id']) {
                session_destroy();
            }

            $success = true;

        } catch (PDOException $e) {
            error_log("Password Reset Error: " . $e->getMessage());
            $errors['system'] = 'Failed to update password. Please try again later.';
        }
    }
}

// Set page title
$pageTitle = "Reset Password";

// Include header
require_once __DIR__ . '/../../src/components/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Reset Password</h1>
        <p class="auth-subtitle">Enter your new password</p>

        <?php if ($success): ?>
            <div class="alert alert-success">
                Your password has been reset successfully!<br>
                <a href="/PhpForge/public/auth/signin.php">Click here to sign in</a> with your new password.
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (empty($errors['token'])): ?>
                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" class="input-control" required>
                        <div class="password-strength">
                            <div class="strength-meter">
                                <div class="strength-meter-fill"></div>
                            </div>
                            <div class="strength-text"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="input-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <div class="auth-footer">
            <p>
                <a href="/PhpForge/public/auth/signin.php">Return to Sign In</a>
            </p>
        </div>
    </div>
</div>

<script>
document.getElementById('password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    const strengthMeter = document.querySelector('.strength-meter-fill');
    const strengthText = document.querySelector('.strength-text');
    
    // Check password strength
    const hasLower = /[a-z]/.test(password);
    const hasUpper = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[^A-Za-z0-9]/.test(password);
    const isLongEnough = password.length >= <?= PASSWORD_MIN_LENGTH ?>;
    
    const strength = [hasLower, hasUpper, hasNumber, hasSpecial, isLongEnough]
        .filter(Boolean).length;
    
    // Update UI
    let strengthClass = '';
    let strengthMessage = '';
    
    switch(strength) {
        case 0:
        case 1:
            strengthClass = 'strength-weak';
            strengthMessage = 'Weak';
            break;
        case 2:
        case 3:
            strengthClass = 'strength-fair';
            strengthMessage = 'Fair';
            break;
        case 4:
            strengthClass = 'strength-good';
            strengthMessage = 'Good';
            break;
        case 5:
            strengthClass = 'strength-strong';
            strengthMessage = 'Strong';
            break;
    }
    
    strengthMeter.className = 'strength-meter-fill ' + strengthClass;
    strengthText.textContent = strengthMessage;
});
</script>

<?php
// Include footer
require_once __DIR__ . '/../../src/components/layout/footer.php';
?>