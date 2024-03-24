@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Bookings</h2>
            </div>   
            <div class="bg-white overflow-hidden  sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th> <!-- Added Actions column -->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->service->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->provider->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_date }}</td>
                                <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_time }}</td> -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // Assuming $booking->booking_time is your date string
                                    $dateString = $booking->booking_time;

                                    // Parse the date string into a DateTime object
                                    $date = new DateTime($dateString);

                                    // Format the time part in AM/PM format
                                    $formattedTime = $date->format('g:i A');
                                @endphp
                                {{ $formattedTime }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $booking->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
