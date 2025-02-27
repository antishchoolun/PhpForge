# Secure PHP Project Structure Guide

## Recommended Directory Structure
```
project-root/
├── public/              # Web server document root
│   ├── assets/         # Publicly accessible assets
│   │   ├── css/        # styles.css
│   │   └── js/         # app.js
│   ├── index.php       # Front controller
│   └── .htaccess       # Public security rules
├── src/
│   ├── auth/           # Authentication logic
│   ├── components/     # UI components
│   └── config/         # Configuration files
└── .htaccess           # Global security rules
```

## Security Configuration
### Root .htaccess (project-root/.htaccess)
```apache
# Deny access to everything except public/
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^public/ - [L]
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

# Prevent directory listing
Options -Indexes
```

### Public .htaccess (public/.htaccess)
```apache
# Allow only specific file types
<FilesMatch "\.(php|html|css|js|jpe?g|png|gif)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Block access to sensitive files
<FilesMatch "\.(env|sql|config|htaccess)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>
```

## Migration Steps
1. Create asset directories:
```cmd
mkdir public\assets public\assets\css public\assets\js
```

2. Move existing assets:
```cmd
move src\css\styles.css public\assets\css\
move src\js\app.js public\assets\js\
```

3. Update references in PHP files:
```php
// Change from:
<link rel="stylesheet" href="/src/css/styles.css">
// To:
<link rel="stylesheet" href="/assets/css/styles.css">
```

4. Implement .htaccess rules shown above

## Rationale
- Prevents direct access to sensitive PHP files
- Follows front controller pattern
- Limits exposed attack surface
- Maintains separation of concerns
- Complies with OWASP security guidelines