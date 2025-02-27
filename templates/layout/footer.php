<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Company Info -->
            <div class="footer-section">
                <div class="footer-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                    <span>PhpForge</span>.com
                </div>
                <p class="footer-description">
                    Transform your PHP workflow with our suite of AI-powered tools designed to help you code faster, debug smarter, and build more secure applications.
                </p>
                <div class="social-links">
                    <a href="https://twitter.com/phpforge" target="_blank" rel="noopener" aria-label="Follow us on Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a>
                    <a href="https://github.com/phpforge" target="_blank" rel="noopener" aria-label="Visit us on GitHub">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                        </svg>
                    </a>
                    <a href="https://linkedin.com/company/phpforge" target="_blank" rel="noopener" aria-label="Connect with us on LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Product Links -->
            <div class="footer-section">
                <h3>Product</h3>
                <ul>
                    <li><a href="/tools">Tools</a></li>
                    <li><a href="/pricing">Pricing</a></li>
                    <li><a href="/docs">Documentation</a></li>
                    <li><a href="/changelog">Changelog</a></li>
                    <li><a href="/roadmap">Roadmap</a></li>
                </ul>
            </div>

            <!-- Company Links -->
            <div class="footer-section">
                <h3>Company</h3>
                <ul>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/careers">Careers</a></li>
                    <li><a href="/press">Press Kit</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>

            <!-- Legal Links -->
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="/terms">Terms of Service</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/security">Security</a></li>
                    <li><a href="/cookies">Cookie Policy</a></li>
                    <li><a href="/gdpr">GDPR Compliance</a></li>
                </ul>
            </div>

            <!-- Newsletter Signup -->
            <div class="footer-section newsletter">
                <h3>Stay Updated</h3>
                <p>Subscribe to our newsletter for the latest updates and tips.</p>
                <form action="/newsletter/subscribe" method="POST" class="newsletter-form">
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="footer-bottom">
            <div class="copyright">
                © <?= date('Y') ?> PhpForge.com • All rights reserved
            </div>
            <div class="footer-meta">
                <select class="language-select" onchange="window.location.href=this.value">
                    <option value="/en">English</option>
                    <option value="/fr">Français</option>
                    <option value="/es">Español</option>
                    <option value="/de">Deutsch</option>
                </select>
                <span class="version">v<?= $_ENV['APP_VERSION'] ?? '1.0.0' ?></span>
            </div>
        </div>
    </div>
</footer>

<!-- Cookie Consent Banner -->
<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-content">
        <p>
            We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.
            <a href="/cookies">Learn more</a>
        </p>
        <div class="cookie-buttons">
            <button class="btn btn-outline" onclick="manageCookies()">Manage</button>
            <button class="btn btn-primary" onclick="acceptCookies()">Accept All</button>
        </div>
    </div>
</div>