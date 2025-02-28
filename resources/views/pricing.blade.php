@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900">Simple, Free Pricing</h1>
            <p class="mt-4 text-xl text-gray-600">No credit card required. No hidden fees.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 px-4">
            <!-- Guest Plan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-gray-200">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Guest Access</h2>
                    <p class="mt-2 text-gray-600">Try before you register</p>
                    
                    <div class="mt-8">
                        <span class="text-4xl font-bold text-gray-900">Free</span>
                    </div>

                    <ul class="mt-8 space-y-4">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">5 requests per day</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">No registration required</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Access to all tools</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Daily limit reset at midnight UTC</span>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <p class="text-sm text-gray-500">No credit card required</p>
                    </div>
                </div>
            </div>

            <!-- Registered User Plan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-indigo-500">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Registered User</h2>
                    <p class="mt-2 text-gray-600">For developers who need more</p>
                    
                    <div class="mt-8">
                        <span class="text-4xl font-bold text-gray-900">Free</span>
                        <span class="text-gray-600">/forever</span>
                    </div>

                    <ul class="mt-8 space-y-4">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Unlimited requests</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Simple registration</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Access to all tools</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="ml-3">Usage statistics</span>
                        </li>
                    </ul>

                    <div class="mt-8">
                        @guest
                            <a href="{{ route('register') }}" class="block w-full bg-indigo-600 text-white text-center py-3 px-4 rounded-md hover:bg-indigo-700">
                                Register Now
                            </a>
                            <p class="mt-2 text-sm text-gray-500">No credit card required</p>
                        @else
                            <div class="bg-gray-100 rounded-md p-4 text-center">
                                <p class="text-gray-700">You're already registered!</p>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
