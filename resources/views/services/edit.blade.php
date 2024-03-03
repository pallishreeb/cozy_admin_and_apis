@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Service</h2>
        <!-- Service Edit Form with Category Dropdown -->
        <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                <select name="category_id" id="category_id" class="form-select block w-full mt-1">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" class="form-input w-full" value="{{ $service->name }}">
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image:</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Service</button>
        </form>
    </div>
@endsection
