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
            'images.*' => 'image|max:20480', // Validate each image
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('images')) {
            $imageUrls = [];
    
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('service_images'), $imageName);
                $imageUrls[] = '/service_images/' . $imageName; // Store image URL
            }

        $data['images'] = $imageUrls; 
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
            'new_images.*' => 'nullable|image|max:2048',
        ]);
    
        $service = Service::findOrFail($id);
        $data = $request->all();
    
        // Handle new images
        if ($request->hasFile('new_images')) {
            $newImages = [];
            foreach ($request->file('new_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('service_images'), $imageName);
                $newImages[] = '/service_images/' . $imageName;
            }
            // Merge new images with existing images
            // $data['images'] = array_merge($service->images ?? [], $newImages);
                        // Merge new images with existing images
            $existingImages = json_decode($service->images, true) ?? [];
            $data['images'] = array_merge($existingImages, $newImages);

        } else {
            // If no new images, use existing images
            $data['images'] = $service->images ?? [];
        }
    
        // Update the service
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
