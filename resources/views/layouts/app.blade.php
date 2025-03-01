<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    @guest
        @php
            $remainingRequests = null;
            if (!auth()->check()) {
                $guestUsage = \App\Models\GuestUsage::where('ip_address', request()->ip())
                    ->where('session_id', session()->getId())
                    ->first();
                if ($guestUsage) {
                    $remainingRequests = max(0, 5 - $guestUsage->usage_count);
                } else {
                    $remainingRequests = 5;
                }
            }
        @endphp
        <div class="usage-counter-wrapper">
            <x-usage-counter :remaining-requests="$remainingRequests" />
        </div>
    @endguest
    <div class="min-h-screen">
        @include('partials.header')

        <!-- Page Content -->
        <main>
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <!-- Stack for additional scripts -->
    @stack('scripts')

    <!-- Flash Messages -->
    @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</body>
</html>
