<?php
/**
 * Sign Up Page
 * Handles new user registration
 */

require_once __DIR__ . '/../../src/config/init.php';

// Check if already logged in
if (isLoggedIn()) {
    redirect('/PhpForge/public/dashboard.php');
}

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = cleanInput($_POST['first_name'] ?? '');
    $lastName = cleanInput($_POST['last_name'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate input
    if (empty($firstName)) {
        $errors['first_name'] = 'First name is required';
    }
    if (empty($lastName)) {
        $errors['last_name'] = 'Last name is required';
    }
    if (!isValidEmail($email)) {
        $errors['email'] = 'Please enter a valid email address';
    }

    // Validate password
    $passwordValidation = validatePassword($password);
    if (!$passwordValidation['valid']) {
        $errors['password'] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long and contain uppercase, lowercase, number, and special character';
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Check if email already exists
    if (empty($errors['email'])) {
        try {
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors['email'] = 'Email already registered';
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            $errors['system'] = 'System error occurred. Please try again later.';
        }
    }

    // If no errors, create account
    if (empty($errors)) {
        try {
            // Generate verification token
            $verificationToken = generateToken();
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $db->prepare("
                INSERT INTO users (first_name, last_name, email, password, email_verification_token)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $db->beginTransaction();
            
            $stmt->execute([
                $firstName,
                $lastName,
                $email,
                $hashedPassword,
                $verificationToken
            ]);
            
            $userId = $db->lastInsertId();
            
            // Send verification email
            // TODO: Implement email sending functionality
            
            $db->commit();
            
            // Set success message and redirect
            $_SESSION['signup_success'] = true;
            redirect('/PhpForge/public/auth/verify-email.php?email=' . urlencode($email));
            
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Registration Error: " . $e->getMessage());
            $errors['system'] = 'Registration failed. Please try again later.';
        }
    }
}

// Set page title
$pageTitle = "Sign Up";

// Include header
require_once __DIR__ . '/../../src/components/layout/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Create Account</h1>
        <p class="auth-subtitle">Join PhpForge and supercharge your PHP development</p>

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
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="input-control" 
                           value="<?= isset($firstName) ? e($firstName) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="input-control" 
                           value="<?= isset($lastName) ? e($lastName) : '' ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-control" 
                       value="<?= isset($email) ? e($email) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input-control" required>
                <div class="password-strength">
                    <div class="strength-meter">
                        <div class="strength-meter-fill"></div>
                    </div>
                    <div class="strength-text"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="input-control" required>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="terms" required>
                    I agree to the <a href="/PhpForge/public/terms.php">Terms of Service</a> and 
                    <a href="/PhpForge/public/privacy.php">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/PhpForge/public/auth/signin.php">Sign In</a></p>
        </div>
    </div>
</div>

<script>
document.getElementById('password').addEventListener('input', function(e) {
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