@extends('layouts.app')

@section('title', 'Code Generator')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Code Generator</h1>
        
        <form id="codeGeneratorForm" class="space-y-6">
            @csrf
            
            <div>
                <label for="prompt" class="block text-sm font-medium text-gray-700">
                    What would you like to generate?
                </label>
                <div class="mt-1">
                    <textarea
                        id="prompt"
                        name="prompt"
                        rows="4"
                        class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md"
                        placeholder="Describe the code you want to generate..."
                        required
                    ></textarea>
                </div>
            </div>

            <div>
                <label for="language" class="block text-sm font-medium text-gray-700">
                    Programming Language
                </label>
                <select
                    id="language"
                    name="language"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                >
                    <option value="php">PHP</option>
                    <option value="javascript">JavaScript</option>
                    <option value="python">Python</option>
                    <option value="java">Java</option>
                    <option value="cpp">C++</option>
                    <option value="csharp">C#</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Generate Code
                </button>
            </div>
        </form>

        <div id="resultSection" class="mt-8 hidden">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Generated Code</h2>
            <div class="relative">
                <pre id="codeOutput" class="bg-gray-50 rounded-lg p-4 overflow-x-auto text-sm"></pre>
                <button
                    onclick="copyToClipboard()"
                    class="absolute top-2 right-2 px-3 py-1 text-sm text-gray-600 hover:text-gray-900 bg-white rounded border shadow-sm"
                >
                    Copy
                </button>
            </div>
        </div>

        <div id="errorSection" class="mt-8 hidden">
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <div id="errorMessage" class="mt-2 text-sm text-red-700"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('codeGeneratorForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const resultSection = document.getElementById('resultSection');
    const errorSection = document.getElementById('errorSection');
    const codeOutput = document.getElementById('codeOutput');
    
    // Update button state
    submitButton.disabled = true;
    submitButton.innerHTML = 'Generating...';
    
    try {
        const response = await fetch('{{ route("tools.code-generator.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                prompt: form.prompt.value,
                language: form.language.value
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            codeOutput.textContent = data.code;
            resultSection.classList.remove('hidden');
            errorSection.classList.add('hidden');
        } else {
            document.getElementById('errorMessage').textContent = data.error;
            errorSection.classList.remove('hidden');
            resultSection.classList.add('hidden');
        }
    } catch (error) {
        document.getElementById('errorMessage').textContent = 'An unexpected error occurred. Please try again.';
        errorSection.classList.remove('hidden');
        resultSection.classList.add('hidden');
    }
    
    // Reset button state
    submitButton.disabled = false;
    submitButton.innerHTML = 'Generate Code';
});

function copyToClipboard() {
    const code = document.getElementById('codeOutput').textContent;
    navigator.clipboard.writeText(code).then(() => {
        const copyButton = document.querySelector('#codeOutput + button');
        const originalText = copyButton.textContent;
        copyButton.textContent = 'Copied!';
        setTimeout(() => {
            copyButton.textContent = originalText;
        }, 2000);
    });
}
</script>
@endpush

@push('styles')
<style>
    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endpush