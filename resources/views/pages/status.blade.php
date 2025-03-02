@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold mb-4 bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent">System Status</h1>
            <p class="text-gray-600">Current status of PhpForge services and infrastructure</p>
            <p class="text-sm text-gray-500 mt-2">Last updated: {{ $lastUpdated }}</p>
        </div>

        <!-- System Status Overview -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-6">Core Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($systemStatus as $key => $service)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div @class([
                                    'w-3 h-3 rounded-full',
                                    'bg-green-500' => $service['status'] === 'operational',
                                    'bg-yellow-500' => $service['status'] === 'degraded',
                                    'bg-red-500' => $service['status'] === 'issue',
                                ])></div>
                                <h3 class="font-semibold text-lg">{{ $service['name'] }}</h3>
                            </div>
                            <span @class([
                                'text-sm font-medium px-3 py-1 rounded-full',
                                'bg-green-100 text-green-800' => $service['status'] === 'operational',
                                'bg-yellow-100 text-yellow-800' => $service['status'] === 'degraded',
                                'bg-red-100 text-red-800' => $service['status'] === 'issue',
                            ])>
                                {{ ucfirst($service['status']) }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $service['description'] }}</p>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Uptime: {{ $service['uptime'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Service Performance -->
        <div>
            <h2 class="text-2xl font-semibold mb-6">Tool Performance</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-4 text-sm font-semibold text-gray-900">Service</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-900">Requests Today</th>
                                <th class="px-6 py-4 text-sm font-semibold text-gray-900">Avg Response Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($serviceHealth as $key => $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div @class([
                                                'w-2 h-2 rounded-full',
                                                'bg-green-500' => $service['status'] === 'operational',
                                                'bg-yellow-500' => $service['status'] === 'degraded',
                                                'bg-red-500' => $service['status'] === 'issue',
                                            ])></div>
                                            <span class="font-medium">{{ $service['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span @class([
                                            'text-sm font-medium px-2 py-1 rounded-full',
                                            'bg-green-100 text-green-800' => $service['status'] === 'operational',
                                            'bg-yellow-100 text-yellow-800' => $service['status'] === 'degraded',
                                            'bg-red-100 text-red-800' => $service['status'] === 'issue',
                                        ])>
                                            {{ ucfirst($service['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ number_format($service['requests_today']) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $service['avg_response_time'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">Having issues or need help?</p>
            <a href="{{ route('support') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium">
                Contact Support
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Auto Refresh Notice -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">This page auto-refreshes every 60 seconds</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    setTimeout(function() {
        window.location.reload();
    }, 60000);
</script>
@endpush
@endsection
