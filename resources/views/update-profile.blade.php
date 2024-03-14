@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="mt-8">
            <form method="POST" action="{{ route('admin.update') }}" class="flex flex-col">
                @csrf
                @method('PUT') <!-- Add method field to override POST with PUT -->
                <!-- Name input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="mt-1 p-4 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <!-- Email input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="mt-1 p-4 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
              
                <!-- Update button -->
                <div class="mt-5">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
