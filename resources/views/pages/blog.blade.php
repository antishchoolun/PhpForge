@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold mb-4 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">PhpForge Blog</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay up to date with the latest PHP development tips, tutorials, and PhpForge product updates.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Categories -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    <ul class="space-y-3">
                        @foreach($categories as $category => $count)
                            <li class="flex items-center justify-between">
                                <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">{{ $category }}</a>
                                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="bg-gradient-to-br from-indigo-50 to-pink-50 p-6 rounded-lg border border-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-600 text-sm mb-4">Get the latest articles and updates delivered to your inbox.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <input type="email" name="email" required placeholder="Enter your email" 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                            <button type="submit" 
                                class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Blog Posts -->
            <div class="lg:col-span-3">
                <div class="grid gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $post['category'] }}
                                    </span>
                                    <span>{{ $post['date'] }}</span>
                                    <span>{{ $post['read_time'] }}</span>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900 mb-2">
                                    <a href="{{ route('blog.show', $post['slug']) }}" class="hover:text-indigo-600 transition-colors">
                                        {{ $post['title'] }}
                                    </a>
                                </h2>

                                <p class="text-gray-600 mb-4">{{ $post['excerpt'] }}</p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500">
                                                <span class="text-sm font-medium leading-none text-white">
                                                    {{ substr($post['author'], 0, 1) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="text-sm">
                                            <p class="text-gray-900 font-medium">{{ $post['author'] }}</p>
                                        </div>
                                    </div>

                                    <a href="{{ route('blog.show', $post['slug']) }}" 
                                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                        Read more
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination (static for now) -->
                <div class="mt-8 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-indigo-600 hover:bg-gray-50">
                            1
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-50 text-sm font-medium text-gray-700">
                            2
                        </span>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            3
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            Next
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
