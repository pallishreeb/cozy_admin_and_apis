<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\Provider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use JWTAuth;

class ProviderController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:providers',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $provider = Provider::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($provider));

        $otp = mt_rand(100000, 999999);

        // Send OTP to provider's email
        Mail::to($provider->email)->send(new OtpMail($otp));

        $provider->otp = $otp;
        $provider->save();

        return response()->json(['message' => 'Provider registered successfully. OTP sent to email.']);
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

        $provider = Provider::where('email', $request->email)->first();

        if (!$provider || $provider->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        $provider->otp = null;
        $provider->save();

        return response()->json(['message' => 'OTP verified successfully']);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to find the provider by email
        $provider = Provider::where('email', $request->email)->first();

        // If provider not found or password doesn't match, return error
        if (!$provider || !Hash::check($request->password, $provider->password)) {
            return response()->json(['error' => 'Invalid email or password.'], 401);
        }

        // If provider found and password matches, generate JWT token
        $token = JWTAuth::fromUser($provider);

        // Return token and provider data
        return response()->json([
            'token' => $token,
            'provider' => $provider,
            //'provider' => $provider->only(['id', 'name', 'email'])
        ]);
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $provider = Provider::where('email', $request->email)->first();
    
        if (!$provider) {
            return response()->json(['error' => 'Email not found'], 404);
        }
    
        $otp = mt_rand(100000, 999999);
    
        // Send OTP to provider's email
        Mail::to($provider->email)->send(new OtpMail($otp));
    
        $provider->otp = $otp;
        $provider->save();
    
        return response()->json(['message' => 'OTP sent to email.']);
    }
    
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $provider = Provider::where('email', $request->email)->where('otp', $request->otp)->first();
    
        if (!$provider) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }
    
        $provider->password = Hash::make($request->password);
        $provider->otp = null;
        $provider->save();
    
        return response()->json(['message' => 'Password reset successfully']);
    }

    public function updateProfile(Request $request)
    {
        // Get the JWT token from the request headers
        $token = $request->header('Authorization');

        // Attempt to parse the token and extract the provider's email
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $id = $payload->get('sub'); // Assuming email is stored as 'sub' in the token
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Find the provider by email
        $provider = Provider::where('id', $id)->first();

        // If provider not found, return error
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'mobile_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:25',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'profile_pic' => 'nullable|image|max:20480',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
    
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_pic'), $imageName);
            $data['profile_pic'] = $imageName; // Store only the filename
        }
    
        // Update the provider's profile
        $provider->update($data);

        // Return success response
        return response()->json(['message' => 'Profile updated successfully']);
    }
    public function updateBusinessHours(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);
    
        // If provider not found, return error
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }
    
        // Validate request data
        $validator = Validator::make($request->all(), [
            'working_hours' => 'json|nullable',
            'business_hours_enabled' => 'boolean',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Get the working hours data from the validated request
        $workingHours = $request->input('working_hours');
    
        // Convert the working hours array to a JSON string
        $workingHoursJson = json_encode($workingHours);
    
        // Update provider's working hours and business hours enabled status
        $provider->working_hours = $workingHoursJson;
        $provider->business_hours_enabled = $request->input('business_hours_enabled');
        $provider->save();
    
        return response()->json(['message' => 'Provider updated successfully'], 200);
    }
    
    public function updateBusinessProfile(Request $request)
    {
        // Get the JWT token from the request headers
        $token = $request->header('Authorization');

        // Attempt to parse the token and extract the provider's email
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $id = $payload->get('sub'); // Assuming email is stored as 'sub' in the token
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Find the provider by email
        $provider = Provider::where('id', $id)->first();

        // If provider not found, return error
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'experience' => 'integer',
            'rate' => 'numeric',
            'category_id' => 'integer',
            'service_id' => 'integer',
            'specialization' => 'string',
            'portfolio' => 'file|max:5120', // Max file size: 5MB
            'skills' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        if ($request->hasFile('portfolio')) {
            $portfolio = $request->file('portfolio');
            $portfolioName = time() . '.' . $portfolio->getClientOriginalExtension();
            $portfolio->move(public_path('portfolios'), $portfolioName);
            $data['portfolio'] = $portfolioName; // Store only the filename
        }
    

        // Update the provider's profile
        $provider->update($data);

        // Return success response
        return response()->json(['message' => 'Profile updated successfully']);
    }
    public function getProfile(Request $request)
    {
        // Get the JWT token from the request headers
        $token = $request->header('Authorization');

        // Attempt to parse the token and extract the provider's ID
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $providerId = $payload->get('sub'); // Assuming provider ID is stored as 'sub' in the token
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Find the provider by ID
        $provider = Provider::find($providerId);

        // If provider not found, return error
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }

        // Return provider's profile
        return response()->json(['provider' => $provider]);
    }
}
