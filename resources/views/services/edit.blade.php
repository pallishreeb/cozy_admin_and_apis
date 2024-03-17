@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex flex-col w-full justify-center items-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Service</h2>
            <!-- Service Edit Form with Category Dropdown -->
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                    <select name="category_id" id="category_id" class="form-select block w-full rounded-md mt-1 p-4 border">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" class="form-input w-full p-4 border rounded-md" value="{{ $service->name }}">
                </div>

                <!-- Existing Images -->
                <div class="mb-4 flex flex-wrap">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="existing_images">Existing Images:</label>
                @if(is_array($service->images))
                    @foreach($service->images as $image)
                        <div class="mr-4 mb-4">
                            <img src="{{ asset($image) }}" class="h-10 w-10 object-cover rounded-full">
                        </div>
                    @endforeach
                @else
                    <p>No images found.</p>
                @endif
            </div>


                <!-- New Images -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_images">New Images:</label>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 rounded-md text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="new_images" name="new_images[]" multiple>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Service</button>
            </form>
        </div>
    </div>
@endsection
