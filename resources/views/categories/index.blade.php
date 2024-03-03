<!-- resources/views/categories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">All Categories</h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Category</a>
        </div>
         <!-- Display Error Message -->
         @if(session('error'))
            <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Name</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Image</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="border py-2 px-3">{{ $category->name }}</td>
                            <td class="border py-2 px-3">
                                @if($category->image)
                                    <img src="{{ asset('category_images/' . $category->image) }}" class="h-10 w-10 object-cover rounded-full">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="border py-2 px-3">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
    setTimeout(function() {
        document.getElementById('errorMessage').style.display = 'none';
    }, 5000); // 5000 milliseconds = 5 seconds
    </script>
@endsection
