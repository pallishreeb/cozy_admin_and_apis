<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ManageProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return view('providers.index', compact('providers'));
    }

    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        $categories = Category::all();
        $services = Service::all();
        return view('providers.edit', compact('provider', 'categories', 'services'));
    }

    public function update(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);
        
        // Update provider fields
        $provider->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile_number' => $request->input('mobile_number'),
            // Update other fields as needed
        ]);
    
        // Update category ID
        $provider->category_id = $request->input('category');
    
        // Update service ID
        $provider->service_id = $request->input('service');
    
        $provider->save();
    
        return redirect()->route('manage_providers.index')->with('success', 'Provider updated successfully');
    }
    

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return redirect()->route('manage_providers.index')->with('success', 'Provider deleted successfully');
    }
}
