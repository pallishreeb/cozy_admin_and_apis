<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
    public function bookService(Request $request)
    {
          // Set default values for zipcode, city, state, and country if not available
        if (!$request->filled(['zipcode', 'city', 'state', 'country'])) {
            $request->merge([
                'zipcode' => 'NA',
                'city' => 'NA',
                'state' => 'NA',
                'country' => 'NA',
            ]);
        }
        // Validate request data
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'provider_id' => 'required|exists:providers,id',
            'user_id' => 'required|exists:users,id',
            'zipcode' => 'nullable|string',
            'address' => 'required|string',
            'mobile_number' => 'required|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
        ]);

         // Check if validation fails
    if ($validator->fails()) {
        // Return validation errors as JSON response
        return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

        // Create a new booking
        $booking = Booking::create($request->all());

        // Return a success response
        return response()->json(['message' => 'Service booked successfully', 'booking' => $booking], 201);
    }

    public function editBooking(Request $request, $id)
    {
        // Find the booking
        $booking = Booking::findOrFail($id);

        // Validate and update request data
         // Validate request data
         $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'mobile_number' => 'nullable|string',
        ]);
       

           // Check if validation fails
    if ($validator->fails()) {
        // Return validation errors as JSON response
        return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
        // Update the booking
        $booking->update($request->all());

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
    public function completeBooking($id)
    {
        // Find the booking
        $booking = Booking::findOrFail($id);

        // Cancel the booking
        $booking->status = 'completed';
        $booking->save();

        // Return a success response
        return response()->json(['message' => 'Booking cancelled successfully', 'booking' => $booking]);
    }


    public function getProviderBookings(Request $request)
    {
        $providerId = $request->input('provider_id');
        $bookings = Booking::with(['user', 'provider','service'])->where('provider_id', $providerId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json(['bookings' => $bookings], 200);
    }
    
    public function getProviderPendingBookings(Request $request)
    {
        $providerId = $request->input('provider_id');
        $bookings = Booking::with(['user', 'provider','service'])->where('provider_id', $providerId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json(['bookings' => $bookings], 200);
    }
    
    public function getUserBookings(Request $request)
    {
        $userId = $request->input('user_id');
        $bookings = Booking::with(['provider','service'])->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json(['bookings' => $bookings], 200);
    }
    
    public function getUserPendingBookings(Request $request)
    {
        $userId = $request->input('user_id');
        $bookings = Booking::with(['provider','service'])->where('user_id', $userId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json(['bookings' => $bookings], 200);
    }
    
}
