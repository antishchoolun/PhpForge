@extends('layouts.app')

@section('title', 'AI-Powered PHP Tools')

@section('content')
<section class="hero">
    <h1 class="animate__animated animate__fadeIn">PHP Development, <br>Supercharged by AI</h1>
    <p class="animate__animated animate__fadeIn animate__delay-1s">Transform your PHP workflow with our suite of AI-powered tools designed to help you code faster, debug smarter, and build more secure applications.</p>
    <button class="btn btn-primary animate__animated animate__fadeIn animate__delay-2s">Explore Tools</button>
</section>

<div class="tool-cards animate__animated animate__fadeInUp animate__delay-3s">
    <!-- PHP Code Generator -->
    <div class="card floating" style="animation-delay: 0.1s;" onclick="openModal('code-generator')">
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
            <button class="btn btn-primary">Generate Code</button>
        </div>
    </div>

    <!-- AI-Powered Debugging -->
    <div class="card floating" style="animation-delay: 0.2s;" onclick="openModal('debugging')">
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
            <button class="btn btn-primary">Debug Code</button>
        </div>
    </div>

    <!-- Security Analysis Tool -->
    <div class="card floating" style="animation-delay: 0.3s;" onclick="openModal('security')">
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
            <button class="btn btn-primary">Scan Code</button>
        </div>
    </div>

    <!-- Performance Optimization Tool -->
    <div class="card floating" style="animation-delay: 0.4s;" onclick="openModal('performance')">
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
            <button class="btn btn-primary">Optimize Code</button>
        </div>
    </div>

    <!-- Documentation Generator -->
    <div class="card floating" style="animation-delay: 0.5s;" onclick="openModal('documentation')">
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
            <button class="btn btn-primary">Generate Docs</button>
        </div>
    </div>

    <!-- Domain Valuation Tool -->
    <div class="card floating" style="animation-delay: 0.6s;" onclick="openModal('domain-valuation')">
        <div class="card-accent"></div>
        <div class="card-content">
            <span class="feature-tag ai-tag">AI-Powered</span>
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="2" y1="12" x2="22" y2="12"></line>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                </svg>
            </div>
            <h3>Domain Valuation Tool</h3>
            <p>Get accurate valuations for domain names based on AI-powered market analysis.</p>
            <button class="btn btn-primary">Evaluate Domain</button>
        </div>
    </div>
</div>

@include('partials.modals.code-generator')
@endsection