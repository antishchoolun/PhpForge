<?php
/**
 * Forgot Password Page
 * Handles password reset requests
 */

require_once __DIR__ . '/../../src/config/init.php';

// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');

    if (!isValidEmail($email)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'danger';
    } else {
        try {
            $stmt = $db->prepare("SELECT id, first_name FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Generate reset token
                $resetToken = generateToken();
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Save reset token
                $stmt = $db->prepare("
                    UPDATE users 
                    SET password_reset_token = ?,
                        password_reset_expires = ?
                    WHERE id = ?
                ");
                $stmt->execute([$resetToken, $expires, $user['id']]);

                // TODO: Send password reset email
                // For now, we'll just show the link (in development only)
                if (APP_ENV === 'development') {
                    $resetLink = "/PhpForge/public/auth/reset-password.php?token=" . $resetToken;
                    $message = "Development mode: Reset link created - <a href='{$resetLink}'>Click here to reset</a>";
                    $messageType = 'info';
                } else {
                    $message = "If an account exists with this email, you will receive password reset instructions.";
                    $messageType = 'success';
                }
            } else {
                // Don't reveal whether the email exists or not
                $message = "If an account exists with this email, you will receive password reset instructions.";
                $messageType = 'success';
            }
        } catch (PDOException $e) {
            error_log("Password Reset Error: " . $e->getMessage());
            $message = "System error occurred. Please try again later.";
            $messageType = 'danger';
        }
    }
}

// Set page title
$pageTitle = "Forgot Password";

// Include header
require_once __DIR__ . '/../../src/components/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Reset Password</h1>
        <p class="auth-subtitle">Enter your email to receive reset instructions</p>

        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $messageType === 'info' ? $message : e($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-control" 
                       value="<?= isset($email) ? e($email) : '' ?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </form>

        <div class="auth-footer">
            <p>
                <a href="/PhpForge/public/auth/signin.php">Return to Sign In</a>
            </p>
        </div>
    </div>
</div>

<?php
// Include footer
require_once __DIR__ . '/../../src/components/layout/footer.php';
?>