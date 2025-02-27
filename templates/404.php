<?php
/**
 * 404 Error Page
 * 
 * @var string $title Page title
 * @var string $description Page description
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Page Not Found - PhpForge' ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="error-page">
        <div class="container">
            <div class="error-content">
                <h1>404</h1>
                <h2>Page Not Found</h2>
                <p><?= $description ?? 'The page you are looking for does not exist or has been moved.' ?></p>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary">Go Home</a>
                    <a href="/contact" class="btn btn-outline">Contact Support</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .error-content {
            max-width: 500px;
        }

        .error-content h1 {
            font-size: 8rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .error-content h2 {
            font-size: 2rem;
            margin: 1rem 0;
            color: var(--dark);
        }

        .error-content p {
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .error-content h1 {
                font-size: 6rem;
            }

            .error-content h2 {
                font-size: 1.5rem;
            }

            .error-actions {
                flex-direction: column;
            }
        }
    </style>
</body>
</html>