@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden py-16 sm:py-24">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <x-logo width="200" class="mx-auto mb-8" />
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl mb-8">
                <span class="block">Building the Future of</span>
                <span class="block bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">PHP Development</span>
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 sm:mt-4">
                Empowering developers with AI-driven tools to write better, faster, and more secure PHP code.
            </p>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Our Mission
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        At PhpForge, we're on a mission to revolutionize PHP development by bringing the power of artificial intelligence to every developer's toolkit. We believe that by automating routine tasks and providing intelligent suggestions, we can help developers focus on what truly matters - creating amazing applications.
                    </p>
                    <div class="flex items-center gap-4 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="font-semibold">Powered by Advanced AI</span>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden bg-gradient-to-br from-indigo-500/30 to-pink-500/30 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <!-- Placeholder for mission image -->
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p>Place mission.jpg here</p>
                            <p class="text-sm">Recommended size: 1200x675</p>
                        </div>
                    </div>
                    <!-- Circuit Pattern Overlay -->
                    <svg class="absolute -right-12 -bottom-12 text-indigo-500/10 w-64 h-64" fill="currentColor" viewBox="0 0 100 100">
                        <pattern id="circuit" patternUnits="userSpaceOnUse" width="10" height="10">
                            <path d="M0 0h10v10H0z" fill="none"/>
                            <path d="M0 5h5v1H0zM5 0v5h1V0z" fill="currentColor"/>
                        </pattern>
                        <rect width="100" height="100" fill="url(#circuit)"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-16">
            Our Core Values
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Innovation -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-xl opacity-50 group-hover:opacity-100 blur transition-opacity"></div>
                <div class="relative bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Innovation First</h3>
                    <p class="text-gray-600 dark:text-gray-300">We constantly push the boundaries of what's possible in PHP development with cutting-edge AI technology.</p>
                </div>
            </div>

            <!-- Quality -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-xl opacity-50 group-hover:opacity-100 blur transition-opacity"></div>
                <div class="relative bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quality Driven</h3>
                    <p class="text-gray-600 dark:text-gray-300">Our tools don't just generate code; they ensure it meets the highest standards of quality and security.</p>
                </div>
            </div>

            <!-- Community -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-xl opacity-50 group-hover:opacity-100 blur transition-opacity"></div>
                <div class="relative bg-white dark:bg-gray-800 p-8 rounded-xl shadow-xl">
                    <div class="w-12 h-12 bg-indigo-500/10 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Community Focused</h3>
                    <p class="text-gray-600 dark:text-gray-300">We believe in the power of the PHP community and strive to make advanced tools accessible to everyone.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-16">
                Meet Our Team
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-transform hover:-translate-y-2">
                    <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-indigo-500/30 to-pink-500/30 flex items-center justify-center">
                        <!-- Placeholder for team member image -->
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p>Place member1.jpg here</p>
                            <p class="text-sm">Recommended size: 800x1067</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">John Doe</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 mb-4">Founder & CEO</p>
                        <p class="text-gray-600 dark:text-gray-300">10+ years of experience in PHP development and AI integration.</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-transform hover:-translate-y-2">
                    <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-indigo-500/30 to-pink-500/30 flex items-center justify-center">
                        <!-- Placeholder for team member image -->
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p>Place member2.jpg here</p>
                            <p class="text-sm">Recommended size: 800x1067</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Jane Smith</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 mb-4">Lead AI Engineer</p>
                        <p class="text-gray-600 dark:text-gray-300">Expert in machine learning and natural language processing.</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden transition-transform hover:-translate-y-2">
                    <div class="aspect-w-3 aspect-h-4 bg-gradient-to-br from-indigo-500/30 to-pink-500/30 flex items-center justify-center">
                        <!-- Placeholder for team member image -->
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p>Place member3.jpg here</p>
                            <p class="text-sm">Recommended size: 800x1067</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Mike Johnson</h3>
                        <p class="text-indigo-600 dark:text-indigo-400 mb-4">Head of Product</p>
                        <p class="text-gray-600 dark:text-gray-300">Passionate about creating developer-friendly tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">1M+</div>
                <div class="text-gray-600 dark:text-gray-300">Lines of Code Generated</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">50K+</div>
                <div class="text-gray-600 dark:text-gray-300">Happy Developers</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">100+</div>
                <div class="text-gray-600 dark:text-gray-300">Countries Reached</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2">99%</div>
                <div class="text-gray-600 dark:text-gray-300">Satisfaction Rate</div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-pink-600 dark:from-indigo-900 dark:to-pink-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center">
            <h2 class="text-3xl font-bold text-white mb-8">Ready to Transform Your PHP Development?</h2>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 transition-colors">
                Get Started for Free
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection