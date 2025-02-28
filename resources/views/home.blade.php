@extends('layouts.app')

@section('content')
<div class="relative isolate overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 -z-10 opacity-30">
        <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="32" height="32" patternUnits="userSpaceOnUse">
                    <path d="M0 32V.5H32" fill="none" stroke="currentColor" stroke-opacity="0.2"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"></rect>
        </svg>
    </div>

    <!-- Hero section -->
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    PHP Development Tools
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    AI-powered tools to help you write better PHP code, debug issues faster, and optimize your applications.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Get started
                    </a>
                    <a href="{{ route('pricing') }}" class="text-sm font-semibold leading-6 text-gray-900">
                        View pricing <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:grid-cols-3">
                <div class="bg-indigo-50 p-8 rounded-2xl">
                    <h3 class="text-xl font-semibold leading-7 text-gray-900">Code Generation</h3>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Generate PHP classes, methods, and tests with AI assistance.
                    </p>
                </div>
                <div class="bg-green-50 p-8 rounded-2xl">
                    <h3 class="text-xl font-semibold leading-7 text-gray-900">Debugging Tools</h3>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Advanced tools to help you identify and fix issues quickly.
                    </p>
                </div>
                <div class="bg-blue-50 p-8 rounded-2xl">
                    <h3 class="text-xl font-semibold leading-7 text-gray-900">Optimization</h3>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Performance analysis and optimization recommendations.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
