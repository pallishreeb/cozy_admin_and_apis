<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $otp = mt_rand(100000, 999999);

        // Send OTP to user's email
        Mail::to($user->email)->send(new OtpMail($otp));

        $user->otp = $otp;
        $user->save();

        return response()->json(['message' => 'User registered successfully. OTP sent to email.']);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'otp' => 'required|string|min:6|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        $user->otp = null;
        $user->save();

        return response()->json(['message' => 'OTP verified successfully']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
    
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Email not found'], 404);
        }
    
        $otp = mt_rand(100000, 999999);
    
        // Send OTP to user's email
        Mail::to($user->email)->send(new OtpMail($otp));
    
        $user->otp = $otp;
        $user->save();
    
        return response()->json(['message' => 'OTP sent to email.']);
    }
    
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:8|',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }
    
        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();
    
        return response()->json(['message' => 'Password reset successfully']);
    }
    public function getUser(Request $request)
    {
        // Get the JWT token from the request headers
        $token = $request->header('Authorization');

        // Attempt to parse the token and extract the user's ID
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $email = $payload->get('sub'); // Assuming user ID is stored as 'sub' in the token
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Find the user by email
        $user = User::where('email', $email)->first();

        // If user not found, return error
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return user's profile
        return response()->json(['user' => $user]);
    }
}
