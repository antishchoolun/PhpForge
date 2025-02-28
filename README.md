# PhpForge - AI-Powered PHP Development Tools

PhpForge is a suite of AI-powered tools designed to enhance PHP development workflows. Built with Laravel and integrated with Groq API, it offers intelligent code generation, debugging assistance, security analysis, and more.

## Features

- 🤖 **AI Code Generation**: Transform natural language descriptions into clean PHP code
- 🔍 **Intelligent Debugging**: Get AI-powered suggestions for fixing code issues
- 🛡️ **Security Analysis**: Identify potential vulnerabilities in your PHP code
- ⚡ **Performance Optimization**: Receive suggestions for improving code performance
- 📚 **Documentation Generation**: Automatically generate code documentation

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/phpforge.git
cd phpforge
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
```

4. Copy the environment file and configure:
```bash
cp .env.example .env
```

5. Set up your environment variables in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phpforge
DB_USERNAME=your_username
DB_PASSWORD=your_password

GROQ_API_KEY=your_groq_api_key
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Build frontend assets:
```bash
npm run build
```

## Development

To start the development server:

```bash
php artisan serve
npm run dev
```

## Testing

Run tests with PHPUnit:

```bash
php artisan test
```

## API Documentation

### Available Endpoints

```
POST /api/v1/tools/generate    # Generate PHP code
POST /api/v1/tools/debug       # Debug code issues
POST /api/v1/tools/security    # Analyze security
POST /api/v1/tools/optimize    # Get optimization suggestions
POST /api/v1/tools/document    # Generate documentation
```

See [API Documentation](docs/api.md) for detailed endpoint specifications.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security vulnerabilities, please email security@phpforge.com instead of using the issue tracker.

## License

[MIT License](LICENSE.md)

## Credits

- Built with [Laravel](https://laravel.com)
- AI powered by [Groq](https://groq.com)
