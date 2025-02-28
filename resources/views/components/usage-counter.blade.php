@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'rounded-lg p-4 ' . $class]) }}>
    @auth
        <div class="flex items-center text-green-600">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">Unlimited access available</span>
        </div>
    @else
        @php
            $usage = \App\Models\GuestUsage::where('ip_address', request()->ip())
                ->where('session_id', session()->getId())
                ->first();
            $count = $usage ? (5 - $usage->usage_count) : 5;
        @endphp

        <div class="flex items-center {{ $count > 1 ? 'text-blue-600' : 'text-red-600' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <span class="font-medium">{{ $count }} free {{ Str::plural('request', $count) }} remaining today</span>
            <a href="{{ route('register') }}" class="ml-4 text-sm text-indigo-600 hover:text-indigo-900">
                Register for unlimited access →
            </a>
        </div>
    @endauth
</div>
