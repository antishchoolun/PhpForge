@props([
    'type' => 'error', // error, warning, info
    'title' => '',
    'message' => '',
    'details' => null,
    'action' => null,
    'actionUrl' => null
])

@php
$bgColors = [
    'error' => 'bg-red-50 dark:bg-red-900/10',
    'warning' => 'bg-yellow-50 dark:bg-yellow-900/10',
    'info' => 'bg-blue-50 dark:bg-blue-900/10'
];

$textColors = [
    'error' => 'text-red-700 dark:text-red-400',
    'warning' => 'text-yellow-700 dark:text-yellow-400',
    'info' => 'text-blue-700 dark:text-blue-400'
];

$borderColors = [
    'error' => 'border-red-400 dark:border-red-500',
    'warning' => 'border-yellow-400 dark:border-yellow-500',
    'info' => 'border-blue-400 dark:border-blue-500'
];

$icons = [
    'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
    'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
    'info' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
];
@endphp

<div class="rounded-lg border {{ $bgColors[$type] }} {{ $borderColors[$type] }} p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 {{ $textColors[$type] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {!! $icons[$type] !!}
            </svg>
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium {{ $textColors[$type] }}">
                    {{ $title }}
                </h3>
            @endif
            
            <div class="mt-2 text-sm {{ $textColors[$type] }}">
                <p>{{ $message }}</p>
                
                @if($details)
                    <ul class="mt-2 list-disc list-inside">
                    @foreach((array)$details as $detail)
                        <li>{{ $detail }}</li>
                    @endforeach
                    </ul>
                @endif
            </div>

            @if($action && $actionUrl)
                <div class="mt-4">
                    <div class="-mx-2 -my-1.5 flex">
                        <a href="{{ $actionUrl }}" 
                           class="px-2 py-1.5 rounded-md text-sm font-medium {{ $textColors[$type] }} hover:{{ $bgColors[$type] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-{{ substr($textColors[$type], 5) }}">
                            {{ $action }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>