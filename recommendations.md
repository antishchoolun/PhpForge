# Framework and Third-Party Tool Recommendations

## Table of Contents
1. [Recommended Changes](#recommended-changes)
2. [Project Setup](#project-setup)
3. [Development Workflow](#development-workflow)
4. [Deployment](#deployment)
5. [Troubleshooting](#troubleshooting)

## Recommended Changes

### 1. Backend Framework
**Current:** Custom lightweight routing and core framework
**Recommended:** Slim Framework 4.x
- Benefits:
  - Production-ready routing system
  - PSR-7 HTTP message interfaces
  - Dependency injection container
  - Middleware support
  - Active community and documentation
  - Compatible with shared hosting
  - Lightweight and flexible

### 2. Database Access
**Current:** Custom PDO wrapper
**Recommended:** Doctrine DBAL
- Benefits:
  - Robust database abstraction layer
  - Query builder
  - Schema management
  - Connection pooling
  - Prepared statements
  - Multiple database support

### 3. Template Engine
**Current:** Plain PHP templates
**Recommended:** Twig Template Engine
- Benefits:
  - Secure by default (automatic escaping)
  - Template inheritance
  - Reusable components
  - Better separation of concerns
  - Cache compilation

### 4. Logging
**Current:** Custom file-based logging
**Recommended:** Monolog
- Benefits:
  - PSR-3 compliant
  - Multiple handlers and formatters
  - Log rotation
  - Various output formats
  - Error aggregation

### 5. Authentication
**Current:** Custom JWT implementation
**Recommended:** Firebase JWT + OAuth2 Server
- Benefits:
  - Well-tested JWT library
  - Robust token management
  - OAuth2 support for API access
  - Security best practices

### 6. API Documentation
**Current:** None specified
**Recommended:** OpenAPI (Swagger) with swagger-php
- Benefits:
  - API documentation generation
  - Interactive API testing
  - Client SDK generation
  - Industry standard

### 7. Form Validation
**Current:** Custom validation
**Recommended:** Respect/Validation
- Benefits:
  - Comprehensive validation rules
  - Chain validation
  - Custom validators
  - Multilingual support

### 8. Frontend Development
**Current:** Vanilla JavaScript
**Recommended:** Alpine.js + Tailwind CSS
- Benefits:
  - Minimal JavaScript framework
  - Progressive enhancement
  - Utility-first CSS
  - No build process required
  - Works on shared hosting
  - Small bundle size

### 9. Security Tools
**Current:** Custom security implementations
**Recommended:**
- PHP-Security-Scanner for static analysis
- HTMLPurifier for XSS prevention
- Password_compat for password hashing

### 10. Testing
**Current:** Basic PHPUnit
**Recommended:** Add:
- Pest PHP for elegant testing
- PHPStan for static analysis
- PHP_CodeSniffer for style checking

## Project Setup

### Prerequisites
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Apache/Nginx web server
- Required PHP extensions:
  - pdo_mysql
  - json
  - mbstring
  - openssl
  - sodium
  - xml
  - curl

### Step 1: Initial Setup
```bash
# Clone the repository
git clone https://github.com/yourusername/phpforge.git
cd phpforge

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php scripts/generate-key.php
```

### Step 2: Configuration
Edit `.env` file:
```env
# Application
APP_NAME=PhpForge
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_KEY=your-generated-key

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phpforge
DB_USERNAME=your_username
DB_PASSWORD=your_password

# API Keys
GROQ_API_KEY=your_groq_api_key

# Cache and Session
CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Step 3: Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE phpforge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php scripts/migrate.php

# Seed initial data
php scripts/seed.php
```

### Step 4: Directory Permissions
```bash
# Set proper permissions
chmod -R 755 public/
chmod -R 755 storage/
chmod -R 755 cache/
chmod -R 755 logs/

# Set ownership if using Apache
sudo chown -R www-data:www-data storage/ cache/ logs/
```

### Step 5: Web Server Configuration

#### Apache (.htaccess included in public/):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

#### Nginx (nginx.conf):
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## Development Workflow

### Starting the Development Server
```bash
# Start PHP development server
php -S localhost:8000 -t public/

# Or use the custom server script
php scripts/serve.php
```

### Watch for Changes
```bash
# Watch for PHP changes
php scripts/watch.php

# Watch for frontend changes (if using npm)
npm run watch
```

### Running Tests
```bash
# Run all tests
composer test

# Run specific test suites
composer test-unit     # Unit tests only
composer test-feature  # Feature tests only
composer test-integration  # Integration tests only

# Code style and analysis
composer check-style  # Check code style
composer fix-style    # Fix code style issues
composer analyze      # Run static analysis
```

### Development URLs
- Main application: http://localhost:8000
- API documentation: http://localhost:8000/api/docs
- Debug toolbar: http://localhost:8000/_debug (when APP_DEBUG=true)

## Deployment

### Production Checklist
1. Update environment settings:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize autoloader:
```bash
composer install --optimize-autoloader --no-dev
```

3. Clear caches:
```bash
php scripts/clear-cache.php
```

4. Update file permissions:
```bash
chmod -R 755 public/ storage/ cache/ logs/
chown -R www-data:www-data storage/ cache/ logs/
```

### Shared Hosting Deployment
1. Upload files via FTP/SFTP
2. Point domain to public/ directory
3. Update .env with production values
4. Run deployment script:
```bash
php scripts/deploy.php
```

## Troubleshooting

### Common Issues

1. **White Screen / 500 Error**
   - Check logs/app.log
   - Verify PHP version and extensions
   - Ensure .env exists and is readable
   - Check file permissions

2. **Database Connection Failed**
   ```bash
   # Test database connection
   php scripts/test-db.php
   ```

3. **Permission Issues**
   ```bash
   # Fix common permission issues
   php scripts/fix-permissions.php
   ```

4. **Cache Issues**
   ```bash
   # Clear all caches
   php scripts/clear-cache.php
   ```

### Debug Mode
Enable detailed error reporting in .env:
```env
APP_DEBUG=true
APP_ENV=local
```

### Health Check
```bash
# Run system health check
php scripts/health-check.php
```

This will verify:
- PHP version and extensions
- Directory permissions
- Database connection
- Cache system
- API connections