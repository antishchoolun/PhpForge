@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-4">Welcome Back!</h2>
                
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your Usage Statistics</h3>
                    <p class="text-gray-600">
                        Last used: {{ auth()->user()->last_used_at ? auth()->user()->last_used_at->diffForHumans() : 'Never' }}
                    </p>
                    <p class="text-green-600 mt-2">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        You have unlimited access to all tools
                    </p>
                </div>

                <!-- Tools Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tools</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <x-dashboard-card
                            onClick="openModal('code-generator')"
                            title="Code Generator"
                            description="Generate PHP code with AI assistance"
                        />
                        <x-dashboard-card
                            onClick="openModal('code-debugger')"
                            title="Code Debugger"
                            description="AI-powered code analysis and debugging"
                        />
                        <x-dashboard-card
                            onClick="openModal('security-analyzer')"
                            title="Security Analyzer"
                            description="Scan code for security vulnerabilities"
                        />
                        <x-dashboard-card
                            onClick="openModal('performance-optimizer')"
                            title="Performance Optimizer"
                            description="Optimize code for better performance"
                        />
                        <x-dashboard-card
                            onClick="openModal('documentation-generator')"
                            title="Documentation Generator"
                            description="Generate comprehensive documentation"
                        />
                        <x-dashboard-card
                            onClick="openModal('domain-valuation')"
                            title="Domain Valuation"
                            description="AI-powered domain name valuation"
                        />
                    </div>
                </div>

                <!-- Quick Links Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-dashboard-card
                            href="{{ route('profile.edit') }}"
                            title="Profile Settings"
                            description="Update your account preferences"
                            bgColor="bg-gray-50"
                            hoverColor="hover:bg-gray-100"
                            titleColor="text-gray-900"
                            descriptionColor="text-gray-700"
                        />
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
@include('partials.modals.documentation-generator')
@include('partials.modals.performance-optimizer')
@include('partials.modals.domain-valuation')

@endsection
