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
    <div class="relative group">
        <button 
            @click="copyToClipboard"
            class="p-2 bg-gray-800/50 hover:bg-gray-800/70 rounded-lg backdrop-blur-lg transition-all"
            :class="{ 'bg-green-500/50': copied }"
            title="Copy code">
            <template x-if="!copied">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                </svg>
            </template>
            <template x-if="copied">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </template>
        </button>
        <div class="absolute hidden group-hover:block bg-gray-900 text-white text-sm px-2 py-1 rounded -top-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap z-[9999] pointer-events-none">
            <span x-text="copied ? 'Copied!' : 'Copy to clipboard'"></span>
            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </div>

    <div class="relative group">
        <button 
            @click="downloadCode"
            class="p-2 bg-gray-800/50 hover:bg-gray-800/70 rounded-lg backdrop-blur-lg transition-all"
            :class="{ 'bg-green-500/50': downloaded }"
            title="Download">
            <template x-if="!downloaded">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </template>
            <template x-if="downloaded">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </template>
        </button>
        <div class="absolute hidden group-hover:block bg-gray-900 text-white text-sm px-2 py-1 rounded -top-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap z-[9999] pointer-events-none">
            <span x-text="downloaded ? 'Downloaded!' : 'Download code'"></span>
            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </div>
</div>