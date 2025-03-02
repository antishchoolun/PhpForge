<div id="performance-optimizer-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Performance Optimization Tool</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('performance-optimizer')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="performance-optimizer-form" class="max-w-2xl mx-auto space-y-8" autocomplete="off" spellcheck="false">
                        <!-- Code Input -->
                        <div class="space-y-2">
                            <label for="code-input" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Code to Optimize
                            </label>
                            <div class="relative">
                                <textarea id="code-input" name="code" rows="12" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100 font-mono"
                                    placeholder="// Paste your PHP code here for performance analysis..."
                                    required
                                    onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
                                    data-gramm_editor="false"></textarea>
                            </div>
                        </div>

                        <!-- Optimization Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Optimization Focus</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['memory_usage', 'Memory Usage'],
                                    ['cpu_time', 'CPU Time'],
                                    ['database_queries', 'Database Queries'],
                                    ['caching_strategies', 'Caching Strategies'],
                                    ['algorithm_complexity', 'Algorithm Complexity'],
                                    ['data_structures', 'Data Structures'],
                                    ['io_operations', 'I/O Operations'],
                                    ['network_calls', 'Network Calls'],
                                    ['code_structure', 'Code Structure'],
                                    ['resource_management', 'Resource Management']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="optimizations[]" value="{{ $value }}"
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                            {{ in_array($value, ['memory_usage', 'cpu_time', 'database_queries']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Environment Context -->
                        <div class="space-y-2">
                            <label for="environment" class="text-sm font-medium text-gray-700 dark:text-gray-300">Environment Context</label>
                            <select id="environment" name="environment" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-shadow
                                text-gray-900 dark:text-gray-100">
                                <option value="production">Production (High Traffic)</option>
                                <option value="staging" selected>Staging (Testing)</option>
                                <option value="development">Development (Local)</option>
                            </select>
                        </div>

                        <button type="submit" id="analyze-performance-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Analyze Performance
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="performance-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Results Area -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="performance-report"
                                download-name="performance-report"
                                download-ext=".txt"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <div id="performance-report" class="p-6 space-y-6">
                                    <!-- Performance analysis results will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary Panel -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4">
                                <div id="performance-summary" class="grid grid-cols-4 gap-4 text-center">
                                    <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20">
                                        <div class="text-2xl font-bold text-red-600 dark:text-red-400" id="critical-issues">0</div>
                                        <div class="text-sm text-red-800 dark:text-red-300">Critical</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20">
                                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="major-issues">0</div>
                                        <div class="text-sm text-orange-800 dark:text-orange-300">Major</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400" id="minor-issues">0</div>
                                        <div class="text-sm text-yellow-800 dark:text-yellow-300">Minor</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900/20">
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="optimizations">0</div>
                                        <div class="text-sm text-green-800 dark:text-green-300">Optimizations</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantum Loader -->
    <div x-data="{ show: false }" x-show="show" x-on:analyzing-performance.window="show = true" x-on:analysis-complete.window="show = false">
        <x-quantum-loader message="Analyzing code performance..." />
    </div>
</div>
