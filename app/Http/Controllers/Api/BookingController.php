<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function bookService(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'provider_id' => 'required|exists:providers,id',
            'user_id' => 'required|exists:users,id',
            'zipcode' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
        ]);

        // Create a new booking
        $booking = Booking::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Service booked successfully', 'booking' => $booking], 201);
    }

    public function editBooking(Request $request, $id)
    {
        // Find the booking
        $booking = Booking::findOrFail($id);

        // Validate and update request data
        $validatedData = $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
        ]);

        // Update the booking
        $booking->update($validatedData);

        // Return a success response
        return response()->json(['message' => 'Booking updated successfully', 'booking' => $booking]);
    }

    public function cancelBooking($id)
    {
        // Find the booking
        $booking = Booking::findOrFail($id);

        // Cancel the booking
        $booking->status = 'cancelled';
        $booking->save();

        // Return a success response
        return response()->json(['message' => 'Booking cancelled successfully', 'booking' => $booking]);
    }

    public function getProviderBookings(Request $request)
    {
        $providerId = $request->input('provider_id'); // Assuming you pass provider_id in the request
        $bookings = Booking::where('provider_id', $providerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function getProviderPendingBookings(Request $request)
    {
        $providerId = $request->input('provider_id'); // Assuming you pass provider_id in the request
        $bookings = Booking::where('provider_id', $providerId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function getUserBookings(Request $request)
    {
        $userId = $request->input('user_id'); // Assuming you pass user_id in the request
        $bookings = Booking::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function getUserPendingBookings(Request $request)
    {
        $userId = $request->input('user_id'); // Assuming you pass user_id in the request
        $bookings = Booking::where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }
}
