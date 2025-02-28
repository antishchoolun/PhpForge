@props(['remainingRequests' => null])

<div {{ $attributes->merge(['class' => 'text-sm']) }}>
    @auth
        <span class="text-green-600">
            <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Unlimited Access
        </span>
    @else
        @if($remainingRequests !== null)
            <span class="{{ $remainingRequests > 0 ? 'text-indigo-600' : 'text-red-600' }}">
                {{ $remainingRequests }} / 5 requests remaining today
            </span>
            @if($remainingRequests === 0)
                <a href="{{ route('register') }}" class="ml-2 text-indigo-600 hover:text-indigo-800">
                    Register for unlimited access →
                </a>
            @endif
        @endif
    @endauth
</div>
