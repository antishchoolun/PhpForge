<?php
/**
 * Sign In Page
 * Handles user authentication
 */

require_once __DIR__ . '/../../src/config/init.php';

// Check if already logged in
if (isLoggedIn()) {
    redirect('/PhpForge/public/dashboard.php');
}

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Validate input
    if (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If no validation errors, attempt login
    if (empty($errors)) {
        try {
            $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                
                // Update last login
                $stmt = $db->prepare("UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$user['id']]);

                // Handle remember me
                if ($remember) {
                    $token = generateToken();
                    setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                    
                    // Store token in database
                    $stmt = $db->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $stmt->execute([$token, $user['id']]);
                }

                redirect('/PhpForge/public/dashboard.php');
            } else {
                $errors['login'] = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            $errors['system'] = 'System error occurred. Please try again later.';
        }
    }
}

// Set page title
$pageTitle = "Sign In";

// Include header
require_once __DIR__ . '/../../src/components/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Welcome Back</h1>
        <p class="auth-subtitle">Sign in to your PhpForge account</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-control" 
                       value="<?= isset($email) ? e($email) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input-control" required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" <?= isset($remember) && $remember ? 'checked' : '' ?>>
                    Remember me
                </label>
                <a href="/PhpForge/public/auth/forgot-password.php" class="forgot-password">
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/PhpForge/public/auth/signup.php">Sign Up</a></p>
        </div>
    </div>
</div>

<?php
// Include footer
require_once __DIR__ . '/../../src/components/layout/footer.php';
?>