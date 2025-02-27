# PhpForge Project Structure

## Directory Structure

```
PhpForge/
├── app/                  # Application core
│   ├── Console/         # Artisan commands
│   ├── Exceptions/      # Custom exceptions
│   ├── Http/           # HTTP layer
│   │   ├── Controllers/ # Laravel controllers
│   │   └── Middleware/ # Custom middleware
│   └── Models/         # Eloquent models
├── bootstrap/           # Framework boot files
├── config/              # Configuration files
├── database/            # Database migrations/seeds
├── public/              # Web root (shared hosting)
│   ├── index.php       # Laravel entry point
│   ├── assets/         # Compiled assets
│   └── .htaccess       # Server configuration
├── resources/          # Frontend resources
│   ├── views/          # Blade templates
│   └── js/             # Vanilla JS components
├── routes/             # Route definitions
├── storage/            # Storage (logs, cache, etc)
├── tests/              # PHPUnit tests
├── vendor/             # Composer dependencies
├── .env                # Environment variables
├── .env.example        # Environment template
├── .gitignore
├── artisan             # Artisan CLI
├── composer.json       # PHP dependencies
└── composer.lock
```

## Architectural Components

### 1. Frontend Architecture
- **JavaScript Components**
  - `resources/js/tools/` - Individual tool implementations
  - `resources/js/core/` - Core functionality (API client, utilities)
  - `resources/js/ui/` - UI components and interactions

- **CSS Structure**
  - Laravel Mix for CSS compilation
  - Tailwind CSS utility classes
  - Component-specific styles in Blade templates
  - Shared hosting compatible asset pipeline

### 2. Backend Architecture
- **Laravel Framework**
  - Built-in routing system
  - Eloquent ORM for database
  - Service container and dependency injection
  - Blade templating engine
  - Artisan command-line interface

- **Laravel Services**
  - Service classes in app/Services
  - Groq API integration via HTTP client
  - Redis caching integration
  - Laravel Sanctum for authentication
  - Laravel Telescope for logging/monitoring

- **Controllers**
  - Request validation
  - Service orchestration
  - Response formatting

### 3. Database Schema

```sql
-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tools usage logging
CREATE TABLE tool_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    tool_name VARCHAR(50) NOT NULL,
    input_data TEXT,
    output_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- API rate limiting
CREATE TABLE api_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    endpoint VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 4. API Endpoints

```
/api/v1/
├── auth/
│   ├── login     POST
│   ├── register  POST
│   └── logout    POST
├── tools/
│   ├── generate    POST - Code generation
│   ├── debug       POST - Debug code
│   ├── security    POST - Security analysis
│   ├── optimize    POST - Performance optimization
│   ├── document    POST - Generate documentation
│   └── evaluate    POST - Domain valuation
└── user/
    └── usage      GET  - Tool usage statistics
```

### 5. Security Measures

- **Laravel Security**
  - Form Request validation
  - Eloquent ORM parameter binding
  - Blade template auto-escaping
  - CSRF tokens with @csrf directive

- **Authentication**
  - Laravel Sanctum API authentication
  - Laravel rate limiting middleware
  - Encrypted session driver

- **Data Protection**
  - Laravel environment configuration
  - Encrypted .env values
  - Bcrypt password hashing

### 6. Performance Optimization

- **Frontend**
  - Minified assets
  - Lazy loading
  - Browser caching
  - Compressed images

- **Backend**
  - Eloquent eager loading
  - Route caching
  - Laravel Octane for performance
  - Queue workers for heavy tasks

### 7. Deployment Strategy

- **Staging Process**
  1. Local development
  2. Staging environment
  3. Production deployment

- **Deployment Checklist**
  - Laravel Forge deployment
  - Database migrations via Artisan
  - Mix asset compilation
  - Config and route caching
  - Security headers middleware

### 8. Monitoring and Logging

- **Error Logging**
  - Application errors
  - API request logs
  - Security incidents

- **Performance Monitoring**
  - Response times
  - Resource usage
  - API quota usage
  - User activity

### 9. Scaling Considerations

- **Horizontal Scaling**
  - Stateless application design
  - Session management
  - Cache synchronization

- **Resource Management**
  - Database connection pooling
  - File system optimization
  - Memory usage monitoring