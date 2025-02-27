# PhpForge Project Structure

## Directory Structure

```
PhpForge/
├── public/                 # Public-facing files
│   ├── index.php          # Main entry point
│   ├── assets/            # Compiled/public assets
│   │   ├── css/          # Compiled CSS files
│   │   ├── js/           # Compiled JavaScript files
│   │   └── images/       # Image assets
│   └── .htaccess         # Apache configuration
├── src/                   # Source files
│   ├── Config/           # Configuration files
│   │   ├── Database.php  # Database configuration
│   │   └── App.php       # Application configuration
│   ├── Controllers/      # Request handlers
│   │   ├── AuthController.php
│   │   ├── ToolController.php
│   │   └── ApiController.php
│   ├── Models/           # Database models
│   │   ├── User.php
│   │   └── Tool.php
│   ├── Services/         # Business logic
│   │   ├── CodeGenerator/
│   │   ├── Debugging/
│   │   ├── Security/
│   │   ├── Performance/
│   │   ├── Documentation/
│   │   └── DomainValuation/
│   ├── Core/             # Framework core
│   │   ├── Database.php
│   │   ├── Router.php
│   │   └── App.php
│   └── Helpers/          # Utility functions
├── templates/            # Frontend templates
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   └── tools/           # Tool-specific templates
├── assets/              # Source assets
│   ├── css/            # CSS source files
│   ├── js/             # JavaScript source files
│   └── images/         # Original images
├── tests/              # Test files
├── logs/              # Application logs
├── vendor/            # Composer dependencies
├── composer.json      # PHP dependencies
├── composer.lock
├── .env              # Environment variables
├── .env.example      # Environment template
├── .gitignore
└── README.md         # Project documentation
```

## Architectural Components

### 1. Frontend Architecture
- **Pure JavaScript Modules**
  - `assets/js/tools/` - Individual tool implementations
  - `assets/js/core/` - Core functionality (API client, utilities)
  - `assets/js/ui/` - UI components and interactions

- **CSS Structure**
  - `assets/css/base/` - Reset and base styles
  - `assets/css/components/` - Reusable components
  - `assets/css/tools/` - Tool-specific styles
  - `assets/css/layout/` - Layout and structure

### 2. Backend Architecture
- **Core Framework**
  - Lightweight routing system
  - PDO database abstraction
  - Simple dependency injection
  - Error handling and logging

- **Services Layer**
  - Individual tool services
  - Groq API integration
  - Caching mechanisms
  - Authentication service
  - Logging service

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

- **Input Validation**
  - Server-side validation for all inputs
  - Prepared statements for SQL
  - XSS prevention
  - CSRF protection

- **Authentication**
  - JWT-based authentication
  - Rate limiting
  - Session management

- **Data Protection**
  - Environment-based configuration
  - Encrypted sensitive data
  - Secure password hashing

### 6. Performance Optimization

- **Frontend**
  - Minified assets
  - Lazy loading
  - Browser caching
  - Compressed images

- **Backend**
  - Database query optimization
  - Response caching
  - Rate limiting
  - Resource pooling

### 7. Deployment Strategy

- **Staging Process**
  1. Local development
  2. Staging environment
  3. Production deployment

- **Deployment Checklist**
  - Environment configuration
  - Database migrations
  - Asset compilation
  - Cache clearing
  - Security checks

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