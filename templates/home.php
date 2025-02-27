<?php
/**
 * Home page template
 * 
 * @var string $title Page title
 * @var string $description Page description
 * @var string $currentPage Current page identifier
 */
?>

<!-- Include header -->
<?php include 'layout/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1 class="animate__animated animate__fadeIn">
            PHP Development, <br>Supercharged by AI
        </h1>
        <p class="hero-description animate__animated animate__fadeIn animate__delay-1s">
            Transform your PHP workflow with our suite of AI-powered tools designed to help you 
            code faster, debug smarter, and build more secure applications.
        </p>
        <div class="hero-actions animate__animated animate__fadeIn animate__delay-2s">
            <button class="btn btn-primary" onclick="openModal('code-generator')">Try Code Generator</button>
            <a href="/tools" class="btn btn-outline">Explore All Tools</a>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <!-- Code Generator -->
            <div class="feature-card">
                <div class="feature-icon">💻</div>
                <h3>AI Code Generation</h3>
                <p>Transform natural language into clean, efficient PHP code instantly.</p>
                <button class="btn btn-primary" onclick="openModal('code-generator')">Generate Code</button>
            </div>

            <!-- Debugging -->
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Smart Debugging</h3>
                <p>Identify and fix issues with AI-powered error analysis.</p>
                <button class="btn btn-primary" onclick="openModal('debugging')">Debug Code</button>
            </div>

            <!-- Security -->
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Security Analysis</h3>
                <p>Find and fix security vulnerabilities automatically.</p>
                <button class="btn btn-primary" onclick="openModal('security')">Scan Code</button>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <h2>How It Works</h2>
        <div class="steps-grid">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Describe Your Need</h3>
                <p>Tell us what you want to achieve in plain language.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>AI Processing</h3>
                <p>Our AI analyzes your request and generates optimized solutions.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Get Results</h3>
                <p>Receive clean, efficient, and secure PHP code instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Supercharge Your PHP Development?</h2>
            <p>Join thousands of developers who are already using PhpForge to build better applications.</p>
            <div class="cta-buttons">
                <button class="btn btn-primary" onclick="openModal('register')">Get Started Free</button>
                <a href="/pricing" class="btn btn-outline">View Pricing</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <h2>What Developers Say</h2>
        <div class="testimonials-grid">
            <div class="testimonial">
                <div class="testimonial-content">
                    <p>"PhpForge has transformed how I write PHP code. The AI suggestions are incredibly accurate!"</p>
                </div>
                <div class="testimonial-author">
                    <img src="/assets/images/avatar1.jpg" alt="Developer" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <strong>John Doe</strong>
                        <span>Senior PHP Developer</span>
                    </div>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-content">
                    <p>"The debugging tool alone has saved me countless hours of troubleshooting."</p>
                </div>
                <div class="testimonial-author">
                    <img src="/assets/images/avatar2.jpg" alt="Developer" class="testimonial-avatar">
                    <div class="testimonial-info">
                        <strong>Jane Smith</strong>
                        <span>Full Stack Developer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="blog-preview">
    <div class="container">
        <h2>Latest from Our Blog</h2>
        <div class="blog-grid">
            <?php foreach (($posts ?? []) as $post): ?>
            <article class="blog-card">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p><?= htmlspecialchars($post['excerpt']) ?></p>
                <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline">Read More</a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Include footer -->
<?php include 'layout/footer.php'; ?>