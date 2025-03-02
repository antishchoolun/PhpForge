@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-6">
                <h1 class="text-3xl font-bold mb-8 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">Privacy Policy</h1>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Introduction</h2>
                    <p class="text-gray-600 mb-4">
                        At PhpForge, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Information We Collect</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Personal Information</h3>
                            <ul class="list-disc list-inside text-gray-600">
                                <li>Name and email address when you create an account</li>
                                <li>Profile information you provide</li>
                                <li>Payment information when you subscribe to our services</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-2">Usage Data</h3>
                            <ul class="list-disc list-inside text-gray-600">
                                <li>IP address and browser information</li>
                                <li>Pages you visit on our website</li>
                                <li>Time spent on each page</li>
                                <li>Features and tools you use</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">How We Use Your Information</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>We use the collected information for various purposes:</p>
                        <ul class="list-disc list-inside ml-4">
                            <li>To provide and maintain our services</li>
                            <li>To notify you about changes to our services</li>
                            <li>To provide customer support</li>
                            <li>To gather analysis or valuable information to improve our services</li>
                            <li>To monitor the usage of our services</li>
                            <li>To detect, prevent and address technical issues</li>
                        </ul>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Data Security</h2>
                    <p class="text-gray-600 mb-4">
                        We value your trust in providing us your personal information and strive to use commercially acceptable means of protecting it. However, no method of transmission over the internet or electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Cookies</h2>
                    <p class="text-gray-600 mb-4">
                        We use cookies and similar tracking technologies to track activity on our service and hold certain information. Cookies are files with small amounts of data which may include an anonymous unique identifier.
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <p class="text-blue-700">You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our service.</p>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Third-Party Services</h2>
                    <p class="text-gray-600 mb-4">
                        We may employ third-party companies and individuals to facilitate our service, provide service-related services, or assist us in analyzing how our service is used. These third parties have access to your personal data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Changes to This Policy</h2>
                    <p class="text-gray-600 mb-4">
                        We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date below.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
                    <p class="text-gray-600 mb-4">
                        If you have any questions about this Privacy Policy, please contact us:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4">
                        <li>By email: privacy@phpforge.com</li>
                        <li>Through our contact form on the website</li>
                    </ul>
                </section>

                <footer class="mt-12 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Last Updated: March 26, 2021</p>
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
