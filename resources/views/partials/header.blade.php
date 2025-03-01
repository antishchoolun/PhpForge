<!-- Top Header -->
<div class="top-header">
    <div class="container">
        <!-- Usage Counter -->
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
        <x-usage-counter :remaining-requests="$remainingRequests" />
    </div>
</div>

<!-- Main Header -->
<header>
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <a href="/" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                <span>PhpForge</span>.com
            </a>

            <!-- Navigation -->
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Tools</a></li>
                    <li><a href="{{ route('pricing') }}">Pricing</a></li>
                    <li><a href="#">Documentation</a></li>
                </ul>
            </nav>

            <!-- Auth Links -->
            <div class="auth-buttons">
                @guest
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    </div>
                @else
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="btn btn-outline flex items-center gap-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-lg shadow-lg border border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
