<div id="domain-valuation-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Domain Valuation Tool</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('domain-valuation')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="domain-valuation-form" class="max-w-2xl mx-auto space-y-8" autocomplete="off">
                        <!-- Domain Input -->
                        <div class="space-y-2">
                            <label for="domain-input" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Domain Name
                            </label>
                            <div class="relative">
                                <input type="text" id="domain-input" name="domain" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100"
                                    placeholder="example.com"
                                    pattern="^([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$"
                                    required>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Enter a domain name without http:// or www
                            </p>
                        </div>

                        <!-- Analysis Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Valuation Factors</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['market_trends', 'Market Trends Analysis'],
                                    ['seo_metrics', 'SEO & Traffic Value'],
                                    ['brand_potential', 'Brand Potential'],
                                    ['industry_relevance', 'Industry Relevance'],
                                    ['length_analysis', 'Domain Length & Type'],
                                    ['keyword_value', 'Keyword Value'],
                                    ['sales_history', 'Sales History'],
                                    ['extensions', 'TLD Variations'],
                                    ['trademark_check', 'Trademark Verification'],
                                    ['commerce_potential', 'E-commerce Potential']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="factors[]" value="{{ $value }}"
                                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                            {{ in_array($value, ['market_trends', 'seo_metrics', 'brand_potential', 'keyword_value']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Analysis Settings -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Market Category -->
                            <div class="space-y-2">
                                <label for="market-category" class="text-sm font-medium text-gray-700 dark:text-gray-300">Market Category</label>
                                <select id="market-category" name="category" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100">
                                    <option value="general">General</option>
                                    <option value="technology">Technology</option>
                                    <option value="business">Business</option>
                                    <option value="entertainment">Entertainment</option>
                                    <option value="e-commerce">E-commerce</option>
                                    <option value="health">Health & Wellness</option>
                                    <option value="finance">Finance</option>
                                    <option value="education">Education</option>
                                </select>
                            </div>

                            <!-- Valuation Currency -->
                            <div class="space-y-2">
                                <label for="currency" class="text-sm font-medium text-gray-700 dark:text-gray-300">Valuation Currency</label>
                                <select id="currency" name="currency" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100">
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="AED">AED - UAE Dirham</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="analyze-domain-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Analyze Domain
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="valuation-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Results Area -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="valuation-report"
                                download-name="domain-valuation"
                                download-ext=".txt"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <div id="valuation-report" class="p-6 space-y-6">
                                    <!-- Valuation results will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary Panel -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4">
                                <div id="valuation-summary" class="grid grid-cols-4 gap-4 text-center">
                                    <div class="p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400" id="estimated-value">$0</div>
                                        <div class="text-sm text-purple-800 dark:text-purple-300">Estimated Value</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-pink-50 dark:bg-pink-900/20">
                                        <div class="text-2xl font-bold text-pink-600 dark:text-pink-400" id="market-demand">0/10</div>
                                        <div class="text-sm text-pink-800 dark:text-pink-300">Market Demand</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/20">
                                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400" id="development-potential">0/10</div>
                                        <div class="text-sm text-indigo-800 dark:text-indigo-300">Development Potential</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="brand-score">0/10</div>
                                        <div class="text-sm text-blue-800 dark:text-blue-300">Brand Score</div>
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
    <div x-data="{ show: false }" x-show="show" x-on:analyzing-domain.window="show = true" x-on:analysis-complete.window="show = false">
        <x-quantum-loader message="Analyzing domain value..." />
    </div>
</div>
