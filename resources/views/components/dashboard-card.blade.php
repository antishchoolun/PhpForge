@props([
    'href' => '',
    'title' => '',
    'description' => '',
    'bgColor' => 'bg-indigo-50',
    'hoverColor' => 'hover:bg-indigo-100',
    'titleColor' => 'text-indigo-900',
    'descriptionColor' => 'text-indigo-700',
    'onClick' => null
])

@if($onClick)
<button 
    {{ $attributes->merge(['class' => "w-full text-left block p-6 rounded-lg transition {$bgColor} {$hoverColor}"]) }}
    onclick="{{ $onClick }}">
    <h4 class="text-lg font-semibold {{ $titleColor }}">{{ $title }}</h4>
    <p class="{{ $descriptionColor }}">{{ $description }}</p>
</button>
@else
<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => "block p-6 rounded-lg transition {$bgColor} {$hoverColor}"]) }}>
    <h4 class="text-lg font-semibold {{ $titleColor }}">{{ $title }}</h4>
    <p class="{{ $descriptionColor }}">{{ $description }}</p>
</a>
@endif