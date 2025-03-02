@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-8">Documentation</h1>

                <!-- Quick Navigation -->
                <div class="mb-12 p-4 bg-gray-50 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4">Quick Navigation</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="#getting-started" class="text-blue-600 hover:text-blue-800">Getting Started</a>
                        <a href="#code-generator" class="text-blue-600 hover:text-blue-800">Code Generator</a>
                        <a href="#code-debugger" class="text-blue-600 hover:text-blue-800">Code Debugger</a>
                        <a href="#security-analyzer" class="text-blue-600 hover:text-blue-800">Security Analyzer</a>
                        <a href="#performance-optimizer" class="text-blue-600 hover:text-blue-800">Performance Optimizer</a>
                        <a href="#documentation-generator" class="text-blue-600 hover:text-blue-800">Documentation Generator</a>
                    </div>
                </div>

                <!-- Getting Started -->
                <section id="getting-started" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Getting Started</h2>
                    <p class="mb-4">Welcome to PhpForge, your comprehensive PHP development toolkit. This documentation will guide you through using our suite of tools effectively.</p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="font-semibold">Before you begin:</p>
                        <ul class="list-disc list-inside ml-4 mt-2">
                            <li>Create an account or log in</li>
                            <li>Familiarize yourself with the dashboard</li>
                            <li>Check your usage limits in your profile</li>
                        </ul>
                    </div>
                </section>

                <!-- Code Generator -->
                <section id="code-generator" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Code Generator</h2>
                    <p class="mb-4">Generate high-quality PHP code snippets, classes, and entire components.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Features:</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>Auto-generate PHP classes</li>
                                <li>Create CRUD operations</li>
                                <li>Generate API endpoints</li>
                                <li>Build form validation</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Usage Example:</h3>
                            <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto">
$generator->createModel('User')
    ->withAttributes(['name', 'email'])
    ->addTimestamps()
    ->generate();</pre>
                        </div>
                    </div>
                </section>

                <!-- Code Debugger -->
                <section id="code-debugger" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Code Debugger</h2>
                    <p class="mb-4">Advanced debugging tools to identify and fix issues in your PHP code.</p>
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                        <h3 class="font-semibold mb-2">Key Features:</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Syntax error detection</li>
                            <li>Logic flow analysis</li>
                            <li>Variable tracking</li>
                            <li>Performance bottleneck identification</li>
                        </ul>
                    </div>
                </section>

                <!-- Security Analyzer -->
                <section id="security-analyzer" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Security Analyzer</h2>
                    <p class="mb-4">Analyze your code for security vulnerabilities and potential risks.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Security Checks:</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>SQL injection vulnerabilities</li>
                                <li>Cross-site scripting (XSS)</li>
                                <li>CSRF protection</li>
                                <li>File upload vulnerabilities</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Best Practices:</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>Input validation</li>
                                <li>Output encoding</li>
                                <li>Session security</li>
                                <li>Password hashing</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Performance Optimizer -->
                <section id="performance-optimizer" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Performance Optimizer</h2>
                    <p class="mb-4">Optimize your PHP applications for better performance and efficiency.</p>
                    <div class="bg-purple-50 p-4 rounded-lg mb-4">
                        <h3 class="font-semibold mb-2">Optimization Areas:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <ul class="list-disc list-inside space-y-2">
                                <li>Database query optimization</li>
                                <li>Code execution speed</li>
                                <li>Memory usage</li>
                            </ul>
                            <ul class="list-disc list-inside space-y-2">
                                <li>Cache implementation</li>
                                <li>Asset optimization</li>
                                <li>Load time reduction</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Documentation Generator -->
                <section id="documentation-generator" class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Documentation Generator</h2>
                    <p class="mb-4">Automatically generate comprehensive documentation for your PHP projects.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Documentation Types:</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>API documentation</li>
                                <li>Class documentation</li>
                                <li>Method documentation</li>
                                <li>Code examples</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Output Formats:</h3>
                            <ul class="list-disc list-inside space-y-2">
                                <li>HTML documentation</li>
                                <li>Markdown files</li>
                                <li>PDF exports</li>
                                <li>Interactive API docs</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Additional Resources -->
                <section class="mb-12">
                    <h2 class="text-2xl font-bold mb-4">Additional Resources</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Support</h3>
                            <p>Need help? Contact our support team or visit our community forums.</p>
                        </div>
                        <div class="border p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Updates</h3>
                            <p>Stay updated with our latest features and improvements.</p>
                        </div>
                        <div class="border p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Community</h3>
                            <p>Join our developer community to share insights and get help.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
