@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-6">
                <h1 class="text-3xl font-bold mb-8 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Cookie Policy</h1>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">What Are Cookies</h2>
                    <p class="text-gray-600 mb-4">
                        Cookies are small text files that are placed on your computer or mobile device when you visit our website. They are widely used to make websites work more efficiently and provide useful information to website owners.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">How We Use Cookies</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Essential Cookies</h3>
                            <p class="text-gray-600 mb-2">These cookies are necessary for the website to function properly. They include:</p>
                            <ul class="list-disc list-inside text-gray-600 ml-4">
                                <li>Session cookies for maintaining your login status</li>
                                <li>CSRF token cookies for security</li>
                                <li>Preference cookies for remembering your settings</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Analytics Cookies</h3>
                            <p class="text-gray-600 mb-2">We use these cookies to understand how visitors use our website:</p>
                            <ul class="list-disc list-inside text-gray-600 ml-4">
                                <li>Page view statistics</li>
                                <li>User navigation patterns</li>
                                <li>Feature usage analytics</li>
                            </ul>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Performance Cookies</h3>
                            <p class="text-gray-600 mb-2">These cookies help us optimize website performance:</p>
                            <ul class="list-disc list-inside text-gray-600 ml-4">
                                <li>Load balancing session cookies</li>
                                <li>Response time monitoring</li>
                                <li>Error logging</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Cookie Duration</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>Cookies on our website fall into two categories based on duration:</p>
                        <ul class="list-disc list-inside ml-4">
                            <li>Session Cookies: These are temporary and expire when you close your browser</li>
                            <li>Persistent Cookies: These remain until they expire or you delete them</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Managing Cookies</h2>
                    <p class="text-gray-600 mb-4">
                        Most web browsers allow you to control cookies through their settings. You can:
                    </p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <ul class="list-disc list-inside text-gray-600">
                            <li>View cookies stored on your computer</li>
                            <li>Block or allow cookies by default</li>
                            <li>Delete existing cookies</li>
                            <li>Set preferences for different websites</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-4">
                        <p class="text-blue-700">Please note that blocking cookies may affect the functionality of our website and services.</p>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Third-Party Cookies</h2>
                    <p class="text-gray-600 mb-4">
                        Some features and services on our website use cookies from third-party providers:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4">
                        <li>Google Analytics for website usage statistics</li>
                        <li>Payment processors for handling transactions</li>
                        <li>Social media integration features</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Updates to This Policy</h2>
                    <p class="text-gray-600 mb-4">
                        We may update this Cookie Policy to reflect changes in our practices or for operational, legal, or regulatory reasons. Any changes will be posted on this page with an updated revision date.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
                    <p class="text-gray-600 mb-4">
                        If you have questions about our use of cookies, please contact us:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4">
                        <li>By email: cookies@phpforge.com</li>
                        <li>Through our contact form on the website</li>
                    </ul>
                </section>

                <footer class="mt-12 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Last Updated: March 15, 2021</p>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
