# PhpForge Project Structure

## Directory Structure

```
PhpForge/
├── app/                     # Application core
│   ├── Http/               # HTTP layer
│   │   ├── Controllers/    # Controllers for tools
│   │   └── Middleware/     # Request middleware
│   ├── Models/             # Eloquent models
│   └── Services/           # Core services
│       ├── CodeGenerator/  # Code generation service
│       └── GroqApi/        # Groq API integration
├── bootstrap/              # Framework boot files
├── config/                 # Configuration files
├── database/              # Database files
│   ├── migrations/        # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Web root
│   ├── build/           # Compiled assets
│   └── index.php       # Entry point
├── resources/          # Frontend resources
│   ├── css/           # Tailwind & custom CSS
│   ├── js/            # JavaScript modules
│   │   ├── modules/   # Feature-specific JS
│   │   └── app.js     # Main JS entry
│   └── views/         # Blade templates
│       ├── layouts/   # Layout templates
│       ├── partials/  # Reusable components
│       └── tools/     # Tool-specific views
├── routes/            # Route definitions
├── storage/           # Logs and cache
├── tests/            # Test suites
├── composer.json     # PHP dependencies
├── package.json      # Node dependencies
└── vite.config.js    # Vite configuration
```

## Core Components

### 1. Frontend Architecture

- **JavaScript Modules**
  - `clipboard.js` - Copy to clipboard functionality
  - `codeGenerator.js` - Code generation interface
  - `modals.js` - Modal dialog management
  - `errorHandler.js` - Error display system
  - `codeActions.js` - Code action buttons (copy/download)

- **Blade Components**
  - `error-popup.blade.php` - Error display component
  - `quantum-loader.blade.php` - Loading animation
  - `code-actions.blade.php` - Code action buttons
  - `error-message.blade.php` - Inline error messages

- **CSS Structure**
  - Tailwind CSS for utility classes
  - Custom components in `resources/css/`
  - Vite for asset compilation
  - Modal and animation styles

### 2. Backend Architecture

- **Services**
  - `CodeGeneratorService` - Handles code generation logic
  - `GroqApiClient` - Manages Groq API communication

- **Controllers**
  - `CodeGeneratorController` - Handles code generation requests
  - `HomeController` - Manages main page rendering

### 3. Database Schema

```sql
-- Users table
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Guest Usage tracking
CREATE TABLE guest_usage (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    fingerprint VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    requests_count INT UNSIGNED DEFAULT 0,
    last_request_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_fingerprint (fingerprint)
);

-- Cache table for Laravel's cache system
CREATE TABLE cache (
    key VARCHAR(255) NOT NULL,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    PRIMARY KEY (key)
);

-- Jobs table for queued tasks
CREATE TABLE jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL
);
```

### 4. API Endpoints

#### Code Generator
```
POST /api/v1/tools/generate
Request:
{
    "prompt": "string",         // Natural language description
    "framework": "string",      // PHP framework selection
    "component": "string",      // Component type
    "patterns": ["string"],     // Design patterns to include
    "phpVersion": "string",     // PHP version features
    "options": {
        "comments": boolean,    // Include comments
        "error_handling": boolean,
        "psr12": boolean,
        "type_hints": boolean
    }
}

Response Success:
{
    "success": true,
    "code": "string",          // Generated PHP code
    "analysis": {
        "suggestions": [],     // Improvement suggestions
        "warnings": []         // Potential issues
    }
}

Response Error:
{
    "success": false,
    "error": "string",         // Error type
    "message": "string",       // Error message
    "remaining_time": "string" // For rate limit errors
}
```

### 5. Security Measures

- **Request Validation**
  - Form request validation in controllers
  - CSRF protection via Laravel middleware
  - Rate limiting on API endpoints
  - Guest usage tracking and limits

- **API Security**
  - Groq API key stored in `.env`
  - Request signing for API calls
  - Response validation and sanitization
  - IP and fingerprint tracking

### 6. Performance Optimization

- **Asset Management**
  - Vite for development and production builds
  - Asset versioning for cache busting
  - Lazy loading of JavaScript modules
  - Dynamic component loading

- **Caching**
  - Response caching for API calls
  - Database query caching
  - Route and config caching in production
  - Guest usage caching

### 7. User Interface Components

- **Modal System**
  - Full-screen split layout
  - Responsive design
  - Dark mode support
  - Custom scrollbar styling

- **Loading States**
  - Quantum loader animation
  - Canvas particle system
  - Progress indicator
  - Backdrop blur effects

- **Error Handling**
  - Pop-up error messages
  - Different styles for error types
  - Action buttons for upgrades
  - Smooth animations

- **Code Actions**
  - Copy to clipboard
  - File download
  - Visual feedback
  - Tooltip system

### 8. Testing

- **Unit Tests**
  - Service class testing
  - Controller response testing
  - API integration testing
  - Rate limiting tests

- **Feature Tests**
  - End-to-end tool testing
  - Authentication flow testing
  - Error handling scenarios
  - Guest usage limits

### 9. Monitoring

- **Error Logging**
  - Laravel's built-in logging
  - Custom log channels for tools
  - API call logging for debugging
  - Guest usage tracking

- **Performance Tracking**
  - Response time monitoring
  - API usage tracking
  - Error rate monitoring
  - Guest request monitoring

### 10. Deployment

- **Environment Setup**
  - Production-ready `.env.example`
  - Secure environment configuration
  - Proper file permissions
  - Rate limit configuration

- **Build Process**
  - Composer optimization
  - Node.js asset compilation
  - Cache warming
  - Database migrations
