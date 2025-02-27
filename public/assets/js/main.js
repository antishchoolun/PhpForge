// Main Application JavaScript

// Utility functions
const $ = selector => document.querySelector(selector);
const $$ = selector => document.querySelectorAll(selector);

class App {
    constructor() {
        this.initializeEventListeners();
        this.setupMobileMenu();
        this.setupModals();
        this.setupForms();
        this.setupCookieConsent();
        this.setupUserDropdown();
    }

    // Initialize event listeners
    initializeEventListeners() {
        document.addEventListener('DOMContentLoaded', () => {
            this.handleDynamicContent();
        });

        window.addEventListener('scroll', () => {
            this.handleScroll();
        });
    }

    // Mobile menu functionality
    setupMobileMenu() {
        const menuButton = $('.mobile-menu-button');
        const mobileNav = $('.mobile-nav');

        if (menuButton && mobileNav) {
            menuButton.addEventListener('click', () => {
                mobileNav.classList.toggle('active');
                menuButton.setAttribute('aria-expanded', 
                    mobileNav.classList.contains('active'));
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileNav.contains(e.target) && !menuButton.contains(e.target)) {
                    mobileNav.classList.remove('active');
                    menuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    // Modal functionality
    setupModals() {
        // Close modal when clicking outside
        $$('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal.id.replace('-modal', ''));
                }
            });
        });

        // Close modal with escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const activeModal = $('.modal.active');
                if (activeModal) {
                    closeModal(activeModal.id.replace('-modal', ''));
                }
            }
        });
    }

    // Form handling
    setupForms() {
        // Login form
        const loginForm = $('#login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleLogin(new FormData(loginForm));
            });
        }

        // Register form
        const registerForm = $('#register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleRegistration(new FormData(registerForm));
            });
        }

        // Newsletter form
        const newsletterForm = $('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleNewsletterSignup(new FormData(newsletterForm));
            });
        }
    }

    // Handle login
    async handleLogin(formData) {
        try {
            const response = await this.apiRequest('/auth/login', {
                method: 'POST',
                body: this.formDataToJson(formData)
            });

            if (response.success) {
                window.location.reload();
            } else {
                this.showError(response.message);
            }
        } catch (error) {
            this.showError('Login failed. Please try again.');
        }
    }

    // Handle registration
    async handleRegistration(formData) {
        try {
            const response = await this.apiRequest('/auth/register', {
                method: 'POST',
                body: this.formDataToJson(formData)
            });

            if (response.success) {
                this.showSuccess('Registration successful! Please check your email to verify your account.');
                closeModal('register');
                openModal('login');
            } else {
                this.showError(response.message);
            }
        } catch (error) {
            this.showError('Registration failed. Please try again.');
        }
    }

    // Handle newsletter signup
    async handleNewsletterSignup(formData) {
        try {
            const response = await this.apiRequest('/newsletter/subscribe', {
                method: 'POST',
                body: this.formDataToJson(formData)
            });

            if (response.success) {
                this.showSuccess('Thank you for subscribing!');
            } else {
                this.showError(response.message);
            }
        } catch (error) {
            this.showError('Subscription failed. Please try again.');
        }
    }

    // API request helper
    async apiRequest(endpoint, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        const response = await fetch(endpoint, { ...defaultOptions, ...options });
        return await response.json();
    }

    // Form data to JSON helper
    formDataToJson(formData) {
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        return JSON.stringify(data);
    }

    // Cookie consent
    setupCookieConsent() {
        const cookieBanner = $('#cookie-banner');
        if (cookieBanner && !localStorage.getItem('cookieConsent')) {
            cookieBanner.style.display = 'block';
        }
    }

    // User dropdown
    setupUserDropdown() {
        const dropdown = $('.user-dropdown');
        if (dropdown) {
            const trigger = dropdown.querySelector('.dropdown-trigger');
            const menu = dropdown.querySelector('.dropdown-menu');

            trigger.addEventListener('click', () => {
                menu.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });
        }
    }

    // Handle dynamic content loading
    handleDynamicContent() {
        // Lazy load images
        $$('img[loading="lazy"]').forEach(img => {
            img.setAttribute('src', img.getAttribute('data-src'));
        });

        // Initialize syntax highlighting
        if (window.hljs) {
            $$('pre code').forEach(block => {
                hljs.highlightBlock(block);
            });
        }
    }

    // Handle scroll events
    handleScroll() {
        // Add header shadow on scroll
        const header = $('.site-header');
        if (header) {
            header.classList.toggle('scrolled', window.scrollY > 0);
        }

        // Show/hide scroll to top button
        const scrollTopButton = $('.scroll-top');
        if (scrollTopButton) {
            scrollTopButton.classList.toggle('visible', window.scrollY > 300);
        }
    }

    // Show error message
    showError(message) {
        const toast = this.createToast('error', message);
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    // Show success message
    showSuccess(message) {
        const toast = this.createToast('success', message);
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }

    // Create toast notification
    createToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <span class="toast-icon">${type === 'success' ? '✓' : '⚠'}</span>
                <span class="toast-message">${message}</span>
            </div>
        `;
        return toast;
    }
}

// Initialize application
const app = new App();

// Modal helpers
function openModal(modalName) {
    $(`#${modalName}-modal`).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalName) {
    $(`#${modalName}-modal`).classList.remove('active');
    document.body.style.overflow = '';
}

// Cookie consent helpers
function acceptCookies() {
    localStorage.setItem('cookieConsent', 'true');
    $('#cookie-banner').style.display = 'none';
}

function manageCookies() {
    closeModal('cookie-banner');
    openModal('cookie-settings');
}

// Make helpers available globally
window.openModal = openModal;
window.closeModal = closeModal;
window.acceptCookies = acceptCookies;
window.manageCookies = manageCookies;