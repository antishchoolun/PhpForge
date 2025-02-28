<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
                &copy; {{ date('Y') }} PhpForge. All rights reserved.
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-500 hover:text-gray-900">Terms of Service</a>
                @auth
                    <span class="text-sm text-gray-500">
                        Logged in as: {{ auth()->user()->email }}
                    </span>
                @endauth
            </div>
        </div>
    </div>
</footer>
