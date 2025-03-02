@extends('layouts.app')

@section('content')
<div class="relative isolate">

    <!-- Hero section -->
    <div class="hero">
        <div class="container">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="hero-title animate__animated animate__fadeIn">
                    PHP Development, <br>Supercharged by AI
                </h1>
                <p class="hero-description animate__animated animate__fadeIn animate__delay-1s">
                    Transform your PHP workflow with our suite of AI-powered tools designed to help you code faster, debug smarter, and build more secure applications.
                </p>
                <div class="hero-buttons animate__animated animate__fadeIn animate__delay-2s">
                    <button class="btn btn-primary">
                        Explore Tools
                    </button>
                    <a href="{{ route('pricing') }}" class="btn btn-secondary">
                        View Pricing
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tools section -->
    <div class="">
        <div class="container">
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">PHP Code Generator</h3>
                        <p class="text-gray-600 mb-4">Transform natural language into clean, efficient PHP code with a single prompt.</p>
                        <button onclick="openModal('code-generator')" class="btn btn-primary">
                            Generate Code
                        </button>
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">AI Debugging & Error Checking</h3>
                        <p class="text-gray-600 mb-4">Identify and fix bugs instantly with intelligent error analysis and solutions.</p>
                        <button onclick="openModal('code-debugger')" class="btn btn-primary">
                            Debug Code
                        </button>
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Security Analysis Tool</h3>
                        <p class="text-gray-600 mb-4">Scan your PHP code for vulnerabilities and get actionable security recommendations.</p>
                        <button onclick="openModal('security-analyzer')" class="btn btn-primary">
                            Scan Code
                        </button>
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Performance Optimization</h3>
                        <p class="text-gray-600 mb-4">Enhance your PHP code's performance with AI-generated optimization suggestions.</p>
                        <a href="#" class="btn btn-primary">
                            Optimize Code
                        </a>
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Documentation Generator</h3>
                        <p class="text-gray-600 mb-4">Create comprehensive, well-structured documentation directly from your code.</p>
                        <a href="#" class="btn btn-primary">
                            Generate Docs
                        </a>
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
                        <h3 class="text-xl font-bold mb-2 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Domain Valuation Tool</h3>
                        <p class="text-gray-600 mb-4">Get accurate valuations for domain names based on AI-powered market analysis.</p>
                        <a href="#" class="btn btn-primary">
                            Evaluate Domain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include modals -->
@include('partials.modals.code-generator')
@include('partials.modals.code-debugger')
@include('partials.modals.security-analyzer')

@endsection
