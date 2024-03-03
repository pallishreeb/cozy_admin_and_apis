<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

  

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming image upload
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('category_images'), $imageName);
            $data['image'] = $imageName; // Store only the filename
        }
    
        Category::create($data);
    
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }
    

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming image upload
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::delete($category->image);
            }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('category_images'), $imageName);
                $data['image'] = $imageName; 
        }
    
        $category->update($data);
    
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if the category ID is associated with any service
        $servicesCount = Service::where('category_id', $id)->count();
        if ($servicesCount > 0) {
            return redirect()->route('categories.index')->with('error', 'Category cannot be deleted as it is associated with services.');
        }
    
        // If no services associated, proceed with deletion
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
    
}
