<div id="documentation-generator-modal" class="modal">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-content !w-full !h-full !max-w-none !m-0 !p-0 !rounded-none">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center backdrop-blur-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Documentation Generator</h2>
                </div>
                <button class="text-white/70 hover:text-white transition-colors" onclick="closeModal('documentation-generator')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
                <!-- Left Side - Form -->
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6">
                    <form id="documentation-generator-form" class="max-w-2xl mx-auto space-y-8" autocomplete="off" spellcheck="false">
                        <!-- Code Input -->
                        <div class="space-y-2">
                            <label for="code-input" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Code to Document
                            </label>
                            <div class="relative">
                                <textarea id="code-input" name="code" rows="12" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                    focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-shadow
                                    text-gray-900 dark:text-gray-100 font-mono"
                                    placeholder="// Paste your PHP code here to generate documentation..."
                                    required
                                    onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}"
                                    data-gramm_editor="false"></textarea>
                            </div>
                        </div>

                        <!-- Documentation Options -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Documentation Sections</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['function_description', 'Function Descriptions'],
                                    ['parameter_types', 'Parameter Types & Details'],
                                    ['return_values', 'Return Values'],
                                    ['examples', 'Usage Examples'],
                                    ['dependencies', 'Dependencies & Requirements'],
                                    ['exceptions', 'Exceptions & Error Handling'],
                                    ['changelog', 'Changelog & Version Info'],
                                    ['inheritance', 'Class Inheritance Details'],
                                    ['security', 'Security Considerations'],
                                    ['performance', 'Performance Considerations']
                                ] as [$value, $label])
                                <label class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="sections[]" value="{{ $value }}"
                                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                            {{ in_array($value, ['function_description', 'parameter_types', 'return_values', 'examples']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Documentation Style -->
                        <div class="space-y-2">
                            <label for="doc-style" class="text-sm font-medium text-gray-700 dark:text-gray-300">Documentation Style</label>
                            <select id="doc-style" name="style" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-shadow
                                text-gray-900 dark:text-gray-100">
                                <option value="phpdoc">PHPDoc Standard</option>
                                <option value="markdown">Markdown</option>
                                <option value="clean">Clean Text</option>
                                <option value="detailed">Detailed Description</option>
                            </select>
                        </div>

                        <!-- Documentation Format -->
                        <div class="space-y-2">
                            <label for="doc-format" class="text-sm font-medium text-gray-700 dark:text-gray-300">Output Format</label>
                            <select id="doc-format" name="format" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl 
                                focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-shadow
                                text-gray-900 dark:text-gray-100">
                                <option value="inline">Inline Documentation</option>
                                <option value="separate">Separate Documentation File</option>
                                <option value="readme">README Format</option>
                                <option value="wiki">Wiki Format</option>
                            </select>
                        </div>

                        <button type="submit" id="generate-docs-btn" 
                            class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white
                                bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all
                                shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Generate Documentation
                        </button>
                    </form>
                </div>

                <!-- Right Side - Result -->
                <div id="documentation-result" class="hidden lg:w-1/2 bg-gray-100 dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="h-full flex flex-col">
                        <!-- Results Area -->
                        <div class="flex-1 overflow-hidden relative">
                            <!-- Code Actions Component -->
                            <x-code-actions 
                                target-id="documentation-content"
                                download-name="documentation"
                                download-ext=".md"
                                position="top-right"
                            />
                            <div class="h-full overflow-y-auto custom-scrollbar">
                                <div id="documentation-content" class="p-6 space-y-6">
                                    <!-- Documentation content will be dynamically inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Summary Panel -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="p-4">
                                <div id="documentation-summary" class="grid grid-cols-3 gap-4 text-center">
                                    <div class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">
                                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400" id="doc-sections">0</div>
                                        <div class="text-sm text-emerald-800 dark:text-emerald-300">Sections</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-teal-50 dark:bg-teal-900/20">
                                        <div class="text-2xl font-bold text-teal-600 dark:text-teal-400" id="doc-lines">0</div>
                                        <div class="text-sm text-teal-800 dark:text-teal-300">Lines</div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-cyan-50 dark:bg-cyan-900/20">
                                        <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400" id="doc-coverage">0%</div>
                                        <div class="text-sm text-cyan-800 dark:text-cyan-300">Coverage</div>
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
    <div x-data="{ show: false }" x-show="show" x-on:generating-docs.window="show = true" x-on:generation-complete.window="show = false">
        <x-quantum-loader message="Generating documentation..." />
    </div>
</div>
