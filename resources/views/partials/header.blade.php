<header>
    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
        </svg>
        <span>PhpForge</span>.com
    </div>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Tools</a></li>
            <li><a href="{{ route('pricing') }}">Pricing</a></li>
            <li><a href="#">Documentation</a></li>
            <li><a href="#">Blog</a></li>
        </ul>
    </nav>
    <div class="auth-buttons">
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

        <!-- Auth Links -->
        @guest
            <button class="btn btn-outline">Sign In</button>
            <button class="btn btn-primary">Get Started</button>
        @else
            <div x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open">
                    <span>{{ Auth::user()->name }}</span>
                    <svg width="4" height="4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                     x-transition:leave-end="transform opacity-0 scale-95">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</header>