<div id="security-analyzer-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-orange-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Security Analysis Tool</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('security-analyzer')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="security-analyzer-form" class="max-w-2xl mx-auto space-y-8">
                        <!-- Code Input -->
                        <div class="space-y-2">
                            <label for="code-input" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Code to Analyze
                            </label>
                            <div class="relative">
                                <textarea id="code-input" name="code" rows="12" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100 font-mono"
                                    placeholder="// Paste your PHP code here for security analysis..."
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Security Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Security Checks</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['sql_injection', 'SQL Injection'],
                                    ['xss', 'Cross-Site Scripting (XSS)'],
                                    ['csrf', 'CSRF Vulnerabilities'],
                                    ['file_security', 'File System Security'],
                                    ['input_validation', 'Input Validation'],
                                    ['authentication', 'Authentication Checks'],
                                    ['session_security', 'Session Security'],
                                    ['encryption', 'Encryption Usage'],
                                    ['dependency_check', 'Dependency Analysis'],
                                    ['api_security', 'API Security']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="checks[]" value="{{ $value }}"
                                            class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                            {{ in_array($value, ['sql_injection', 'xss', 'input_validation']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Risk Level -->
                        <div class="space-y-2">
                            <label for="risk-level" class="text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Risk Level to Report</label>
                            <select id="risk-level" name="risk_level" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-shadow
                                text-gray-900 dark:text-gray-100">
                                <option value="info">All (Including Information)</option>
                                <option value="low">Low Risk and Above</option>
                                <option value="medium" selected>Medium Risk and Above</option>
                                <option value="high">High Risk Only</option>
                            </select>
                        </div>

                        <button type="submit" id="analyze-security-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Analyze Security
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="security-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Results Area -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="security-report"
                                download-name="security-report"
                                download-ext=".txt"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <div id="security-report" class="p-6 space-y-6">
                                    <!-- Security analysis results will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary Panel -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4">
                                <div id="security-summary" class="grid grid-cols-4 gap-4 text-center">
                                    <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20">
                                        <div class="text-2xl font-bold text-red-600 dark:text-red-400" id="high-risk-count">0</div>
                                        <div class="text-sm text-red-800 dark:text-red-300">High Risk</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20">
                                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="medium-risk-count">0</div>
                                        <div class="text-sm text-orange-800 dark:text-orange-300">Medium Risk</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400" id="low-risk-count">0</div>
                                        <div class="text-sm text-yellow-800 dark:text-yellow-300">Low Risk</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="info-count">0</div>
                                        <div class="text-sm text-blue-800 dark:text-blue-300">Info</div>
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
    <div x-data="{ show: false }" x-show="show" x-on:analyzing-security.window="show = true" x-on:analysis-complete.window="show = false">
        <x-quantum-loader message="Running security analysis..." />
    </div>
</div>
