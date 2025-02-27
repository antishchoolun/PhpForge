<header class="site-header">
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <a href="/" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>PhpForge</span>.com
            </a>

            <!-- Main Navigation -->
            <nav class="main-nav">
                <ul>
                    <li><a href="/tools" <?= $currentPage === 'tools' ? 'class="active"' : '' ?>>Tools</a></li>
                    <li><a href="/pricing" <?= $currentPage === 'pricing' ? 'class="active"' : '' ?>>Pricing</a></li>
                    <li><a href="/docs" <?= $currentPage === 'docs' ? 'class="active"' : '' ?>>Documentation</a></li>
                    <li><a href="/blog" <?= $currentPage === 'blog' ? 'class="active"' : '' ?>>Blog</a></li>
                </ul>
            </nav>

            <!-- Authentication Buttons -->
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- User Dropdown -->
                    <div class="user-dropdown">
                        <button class="dropdown-trigger">
                            <span class="user-name"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            <a href="/dashboard">Dashboard</a>
                            <a href="/profile">Profile</a>
                            <a href="/settings">Settings</a>
                            <div class="dropdown-divider"></div>
                            <form action="/auth/logout" method="POST" class="logout-form">
                                <button type="submit" class="logout-button">Sign Out</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Login/Register Buttons -->
                    <button class="btn btn-outline" onclick="openModal('login')">Sign In</button>
                    <button class="btn btn-primary" onclick="openModal('register')">Get Started</button>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-button" aria-label="Toggle mobile menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <nav>
            <ul>
                <li><a href="/tools">Tools</a></li>
                <li><a href="/pricing">Pricing</a></li>
                <li><a href="/docs">Documentation</a></li>
                <li><a href="/blog">Blog</a></li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li><a href="#" onclick="openModal('login')">Sign In</a></li>
                    <li><a href="#" onclick="openModal('register')" class="cta">Get Started</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<!-- Authentication Modals -->
<?php if (!isset($_SESSION['user'])): ?>
    <!-- Login Modal -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Welcome Back</h2>
                <button class="close-modal" onclick="closeModal('login')">&times;</button>
            </div>
            <form action="/auth/login" method="POST" class="auth-form" id="login-form">
                <div class="input-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <div class="form-footer">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="/password/reset" class="forgot-password">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-full">Sign In</button>
            </form>
            <div class="auth-separator">
                <span>or</span>
            </div>
            <button class="btn btn-outline w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.545,12.151L12.545,12.151c0,1.054,0.855,1.909,1.909,1.909h3.536c-0.359,1.932-1.358,3.634-2.728,4.842 C13.967,20.108,12.077,20.8,10,20.8c-3.727,0-6.9-2.382-8.079-5.709c-0.276-0.772-0.421-1.578-0.421-2.391s0.145-1.619,0.421-2.391 c1.179-3.327,4.352-5.709,8.079-5.709c2.076,0,3.967,0.692,5.262,1.898L18,4.551c-1.821-1.567-4.223-2.551-6.9-2.551 C5.033,2,0.8,6.233,0.8,12s4.233,10,9.2,10c2.677,0,5.079-0.984,6.9-2.551l2.738,2.738C17.821,23.567,15.421,24.8,12.8,24.8 C5.939,24.8,0.2,19.061,0.2,12S5.939-0.8,12.8-0.8c2.621,0,5.021,1.233,6.838,3.162l2.738,2.738 C20.821,3.567,18.421,2.8,15.8,2.8C8.939,2.8,3.2,8.539,3.2,12s5.739,9.2,12.6,9.2c2.621,0,5.021-0.767,6.838-2.162l2.738,2.738 C23.821,19.567,21.421,20.8,18.8,20.8C11.939,20.8,6.2,15.061,6.2,8S11.939-4.8,18.8-4.8c2.621,0,5.021,1.233,6.838,3.162 l2.738,2.738C26.821-1.433,24.421-2.2,21.8-2.2C14.939-2.2,9.2,3.539,9.2,7s5.739,5.2,12.6,5.2c2.621,0,5.021-0.767,6.838-2.162 l2.738,2.738C29.821,11.567,27.421,12.8,24.8,12.8C17.939,12.8,12.545,7.061,12.545,12.151z"></path>
                </svg>
                Continue with Google
            </button>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Account</h2>
                <button class="close-modal" onclick="closeModal('register')">&times;</button>
            </div>
            <form action="/auth/register" method="POST" class="auth-form" id="register-form">
                <div class="input-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="name" required>
                </div>
                <div class="input-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="register-password-confirm">Confirm Password</label>
                    <input type="password" id="register-password-confirm" name="password_confirmation" required>
                </div>
                <div class="form-footer">
                    <label class="terms">
                        <input type="checkbox" name="terms" required>
                        I agree to the <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-full">Create Account</button>
            </form>
            <div class="auth-separator">
                <span>or</span>
            </div>
            <button class="btn btn-outline w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.545,12.151L12.545,12.151c0,1.054,0.855,1.909,1.909,1.909h3.536c-0.359,1.932-1.358,3.634-2.728,4.842 C13.967,20.108,12.077,20.8,10,20.8c-3.727,0-6.9-2.382-8.079-5.709c-0.276-0.772-0.421-1.578-0.421-2.391s0.145-1.619,0.421-2.391 c1.179-3.327,4.352-5.709,8.079-5.709c2.076,0,3.967,0.692,5.262,1.898L18,4.551c-1.821-1.567-4.223-2.551-6.9-2.551 C5.033,2,0.8,6.233,0.8,12s4.233,10,9.2,10c2.677,0,5.079-0.984,6.9-2.551l2.738,2.738C17.821,23.567,15.421,24.8,12.8,24.8 C5.939,24.8,0.2,19.061,0.2,12S5.939-0.8,12.8-0.8c2.621,0,5.021,1.233,6.838,3.162l2.738,2.738 C20.821,3.567,18.421,2.8,15.8,2.8C8.939,2.8,3.2,8.539,3.2,12s5.739,9.2,12.6,9.2c2.621,0,5.021-0.767,6.838-2.162l2.738,2.738 C23.821,19.567,21.421,20.8,18.8,20.8C11.939,20.8,6.2,15.061,6.2,8S11.939-4.8,18.8-4.8c2.621,0,5.021,1.233,6.838,3.162 l2.738,2.738C26.821-1.433,24.421-2.2,21.8-2.2C14.939-2.2,9.2,3.539,9.2,7s5.739,5.2,12.6,5.2c2.621,0,5.021-0.767,6.838-2.162 l2.738,2.738C29.821,11.567,27.421,12.8,24.8,12.8C17.939,12.8,12.545,7.061,12.545,12.151z"></path>
                </svg>
                Continue with Google
            </button>
        </div>
    </div>
<?php endif; ?>