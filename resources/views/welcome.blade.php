@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold text-center">Welcome to Cozy Admin</h1>
        <p class="mt-4 text-lg text-center text-gray-700">Your one-stop solution for managing users, providers, categories, services, and discounts.</p>
    </div>
    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- User Management -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"><a href="{{ route('manage_users.index') }}">User Management</a></h2>
                <p>Total Users: {{ $userCount }}</p>
            </div>

            <!-- Provider Management -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"><a href="{{ route('manage_providers.index') }}">Provider Management</a></h2>
                <p>Total Providers: {{ $providerCount }}</p>
            </div>

            <!-- Category Management -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"><a href="{{ route('categories.index') }}">Category Management</a></h2>
                <p>Total Categories: {{ $categoryCount }}</p>
                
            </div>

            <!-- Service Management -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"> <a href="{{ route('services.index') }}">Service Management</a></h2>
                <p>Total Services: {{ $serviceCount }}</p>
            </div>

            <!-- Discount Management -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"> <a href="{{ route('manage_discounts.index') }}" >Discount Management</a></h2>
                <p>Total Discounts: {{ $discountCount }}</p>
            </div>
             <!-- Discount Management -->
             <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4"> <a href="{{ route('bookings.index') }}" >Bookings Management</a></h2>
                <p>Total Bookings: {{ $bookingCount }}</p>
            </div>

            <!-- Update profile -->
            <div class="bg-white p-4 rounded shadow-md">
                <h2 class="text-lg font-semibold mb-4">Update Profile</h2>
                <p>Here you can update your profile information</p>
                <a href="{{ route('admin.profile.update') }}" class="block mt-2 text-sm font-semibold text-indigo-600 hover:underline">Update Profile</a>
            </div>
        
        </div>
    </div>
@endsection
