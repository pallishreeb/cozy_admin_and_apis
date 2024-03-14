<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provider;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $providerCount = Provider::count();
        $categoryCount = Category::count();
        $serviceCount = Service::count();
        $categoriesWithDiscount = Category::whereNotNull('discount')->get();
        $discountCount = Category::whereNotNull('discount')->count();

        return view('welcome', compact('userCount', 'providerCount', 'categoryCount', 'serviceCount', 'discountCount'));
    }
    public function showUpdateProfileForm()
    {
        return view('update-profile');
    }
    public function updateAdmin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
        ]);

        // Get the authenticated admin user
        $admin = Auth::user();

        // Update the admin's name and email
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        // Save the changes
        $admin->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Admin details updated successfully.');
    }
}
