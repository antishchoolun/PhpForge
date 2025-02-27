<?php
/**
 * Email Verification Page
 * Handles email verification process and resending verification emails
 */

require_once __DIR__ . '/../../src/config/init.php';

$email = cleanInput($_GET['email'] ?? '');
$token = cleanInput($_GET['token'] ?? '');
$message = '';
$messageType = '';

// Handle verification token
if ($token) {
    try {
        $stmt = $db->prepare("
            SELECT id 
            FROM users 
            WHERE email_verification_token = ? 
            AND email = ? 
            AND email_verified = 0
        ");
        $stmt->execute([$token, $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Update user as verified
            $stmt = $db->prepare("
                UPDATE users 
                SET email_verified = 1, 
                    email_verification_token = NULL 
                WHERE id = ?
            ");
            $stmt->execute([$user['id']]);

            $message = "Your email has been verified successfully! You can now sign in.";
            $messageType = 'success';
        } else {
            $message = "Invalid or expired verification link.";
            $messageType = 'danger';
        }
    } catch (PDOException $e) {
        error_log("Verification Error: " . $e->getMessage());
        $message = "System error occurred. Please try again later.";
        $messageType = 'danger';
    }
}

// Handle resend verification email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resend'])) {
    try {
        $stmt = $db->prepare("
            SELECT id, email_verified 
            FROM users 
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user['email_verified']) {
                $message = "This email is already verified.";
                $messageType = 'info';
            } else {
                // Generate new verification token
                $newToken = generateToken();
                
                // Update verification token
                $stmt = $db->prepare("
                    UPDATE users 
                    SET email_verification_token = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$newToken, $user['id']]);

                // TODO: Send verification email with new token
                
                $message = "Verification email has been resent. Please check your inbox.";
                $messageType = 'success';
            }
        } else {
            $message = "Email address not found.";
            $messageType = 'danger';
        }
    } catch (PDOException $e) {
        error_log("Resend Verification Error: " . $e->getMessage());
        $message = "System error occurred. Please try again later.";
        $messageType = 'danger';
    }
}

// Set page title
$pageTitle = "Verify Email";

// Include header
require_once __DIR__ . '/../../src/components/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Verify Your Email</h1>
        <p class="auth-subtitle">Please verify your email address to continue</p>

        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= e($message) ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                We've sent a verification email to <strong><?= e($email) ?></strong>.<br>
                Please click the link in the email to verify your account.
            </div>
        <?php endif; ?>

        <?php if (!$token): ?>
            <form method="POST" class="auth-form">
                <p class="text-center">Didn't receive the email?</p>
                <input type="hidden" name="email" value="<?= e($email) ?>">
                <button type="submit" name="resend" class="btn btn-primary btn-block">
                    Resend Verification Email
                </button>
            </form>
        <?php endif; ?>

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