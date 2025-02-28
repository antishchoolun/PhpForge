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

- **CSS Structure**
  - Tailwind CSS for utility classes
  - Custom components in `resources/css/`
  - Vite for asset compilation

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
    "prompt": "string",      // Natural language description
    "options": {
        "comments": boolean, // Include comments
        "types": boolean    // Include type hints
    }
}
Response:
{
    "code": "string",       // Generated PHP code
    "analysis": {
        "suggestions": [],  // Improvement suggestions
        "warnings": []      // Potential issues
    }
}
```

### 5. Security Measures

- **Request Validation**
  - Form request validation in controllers
  - CSRF protection via Laravel middleware
  - Rate limiting on API endpoints

- **API Security**
  - Groq API key stored in `.env`
  - Request signing for API calls
  - Response validation and sanitization

### 6. Performance Optimization

- **Asset Management**
  - Vite for development and production builds
  - Asset versioning for cache busting
  - Lazy loading of JavaScript modules

- **Caching**
  - Response caching for API calls
  - Database query caching
  - Route and config caching in production

### 7. Testing

- **Unit Tests**
  - Service class testing
  - Controller response testing
  - API integration testing

- **Feature Tests**
  - End-to-end tool testing
  - Authentication flow testing
  - Error handling scenarios

### 8. Monitoring

- **Error Logging**
  - Laravel's built-in logging
  - Custom log channels for tools
  - API call logging for debugging

- **Performance Tracking**
  - Response time monitoring
  - API usage tracking
  - Error rate monitoring

### 9. Deployment

- **Environment Setup**
  - Production-ready `.env.example`
  - Secure environment configuration
  - Proper file permissions

- **Build Process**
  - Composer optimization
  - Node.js asset compilation
  - Cache warming
