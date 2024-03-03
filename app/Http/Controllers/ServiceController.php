<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('service_images'), $imageName);
            $data['image'] = $imageName; // Store only the filename
        }

        Service::create($data);
        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $service = Service::findOrFail($id);
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($service->image) {
                Storage::delete($service->image);
            }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('service_images'), $imageName);
                $data['image'] = $imageName; 
        }
        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}
