<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProviderController;
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



Route::post('user/register', [UserController::class, 'register']);
Route::post('user/verify', [UserController::class, 'verifyOtp']);
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('user/reset-password', [UserController::class, 'resetPassword']);
Route::get('/user/profile', [UserController::class, 'getUser']);

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

// Route for getting provider profile
Route::get('/provider/profile', [ProviderController::class, 'getProfile']);