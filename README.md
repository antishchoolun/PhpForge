# PhpForge.com - AI-Powered PHP Tools Suite

A comprehensive web application providing AI-powered tools for PHP development, optimized for shared hosting environments.

## Features

- **PHP Code Generator**: Transform natural language into clean, efficient PHP code
- **AI-Powered Debugging**: Instantly identify and fix code errors
- **Security Analysis**: Detect and prevent security vulnerabilities
- **Performance Optimization**: Get AI-powered suggestions for code optimization
- **Documentation Generator**: Create comprehensive documentation automatically
- **Domain Valuation**: Evaluate domain names using AI market analysis

## Technology Stack

- **Frontend**:

  - Vanilla JavaScript with modern patterns
  - Custom CSS with variables
  - Responsive design
  - Progressive enhancement
  - Animate.css for animations
  - Feather icons

- **Backend**:

  - PHP 8.2+
  - PDO for database operations
  - Lightweight custom framework
  - Groq API integration
  - JWT authentication

- **Database**:
  - MySQL/MariaDB
  - Prepared statements
  - Connection pooling
  - Query optimization

## Project Structure

See [structure.md](structure.md) for detailed project architecture and organization.

## Requirements

- PHP 7.2 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- SSL certificate (for production)
- Composer for dependency management

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/phpforge.git
   cd phpforge
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Set up environment variables:

   ```bash
   cp .env.example .env
   # Edit .env with your configuration
   ```

4. Set up the database:

   ```bash
   # Import database schema
   mysql -u your_username -p your_database < schema.sql
   ```

5. Configure web server:

   - Point document root to the `public/` directory
   - Ensure `.htaccess` is enabled (Apache)
   - Configure URL rewriting

6. Set proper permissions:
   ```bash
   chmod -R 755 public/
   chmod -R 755 logs/
   ```

## Development Setup

1. Install development dependencies:

   ```bash
   composer install --dev
   ```

2. Start local development server:

   ```bash
   php -S localhost:8000 -t public/
   ```

3. Access the application:
   ```
   http://localhost:8000
   ```

## Testing

Run the test suite:

```bash
composer test
```

Run specific test category:

```bash
composer test-unit    # Unit tests
composer test-feature # Feature tests
```

## Deployment

1. Update dependencies:

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. Set environment variables:

   - Set `APP_ENV=production`
   - Configure production database
   - Set up Groq API credentials

3. Optimize application:

   ```bash
   # Compile assets
   npm run build

   # Clear caches
   php scripts/cache-clear.php
   ```

4. Security checklist:
   - Enable HTTPS
   - Set secure cookie flags
   - Configure CORS
   - Set up rate limiting

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Documentation

- [Project Structure](structure.md)
- [API Documentation](docs/api.md)
- [Development Guide](docs/development.md)
- [Deployment Guide](docs/deployment.md)

## Security

Report security vulnerabilities to security@phpforge.com

## License

MIT License - See [LICENSE](LICENSE) file for details

## Contact

- Website: [https://phpforge.com](https://phpforge.com)
- Email: support@phpforge.com
- Twitter: [@phpforge](https://twitter.com/phpforge)
