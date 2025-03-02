@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-4">AI Code Debugger</h2>
                
                <div class="mb-6">
                    <x-usage-counter class="mb-4" />
                </div>

                <form id="debug-code-form" class="space-y-6">
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Code to Debug</label>
                        <div class="mt-1">
                            <textarea id="code" name="code" rows="8"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono"
                                placeholder="// Paste your PHP code here..."></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="error-description" class="block text-sm font-medium text-gray-700">Error Description (Optional)</label>
                        <div class="mt-1">
                            <textarea id="error-description" name="error" rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Describe any errors or issues you're encountering..."></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Analysis Options</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach([
                                ['security', 'Security Analysis'],
                                ['performance', 'Performance Check'],
                                ['best_practices', 'Best Practices'],
                                ['type_safety', 'Type Safety'],
                                ['memory_leaks', 'Memory Leaks'],
                                ['logic_errors', 'Logic Errors']
                            ] as [$value, $label])
                            <label class="inline-flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="options[]" value="{{ $value }}"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                        {{ in_array($value, ['best_practices', 'logic_errors']) ? 'checked' : '' }}>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Debug Code
                        </button>
                    </div>
                </form>

                <div id="result" class="mt-8 hidden animate__animated">
                    <!-- Analysis Results -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Analysis Results</h3>
                        <div id="analysis-output" class="space-y-4">
                            <!-- Analysis results will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Fixed Code -->
                    <div id="fixed-code-section" class="hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Fixed Code</h3>
                        <div class="relative">
                            <pre id="fixed-code-output" class="p-4 bg-gray-800 text-white rounded-lg overflow-x-auto"></pre>
                            <button onclick="copyFixedCode()" class="absolute top-2 right-2 p-2 bg-white rounded-md hover:bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyFixedCode() {
    const code = document.getElementById('fixed-code-output').textContent;
    navigator.clipboard.writeText(code).then(() => {
        alert('Fixed code copied to clipboard!');
    }).catch(() => {
        alert('Failed to copy code');
    });
}
</script>
@endpush
@endsection
