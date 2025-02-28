@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h1 class="text-2xl font-semibold mb-4">{{ __('Dashboard') }}</h1>
            <p>{{ __("Welcome back! You're logged in.") }}</p>
        </div>
    </div>
@endsection
