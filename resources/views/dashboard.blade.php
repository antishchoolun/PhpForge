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

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('tools.generate') }}" 
                           class="block p-6 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                            <h4 class="text-lg font-semibold text-indigo-900">Code Generator</h4>
                            <p class="text-indigo-700">Generate PHP code with AI assistance</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <h4 class="text-lg font-semibold text-gray-900">Profile Settings</h4>
                            <p class="text-gray-700">Update your account preferences</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
