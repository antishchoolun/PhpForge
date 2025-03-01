@props(['class' => ''])

<div {{ $attributes->merge(['class' => $class]) }}>
    @auth
        <div class="flex items-center gap-2 text-green-600 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Unlimited access</span>
        </div>
    @else
        @php
            $usage = \App\Models\GuestUsage::where('ip_address', request()->ip())
                ->where('session_id', session()->getId())
                ->first();
            $count = $usage ? (5 - $usage->usage_count) : 5;
        @endphp

        <div class="flex items-center gap-2 {{ $count > 1 ? 'text-blue-600' : 'text-red-600' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <span class="text-sm whitespace-nowrap">{{ $count }} free {{ Str::plural('request', $count) }} left today</span>
            <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:text-indigo-900 whitespace-nowrap">
                Get unlimited →
            </a>
        </div>
    @endauth
</div>
