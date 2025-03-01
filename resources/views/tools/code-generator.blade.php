@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-4">Code Generator</h2>
                
                <div class="mb-6">
                    <x-usage-counter class="mb-4" />
                </div>

                <form id="generateForm" class="space-y-6">
                    <div>
                        <label for="prompt" class="block text-sm font-medium text-gray-700">What would you like to generate?</label>
                        <div class="mt-1">
                            <textarea id="prompt" name="prompt" rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Example: Create a PHP class for handling file uploads with validation"></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                        <select id="language" name="language"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="php">PHP</option>
                            <option value="sql">SQL</option>
                            <option value="html">HTML</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Generate Code
                        </button>
                    </div>
                </form>

                <div id="result" class="mt-8 hidden animate__animated">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Generated Code</h3>
                    <div class="relative">
                        <pre id="codeOutput" class="p-4 bg-gray-800 text-white rounded-lg overflow-x-auto"></pre>
                        <button onclick="copyCode()" class="absolute top-2 right-2 p-2 bg-white rounded-md hover:bg-gray-100">
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

@push('scripts')
<script>
document.getElementById('generateForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = 'Generating...';

    try {
        const response = await fetch('{{ route("tools.generate.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                prompt: document.getElementById('prompt').value,
                language: document.getElementById('language').value
            })
        });

        const data = await response.json();

        if (response.ok) {
            const resultDiv = document.getElementById('result');
            const codeOutput = document.getElementById('codeOutput');
            resultDiv.classList.remove('hidden');
            
            // Set content and animate
            codeOutput.textContent = data.code;
            resultDiv.classList.add('animate__fadeInUp', 'animate__faster');
            
            // Remove animation classes after animation completes
            resultDiv.addEventListener('animationend', () => {
                resultDiv.classList.remove('animate__fadeInUp', 'animate__faster');
            }, { once: true });
        } else {
            alert(data.message || 'An error occurred');
        }
    } catch (error) {
        alert('An error occurred while generating code');
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Generate Code';
    }
});

function copyCode() {
    const code = document.getElementById('codeOutput').textContent;
    navigator.clipboard.writeText(code).then(() => {
        alert('Code copied to clipboard!');
    }).catch(() => {
        alert('Failed to copy code');
    });
}
</script>
@endpush
@endsection
