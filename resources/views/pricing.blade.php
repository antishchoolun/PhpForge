@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Simple, Free Pricing
            </h2>
            <p class="mt-4 text-lg text-gray-600">
                All features are available for free. Just register to unlock unlimited access.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Guest Plan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 relative border-2 border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Guest Access</h3>
                <p class="text-gray-600 mb-6">Perfect for trying out our tools</p>
                
                <div class="text-4xl font-bold text-gray-900 mb-6">
                    Free
                    <span class="text-base font-normal text-gray-500">/forever</span>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        5 requests per day
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Access to all tools
                    </li>
                    <li class="flex items-center text-gray-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        No account required
                    </li>
                </ul>

                <a href="{{ route('tools.generate') }}" 
                   class="block w-full text-center bg-white border-2 border-indigo-600 text-indigo-600 rounded-lg px-6 py-3 font-medium hover:bg-indigo-50 transition">
                    Try Now
                </a>
            </div>

            <!-- Registered Plan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 relative border-2 border-indigo-600">
                <div class="absolute top-0 right-8 transform -translate-y-1/2">
                    <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                        Recommended
                    </span>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4">Registered User</h3>
                <p class="text-gray-600 mb-6">For developers who need unlimited access</p>
                
                <div class="text-4xl font-bold text-gray-900 mb-6">
                    Free
                    <span class="text-base font-normal text-gray-500">/forever</span>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Unlimited requests
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Access to all tools
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Personal dashboard
                    </li>
                </ul>

                <a href="{{ route('register') }}" 
                   class="block w-full text-center bg-indigo-600 text-white rounded-lg px-6 py-3 font-medium hover:bg-indigo-700 transition">
                    Register Now
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
