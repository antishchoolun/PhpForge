<div id="code-generator-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">PHP Code Generator</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('code-generator')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="code-generator-form" class="max-w-2xl mx-auto space-y-8">
                        <input type="hidden" id="language" value="php">
                        
                        <!-- Prompt Input -->
                        <div class="space-y-2">
                            <label for="code-prompt" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Describe what you need in plain language
                            </label>
                            <div class="relative">
                                <textarea id="code-prompt" name="prompt" rows="4" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                                    placeholder="Example: Create a PHP function that connects to a MySQL database and fetches all users from a 'users' table"
                                    required></textarea>
                                <div class="absolute right-3 top-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Framework Selection -->
                        <div class="space-y-2">
                            <label for="framework" class="text-sm font-medium text-gray-700 dark:text-gray-300">Framework/Platform</label>
                            <select id="framework" name="framework" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow
                                text-gray-900 dark:text-gray-100 appearance-none" required>
                                <option value="raw">Raw PHP</option>
                                <option value="laravel">Laravel</option>
                                <option value="symfony">Symfony</option>
                                <option value="wordpress">WordPress</option>
                                <option value="codeigniter">CodeIgniter</option>
                            </select>
                        </div>

                        <!-- Component Type -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Component Type</label>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                @foreach(['Controller', 'Model', 'Service', 'Repository', 'Middleware'] as $component)
                                <label class="relative">
                                    <input type="radio" name="component" value="{{ strtolower($component) }}" 
                                        class="peer absolute opacity-0"
                                        {{ $component === 'Controller' ? 'checked' : '' }}>
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-lg text-center cursor-pointer
                                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20
                                        hover:border-indigo-300 dark:hover:border-indigo-700 transition-all">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $component }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Design Patterns -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Design Patterns to Include</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['crud', 'CRUD Operations'],
                                    ['repository', 'Repository Pattern'],
                                    ['service', 'Service Layer'],
                                    ['factory', 'Factory Pattern'],
                                    ['dependency', 'Dependency Injection']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="patterns[]" value="{{ $value }}"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- PHP Version -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">PHP Version Features</label>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                                @foreach([
                                    ['7.4', 'Typed Properties'],
                                    ['8.0', 'Constructor Props'],
                                    ['8.1', 'Enums & More'],
                                    ['8.2', 'Readonly Classes']
                                ] as [$version, $feature])
                                <label class="relative group">
                                    <input type="radio" name="php_version" value="{{ $version }}" 
                                        class="peer absolute opacity-0"
                                        {{ $version === '8.1' ? 'checked' : '' }}>
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer
                                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20
                                        group-hover:border-indigo-300 dark:group-hover:border-indigo-700 transition-all">
                                        <div class="font-bold text-xl text-indigo-600 dark:text-indigo-400">{{ $version }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $feature }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Additional Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Additional Options</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach([
                                    ['comments', 'Include comments'],
                                    ['error_handling', 'Error handling'],
                                    ['psr12', 'PSR-12 compliance'],
                                    ['type_hints', 'Type hinting']
                                ] as [$value, $label])
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="options[]" value="{{ $value }}"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                        {{ in_array($value, ['comments', 'error_handling']) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" id="generate-code-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Generate Code
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="code-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Code Area -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="generated-code"
                                download-name="generated-code"
                                download-ext=".php"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <pre class="min-h-full p-6 bg-gray-900"><code id="generated-code" class="language-php text-gray-100"></code></pre>
                            </div>
                        </div>

                        <!-- Analysis Panel -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    AI Analysis
                                </h3>
                            </div>
                            <div class="console-content p-4 max-h-60 overflow-y-auto custom-scrollbar space-y-3">
                                <!-- Analysis content will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>