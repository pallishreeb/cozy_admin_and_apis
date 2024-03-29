<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PushNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// user
Route::post('user/register', [UserController::class, 'register']);
Route::post('user/verify', [UserController::class, 'verifyOtp']);
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('user/reset-password', [UserController::class, 'resetPassword']);
Route::get('/user/profile', [UserController::class, 'getUser']);
Route::post('/user/save-token', [UserController::class, 'saveToken']);
Route::post('user/update-profile', [UserController::class, 'update']);


// Provider registration
Route::post('provider/register', [ProviderController::class, 'register']);

Route::post('provider/verify', [ProviderController::class, 'verifyOtp']);
// Provider login
Route::post('provider/login', [ProviderController::class, 'login']);

// Provider forgot password (send OTP to email)
Route::post('provider/forgot-password', [ProviderController::class, 'forgotPassword']);

// Provider reset password with OTP
Route::post('provider/reset-password', [ProviderController::class, 'resetPassword']);

// Provider update profile
Route::post('provider/update-profile', [ProviderController::class, 'updateProfile']);
// Provider update business profile
Route::post('provider/update-business-profile', [ProviderController::class, 'updateBusinessProfile']);
//update business hour
Route::put('/provider/update-business-hours/{id}',[ProviderController::class, 'updateBusinessHours']);

// Route for getting provider profile
Route::get('/provider/profile', [ProviderController::class, 'getProfile']);
//save device_token
Route::post('/provider/save-token', [ProviderController::class, 'saveToken']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);


Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
// Get all providers near a user's location
// Route::get('/providers/near-me', [ServiceController::class, 'providersNearMe']);
Route::post('/providers/near-me', [ServiceController::class, 'getProvidersNearMe']);

// Search providers by service name
Route::post('/providers/search', [ServiceController::class, 'providersByService']);

// Get details of a single provider
Route::get('/providers/{id}', [ServiceController::class, 'providerDetails']);



Route::post('/bookings', [BookingController::class, 'bookService']);
Route::put('/bookings/{id}', [BookingController::class, 'editBooking']);
Route::delete('/bookings/{id}', [BookingController::class, 'cancelBooking']);
Route::put('/bookings/complete/{id}', [BookingController::class, 'completeBooking']);
Route::post('/bookings/provider', [BookingController::class, 'getProviderBookings']);
Route::post('/bookings/provider/pending', [BookingController::class, 'getProviderPendingBookings']);
Route::post('/bookings/user', [BookingController::class, 'getUserBookings']);
Route::post('/bookings/user/pending', [BookingController::class, 'getUserPendingBookings']);



Route::post('/send-push-notification', [PushNotificationController::class, 'sendPushNotification']);


