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
            <div class="tool-cards">
                <!-- PHP Code Generator -->
                <div class="card floating" style="animation-delay: 0.1s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag ai-tag">AI-Powered</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg>
                        </div>
                        <h3>PHP Code Generator</h3>
                        <p>Transform natural language into clean, efficient PHP code with a single prompt.</p>

                    </div>
                </div>

                <!-- AI Debugging -->
                <div class="card floating" style="animation-delay: 0.2s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag ai-tag">AI-Powered</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                <path d="M12 13V7"></path>
                                <path d="M12 17.01 12.01 17"></path>
                            </svg>
                        </div>
                        <h3>AI Debugging & Error Checking</h3>
                        <p>Identify and fix bugs instantly with intelligent error analysis and solutions.</p>
                        <a href="#" class="btn btn-primary">Debug Code</a>
                    </div>
                </div>

                <!-- Security Analysis -->
                <div class="card floating" style="animation-delay: 0.3s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag security-tag">Security</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3>Security Analysis Tool</h3>
                        <p>Scan your PHP code for vulnerabilities and get actionable security recommendations.</p>
                        <a href="#" class="btn btn-primary">Scan Code</a>
                    </div>
                </div>

                <!-- Performance Optimization -->
                <div class="card floating" style="animation-delay: 0.4s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag ai-tag">AI-Powered</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                            </svg>
                        </div>
                        <h3>Performance Optimization</h3>
                        <p>Enhance your PHP code's performance with AI-generated optimization suggestions.</p>
                        <a href="#" class="btn btn-primary">Optimize Code</a>
                    </div>
                </div>

                <!-- Documentation Generator -->
                <div class="card floating" style="animation-delay: 0.5s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag ai-tag">AI-Powered</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <path d="M14 2v6h6"></path>
                                <path d="M16 13H8"></path>
                                <path d="M16 17H8"></path>
                                <path d="M10 9H8"></path>
                            </svg>
                        </div>
                        <h3>Documentation Generator</h3>
                        <p>Create comprehensive, well-structured documentation directly from your code.</p>
                        <a href="#" class="btn btn-primary">Generate Docs</a>
                    </div>
                </div>

                <!-- Domain Valuation -->
                <div class="card floating" style="animation-delay: 0.6s;">
                    <div class="card-accent"></div>
                    <div class="card-content">
                        <span class="feature-tag ai-tag">AI-Powered</span>
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2a10 10 0 1 0 0 20 10 10 0 1 0 0-20z"></path>
                                <path d="M12 8v8"></path>
                                <path d="M8 12h8"></path>
                            </svg>
                        </div>
                        <h3>Domain Valuation Tool</h3>
                        <p>Get accurate valuations for domain names based on AI-powered market analysis.</p>
                        <a href="#" class="btn btn-primary">Evaluate Domain</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
