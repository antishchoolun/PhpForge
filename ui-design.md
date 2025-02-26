# PhpForge.com Modern UI Design System (Shared Hosting Edition)

## Core Technologies
```php
// Updated stack for shared hosting
- PHP 8.1+ (Laravel 10)
- MySQL 5.7+
- Alpine.js v3 (5.7kB runtime)
- Tailwind CSS v3.3+ (CDN with JIT build)
- Laravel Livewire v3
```

## Blade Component Architecture
```php
// resources/views/components/button.blade.php
@props(['variant' => 'primary'])

<button {{ $attributes->merge([
    'class' => 'px-4 py-2 rounded-lg font-medium transition-all duration-300',
    'x-data' => "{}",
    'x-bind:class' => "{ 
        'bg-primary-600 hover:bg-primary-700 text-white': variant === 'primary',
        'bg-gray-100 hover:bg-gray-200 text-gray-800': variant === 'secondary'
    }"
]) }}>
    {{ $slot }}
</button>
```

## Tailwind Implementation
```php
// Local build process (run before deployment)
npx tailwindcss -i ./src/input.css -o ./public/css/output.css --watch

// Blade layout header
<link href="/css/output.css" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

## Interactive Components
```php
// Livewire component for AI tools
<div wire:poll.750ms class="relative">
    <input 
        x-data="{query: ''}"
        x-model="query"
        type="text" 
        class="w-full px-4 py-3 border rounded-lg"
        placeholder="Describe your PHP code needs..."
    >
    
    @script
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('search', () => ({
                results: [],
                
                async search() {
                    this.results = await $wire.search(this.query)
                }
            }))
        })
    </script>
    @endscript
</div>
```

## Motion Implementation
```css
/* resources/css/motion.css */
@media (prefers-reduced-motion: no-preference) {
    .transition-fade {
        transition: opacity 0.3s ease;
    }
    
    .animate-tool-enter {
        animation: tool-enter 0.3s ease-out;
    }
}
```

## Shared Hosting Checklist
1. **Precompiled Assets**
```bash
php artisan optimize:clear
npm run production
```

2. **.htaccess Configuration**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

3. **Runtime Requirements**
```
PHP 8.1+
ext-curl enabled
ext-fileinfo enabled
```

## Fallback Strategy
```php
// Blade error boundary
@if($errors->any())
    <div class="p-4 bg-red-50 text-red-800">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

// No-JS fallback
<noscript>
    <div class="p-4 bg-yellow-100">
        Enable JavaScript for full functionality
    </div>
</noscript>
```

## Updated Component Library
```php
// resources/views/livewire/code-generator.blade.php
<div class="space-y-4" x-data="{ activeTab: 'php' }">
    <div class="flex gap-2 border-b">
        <button 
            @click="activeTab = 'php'"
            :class="{ 'border-b-2 border-primary-600': activeTab === 'php' }"
            class="px-4 py-2 text-gray-600 hover:text-primary-600"
        >
            PHP Generator
        </button>
    </div>
    
    <div x-show="activeTab === 'php'">
        <livewire:php-generator />
    </div>
</div>