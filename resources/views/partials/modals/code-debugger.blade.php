<div id="code-debugger-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">AI Code Debugger</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('code-debugger')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="code-debugger-form" class="max-w-2xl mx-auto space-y-8">
                        <!-- Code Input -->
                        <div class="space-y-2">
                            <label for="code-input" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Paste your code here
                            </label>
                            <div class="relative">
                                <textarea id="code-input" name="code" rows="12" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100 font-mono"
                                    placeholder="// Paste your PHP code here for analysis..."
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Error Description -->
                        <div class="space-y-2">
                            <label for="error-description" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Error Description (Optional)
                            </label>
                            <div class="relative">
                                <textarea id="error-description" name="error" rows="3" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100"
                                    placeholder="Describe the error you're encountering (stack trace, error message, or observed behavior)"></textarea>
                            </div>
                        </div>

                        <!-- Analysis Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Analysis Options</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['security', 'Security Analysis'],
                                    ['performance', 'Performance Check'],
                                    ['best_practices', 'Best Practices'],
                                    ['type_safety', 'Type Safety'],
                                    ['memory_leaks', 'Memory Leaks'],
                                    ['logic_errors', 'Logic Errors']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="options[]" value="{{ $value }}"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                            {{ in_array($value, ['best_practices', 'logic_errors']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" id="debug-code-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Analyze Code
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="debug-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Analysis Results -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="analysis-result"
                                download-name="debug-analysis"
                                download-ext=".txt"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <div id="analysis-result" class="p-6 space-y-6">
                                    <!-- Analysis content will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Fixed Code Preview -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Fixed Code Preview
                                </h3>
                            </div>
                            <div class="p-4 max-h-60 overflow-y-auto custom-scrollbar">
                                <pre><code id="fixed-code" class="language-php"></code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantum Loader -->
    <div x-data="{ show: false }" x-show="show" x-on:analyzing-code.window="show = true" x-on:analysis-complete.window="show = false">
        <x-quantum-loader message="AI is analyzing your code..." />
    </div>
</div>
