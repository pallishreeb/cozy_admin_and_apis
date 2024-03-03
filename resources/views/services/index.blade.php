@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">All Services</h2>
            <a href="{{ route('services.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Service</a>
        </div>
        <!-- Service Table Listing with Pagination -->
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Headers -->
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($services as $service)
                <tr>
                    <td class="px-6 border py-2 whitespace-nowrap">{{ $service->id }}</td>
                    <td class="px-6 border py-2 whitespace-nowrap">{{ $service->category->name }}</td>
                    <td class="px-6 border py-2 whitespace-nowrap">{{ $service->name }}</td>
                    <td class="px-6 border py-2 whitespace-nowrap">
                    @if($service->image)
                      <img src="{{ asset('service_images/' . $service->image) }}" class="h-10 w-10 object-cover rounded-full">
                    @else
                        No Image
                    @endif
                    </td>
                    <td class="px-6  border py-2 whitespace-nowrap">
                        <a href="{{ route('services.edit', $service->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination Links -->
        {{ $services->links() }}
    </div>
@endsection
