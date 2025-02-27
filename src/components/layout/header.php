<?php
/**
 * Header component for PhpForge
 * Contains the navigation and authentication buttons
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - PhpForge.com' : 'PhpForge.com - AI-Powered PHP Tools' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/PhpForge/src/css/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>PhpForge</span>.com
            </div>
            <nav>
                <ul>
                    <li><a href="/PhpForge/public/tools.php">Tools</a></li>
                    <li><a href="/PhpForge/public/pricing.php">Pricing</a></li>
                    <li><a href="/PhpForge/public/docs.php">Documentation</a></li>
                    <li><a href="/PhpForge/public/blog.php">Blog</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="/PhpForge/public/auth/signin.php" class="btn btn-outline">Sign In</a>
                <a href="/PhpForge/public/auth/signup.php" class="btn btn-primary">Get Started</a>
            </div>
        </header>