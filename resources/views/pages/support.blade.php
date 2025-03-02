@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold mb-4 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Support Center</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Get help with PhpForge tools and services. Find answers in our documentation, FAQs, or reach out to our support team.</p>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-indigo-500 transition-colors">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-indigo-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Documentation</h3>
                        <p class="text-gray-600 text-sm">Comprehensive guides and API references</p>
                    </div>
                </div>
                <a href="{{ route('documentation') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-2">
                    View Documentation
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-indigo-500 transition-colors">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-indigo-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">FAQs</h3>
                        <p class="text-gray-600 text-sm">Quick answers to common questions</p>
                    </div>
                </div>
                <button onclick="scrollToFAQ()" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-2">
                    View FAQs
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-indigo-500 transition-colors">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-indigo-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Contact Us</h3>
                        <p class="text-gray-600 text-sm">Get in touch with our support team</p>
                    </div>
                </div>
                <button onclick="scrollToContact()" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-2">
                    Contact Support
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- FAQ Section -->
        <div id="faq" class="mb-16">
            <h2 class="text-2xl font-semibold mb-8 text-center">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center">
                        <span class="font-medium">How do I get started with PhpForge?</span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-6 pb-4">
                        <p class="text-gray-600">Sign up for a free account, verify your email, and you can start using our tools right away. Check our documentation for detailed guides on each tool.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center">
                        <span class="font-medium">What are the subscription limits?</span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-6 pb-4">
                        <p class="text-gray-600">Free accounts get 5 requests per day. Premium subscriptions offer unlimited access to all tools. View our pricing page for detailed plan comparisons.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center">
                        <span class="font-medium">How secure is my code?</span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-6 pb-4">
                        <p class="text-gray-600">Your code is processed securely and never stored permanently. We use encryption for all transmissions and follow industry best practices for security.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center">
                        <span class="font-medium">Can I cancel my subscription?</span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-6 pb-4">
                        <p class="text-gray-600">Yes, you can cancel your subscription at any time. Your access will continue until the end of your current billing period.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div id="contact" class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-semibold mb-8 text-center">Contact Support</h2>
            
            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('support.contact') }}" method="POST" class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors"
                            value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors"
                        value="{{ old('subject') }}">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea name="message" id="message" rows="6" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function scrollToFAQ() {
        document.getElementById('faq').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToContact() {
        document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endpush
@endsection
