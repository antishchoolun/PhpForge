@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-6">
                <h1 class="text-3xl font-bold mb-8 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Terms of Service</h1>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">1. Acceptance of Terms</h2>
                    <p class="text-gray-600 mb-4">
                        By accessing and using PhpForge's services, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">2. Services Description</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>PhpForge provides various tools and services for PHP development, including but not limited to:</p>
                        <ul class="list-disc list-inside ml-4">
                            <li>Code generation and automation tools</li>
                            <li>Debugging and optimization features</li>
                            <li>Security analysis tools</li>
                            <li>Documentation generation services</li>
                            <li>Performance optimization tools</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">3. User Accounts</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Account Registration</h3>
                            <ul class="list-disc list-inside text-gray-600">
                                <li>You must provide accurate and complete information</li>
                                <li>You are responsible for maintaining account security</li>
                                <li>You must notify us of any unauthorized access</li>
                                <li>We reserve the right to suspend or terminate accounts</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">4. Service Usage</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>Users agree to:</p>
                        <ul class="list-disc list-inside ml-4">
                            <li>Use services in compliance with all applicable laws</li>
                            <li>Not attempt to circumvent any service limitations</li>
                            <li>Not use services for malicious purposes</li>
                            <li>Not interfere with service operation</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">5. Pricing and Payments</h2>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h3 class="font-semibold mb-2">Subscription Terms</h3>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Subscription fees are billed in advance</li>
                            <li>Refunds are subject to our refund policy</li>
                            <li>We reserve the right to modify pricing with notice</li>
                            <li>Failure to pay may result in service suspension</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">6. Intellectual Property</h2>
                    <p class="text-gray-600 mb-4">
                        All content and services provided by PhpForge are protected by intellectual property laws. Users retain rights to their own code and content but grant us license to use it for service provision.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">You maintain ownership of your code while granting us necessary rights to provide our services.</p>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">7. Limitation of Liability</h2>
                    <p class="text-gray-600 mb-4">
                        PhpForge provides services "as is" and makes no warranties, express or implied. We are not liable for any damages arising from service use or interruption.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">8. Service Modifications</h2>
                    <p class="text-gray-600 mb-4">
                        We reserve the right to modify, suspend, or discontinue any part of our services at any time. We will provide notice of significant changes when possible.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">9. Termination</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>We may terminate or suspend access to our services:</p>
                        <ul class="list-disc list-inside ml-4">
                            <li>For violations of these terms</li>
                            <li>At our discretion with reasonable notice</li>
                            <li>For illegal or harmful activities</li>
                            <li>For non-payment of fees</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">10. Contact Information</h2>
                    <p class="text-gray-600 mb-4">
                        For questions about these Terms of Service, please contact us:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4">
                        <li>By email: admin@phpforge.com</li>
                        <li>Through our contact form on the website</li>
                    </ul>
                </section>

                <footer class="mt-12 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Last Updated: March 6, 2021</p>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
