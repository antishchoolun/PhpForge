<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name') }} - @yield('title', 'AI-Powered PHP Tools')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Satoshi:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen">
        <div class="container">
            @include('partials.header')

            <main>
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50"></div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
