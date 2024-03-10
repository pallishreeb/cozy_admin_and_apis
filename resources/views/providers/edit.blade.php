@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl text-center font-semibold text-gray-800 mb-6">Edit Provider</h2>
        <form method="POST" action="{{ route('manage_providers.update', $provider->id) }}" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ $provider->name }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" value="{{ $provider->email }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="mobile_number">Mobile Number:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mobile_number" name="mobile_number" value="{{ $provider->mobile_number }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Category:</label>
                <select name="category" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $provider->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="service">Service:</label>
            <select name="service" id="service" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @if(is_null($provider->service_id))
                    <option value="" disabled selected>Choose a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                @else
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $provider->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

            <!-- Add other fields here -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
            </div>
        </form>
    </div>

    <script>
        // JavaScript for updating services based on selected category
        document.getElementById('category').addEventListener('change', function() {
            var categoryId = this.value;
            var serviceSelect = document.getElementById('service');
            // Clear existing options
            serviceSelect.innerHTML = '';
            // Add default option
            var defaultOption = document.createElement('option');
            defaultOption.text = 'Select a service';
            defaultOption.value = '';
            serviceSelect.add(defaultOption);
            // Filter services based on selected category
            @foreach($categories as $category)
                if ({{ $category->id }} == categoryId) {
                    @foreach($category->services as $service)
                        var option = document.createElement('option');
                        option.text = '{{ $service->name }}';
                        option.value = '{{ $service->id }}';
                        serviceSelect.add(option);
                    @endforeach
                }
            @endforeach
        });
    </script>
@endsection
