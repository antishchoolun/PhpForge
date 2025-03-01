@props([
    'class' => '',
    'width' => 200, // default width, height will scale proportionally
    'withText' => true // whether to show the text or just the icon
])

<div {{ $attributes->merge(['class' => 'inline-flex items-center ' . $class]) }}>
    <div style="width: {{ $width }}px; max-width: 100%;">
        @include('svg.logo')
    </div>
    @if($withText)
        <span class="sr-only">PhpForge</span>
    @endif
</div>