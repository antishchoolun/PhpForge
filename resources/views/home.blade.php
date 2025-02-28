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

    <!-- Tools section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- PHP Code Generator -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.1s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-500 rounded px-2 py-1 mb-4">AI-Powered</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">PHP Code Generator</h3>
                        <p class="text-gray-600 mb-4">Transform natural language into clean, efficient PHP code with a single prompt.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Generate Code
                        </a>
                    </div>
                </div>

                <!-- AI Debugging -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.2s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-500 rounded px-2 py-1 mb-4">AI-Powered</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                <path d="M12 13V7"></path>
                                <path d="M12 17.01 12.01 17"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">AI Debugging & Error Checking</h3>
                        <p class="text-gray-600 mb-4">Identify and fix bugs instantly with intelligent error analysis and solutions.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Debug Code
                        </a>
                    </div>
                </div>

                <!-- Security Analysis -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.3s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-emerald-50 text-emerald-500 rounded px-2 py-1 mb-4">Security</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Security Analysis Tool</h3>
                        <p class="text-gray-600 mb-4">Scan your PHP code for vulnerabilities and get actionable security recommendations.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Scan Code
                        </a>
                    </div>
                </div>

                <!-- Performance Optimization -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.4s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-500 rounded px-2 py-1 mb-4">AI-Powered</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Performance Optimization</h3>
                        <p class="text-gray-600 mb-4">Enhance your PHP code's performance with AI-generated optimization suggestions.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Optimize Code
                        </a>
                    </div>
                </div>

                <!-- Documentation Generator -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.5s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-500 rounded px-2 py-1 mb-4">AI-Powered</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <path d="M14 2v6h6"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                                <path d="M10 9H8"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Documentation Generator</h3>
                        <p class="text-gray-600 mb-4">Create comprehensive, well-structured documentation directly from your code.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Generate Docs
                        </a>
                    </div>
                </div>

                <!-- Domain Valuation -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 animate-[float_4s_ease-in-out_infinite]" style="animation-delay: 0.6s;">
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-pink-500"></div>
                    <div class="p-6">
                        <span class="inline-block text-xs font-semibold bg-pink-50 text-pink-500 rounded px-2 py-1 mb-4">AI-Powered</span>
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20z"></path>
                                <path d="M12 8v8"></path>
                                <path d="M8 12h8"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Domain Valuation Tool</h3>
                        <p class="text-gray-600 mb-4">Get accurate valuations for domain names based on AI-powered market analysis.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-xl">
                            Evaluate Domain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
