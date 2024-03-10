<!-- resources/views/manage_discounts/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Manage Discounts</h2>
        <a href="{{ route('manage_discounts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Add Discount</a>
    </div>   
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Category</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Discount</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="border py-2 px-3">{{ $category->name }}</td>
                            <td class="border py-2 px-3">{{ $category->discount ? ($category->discount * 100 / 100) . '%' : 'NA' }}</td>
                            <td class="border py-2 px-3">
                                <a href="{{ route('manage_discounts.edit', $category->id) }}" class="text-blue-500 hover:text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('manage_discounts.destroy', $category->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
