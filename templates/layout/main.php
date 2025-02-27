<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PhpForge - AI-Powered PHP Tools' ?></title>
    <meta name="description" content="<?= $description ?? 'Transform your PHP workflow with our suite of AI-powered tools designed to help you code faster, debug smarter, and build more secure applications.' ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <?php if (isset($styles)): foreach ($styles as $style): ?>
        <link rel="stylesheet" href="<?= $style ?>">
    <?php endforeach; endif; ?>

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $_ENV['APP_URL'] ?>">
    <meta property="og:title" content="<?= $title ?? 'PhpForge - AI-Powered PHP Tools' ?>">
    <meta property="og:description" content="<?= $description ?? 'Transform your PHP workflow with our suite of AI-powered tools.' ?>">
    <meta property="og:image" content="<?= $_ENV['APP_URL'] ?>/assets/images/og-image.png">
    
    <!-- Security Headers -->
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains">
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="/assets/js/main.js"></script>
    <?php if (isset($scripts)): foreach ($scripts as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach; endif; ?>

    <!-- User Session Data -->
    <?php if (isset($_SESSION['user'])): ?>
    <script>
        window.User = <?= json_encode([
            'id' => $_SESSION['user']['id'],
            'name' => $_SESSION['user']['name'],
            'email' => $_SESSION['user']['email']
        ]) ?>;
    </script>
    <?php endif; ?>

    <!-- Error Handling -->
    <?php if (isset($error)): ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            showError('<?= addslashes($error) ?>');
        });
    </script>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if (isset($success)): ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            showSuccess('<?= addslashes($success) ?>');
        });
    </script>
    <?php endif; ?>
</body>
</html>