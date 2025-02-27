# PhpForge.com - AI-Powered PHP Tools Suite

A modern web application providing AI-powered tools for PHP development, optimized for shared hosting environments.

## Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer
- Required PHP extensions:
  - PDO and PDO_MySQL
  - JSON
  - MBString
  - OpenSSL
  - Sodium

## Quick Start

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/phpforge.git
   cd phpforge
   ```

2. Run the setup script:
   ```bash
   composer setup
   ```
   This will:
   - Install dependencies
   - Create necessary directories
   - Set up environment file
   - Configure database
   - Generate application key
   - Set proper permissions

3. Configure your environment:
   - Open `.env` and update the following:
     ```env
     APP_URL=http://your-domain.com
     DB_DATABASE=your_database
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     GROQ_API_KEY=your_groq_api_key
     ```

4. Set up the web server:
   - Point your web server's document root to the `public` directory
   - Ensure mod_rewrite is enabled for Apache
   - Set up proper permissions:
     ```bash
     chmod -R 755 public/
     chmod -R 755 storage/
     chmod -R 755 cache/
     chmod -R 755 logs/
     ```

5. Access the application:
   - Visit `http://localhost` or your configured domain
   - Register an account and start using the tools

## Directory Structure

```
PhpForge/
├── public/                 # Public-facing files
│   ├── index.php          # Entry point
│   ├── assets/            # Compiled assets
│   └── .htaccess         # Apache configuration
├── src/                   # Source files
│   ├── Config/           # Configuration files
│   ├── Controllers/      # Request handlers
│   ├── Models/           # Database models
│   ├── Services/         # Business logic
│   └── Core/             # Framework core
├── templates/            # View templates
├── tests/               # Test files
├── scripts/             # Setup and utility scripts
├── logs/               # Application logs
└── cache/              # Cache files
```

## Available Tools

- **PHP Code Generator**: Transform natural language into clean PHP code
- **AI-Powered Debugging**: Instant error detection and fixes
- **Security Analysis**: Code vulnerability scanning
- **Performance Optimization**: Code performance suggestions
- **Documentation Generator**: Automatic code documentation
- **Domain Valuation**: AI-based domain name evaluation

## Development

1. Enable debug mode in `.env`:
   ```env
   APP_DEBUG=true
   APP_ENV=development
   ```

2. Run PHP's built-in server (for development):
   ```bash
   php -S localhost:8000 -t public/
   ```

3. Watch logs:
   ```bash
   tail -f logs/app.log
   ```

## Testing

Run the test suite:
```bash
composer test
```

Run specific tests:
```bash
composer test-unit     # Unit tests
composer test-feature  # Feature tests
```

Check code style:
```bash
composer check-style  # Check code style
composer fix-style    # Fix code style issues
```

Run static analysis:
```bash
composer phpstan      # Run PHPStan analysis
```

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   chmod -R 755 storage cache logs
   chown -R www-data:www-data storage cache logs
   ```

2. **Database Connection Failed**
   - Verify database credentials in `.env`
   - Ensure MySQL service is running
   - Check if database exists and user has proper permissions

3. **500 Server Error**
   - Check `logs/app.log` for detailed error messages
   - Verify PHP version and extensions
   - Ensure `.env` file exists and is properly configured

4. **Blank Page**
   - Enable error reporting in `php.ini`
   - Check PHP error logs
   - Verify mod_rewrite is enabled

### Debug Mode

To enable detailed error reporting, set in `.env`:
```env
APP_DEBUG=true
APP_ENV=development
```

## Security

- Report security vulnerabilities to security@phpforge.com
- Do not report security issues in public issues
- Keep your dependencies up to date

## Updates

1. Pull latest changes:
   ```bash
   git pull origin main
   ```

2. Update dependencies:
   ```bash
   composer update
   ```

3. Run migrations:
   ```bash
   php scripts/migrate.php
   ```

## License

MIT License - See [LICENSE](LICENSE) file for details

## Support

- Documentation: [docs.phpforge.com](https://docs.phpforge.com)
- Email: support@phpforge.com
- Community: [Discord](https://discord.gg/phpforge)
