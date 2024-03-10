<!-- resources/views/manage_users/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Users</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Name</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Email</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Mobile</th>
                        <th class="py-2 px-3 sticky top-0 bg-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border py-2 px-3">{{ $user->name }}</td>
                            <td class="border py-2 px-3">{{ $user->email }}</td>
                            <td class="border py-2 px-3">{{ $user->mobile_number ?? 'NA' }}</td>
                            <td class="border py-2 px-3">
                                <a href="{{ route('manage_users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('manage_users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
