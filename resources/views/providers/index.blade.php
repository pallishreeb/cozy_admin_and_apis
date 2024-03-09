<!-- resources/views/manage_providers/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Providers</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Name</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Email</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Mobile</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Category</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Service</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Rate</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Experience</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Address</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                        <tr>
                            <td class="border py-2 px-3">{{ $provider->name }}</td>
                            <td class="border py-2 px-3">{{ $provider->email }}</td>
                            <td class="border py-2 px-3">{{ $provider->mobile_number ?? 'NA' }}</td>
                            <td class="border py-2 px-3">{{ $provider->category->name ?? 'NA' }}</td>
                            <td class="border py-2 px-3">{{ $provider->service->name ?? 'NA' }}</td>
                            <td class="border py-2 px-3">{{ $provider->rate ?? 'NA' }}</td>
                            <td class="border py-2 px-3">{{ $provider->experience ?? 'NA' }}</td>
                            <td class="border py-2 px-3">{{ $provider->address ?? 'NA' }}</td>
                            <td class="border py-2 px-3">
                                <a href="{{ route('manage_providers.edit', $provider->id) }}" class="text-blue-500 hover:text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('manage_providers.destroy', $provider->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this provider?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
