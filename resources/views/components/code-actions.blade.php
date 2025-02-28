@props([
    'targetId' => '',
    'downloadName' => 'code',
    'downloadExt' => '.php',
    'position' => 'top-right' // Supports: top-right, top-left, bottom-right, bottom-left
])

@php
$positionClasses = [
    'top-right' => 'right-4 top-4',
    'top-left' => 'left-4 top-4',
    'bottom-right' => 'right-4 bottom-4',
    'bottom-left' => 'left-4 bottom-4'
];
@endphp

<div class="absolute {{ $positionClasses[$position] ?? $positionClasses['top-right'] }} flex space-x-2 z-10"
    x-data="codeActions({ targetId: '{{ $targetId }}', downloadName: '{{ $downloadName }}', downloadExt: '{{ $downloadExt }}' })"
>
    <button 
        @click="copyToClipboard"
        class="p-2 bg-gray-800/50 hover:bg-gray-800/70 rounded-lg backdrop-blur-lg transition-all group"
        :class="{ 'bg-green-500/50': copied }"
        title="Copy code">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
        </svg>
        <span class="absolute hidden group-hover:block bg-gray-900 text-white text-sm px-2 py-1 rounded -top-8 left-1/2 transform -translate-x-1/2">
            Copy to clipboard
        </span>
    </button>
    <button 
        @click="downloadCode"
        class="p-2 bg-gray-800/50 hover:bg-gray-800/70 rounded-lg backdrop-blur-lg transition-all group"
        :class="{ 'bg-green-500/50': downloaded }"
        title="Download">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        <span class="absolute hidden group-hover:block bg-gray-900 text-white text-sm px-2 py-1 rounded -top-8 left-1/2 transform -translate-x-1/2">
            Download code
        </span>
    </button>
</div>