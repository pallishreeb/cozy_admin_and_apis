<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ManageDiscountController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('discounts.index', compact('categories'));
    }

    public function create()
    {
       // $category = Category::findOrFail($id);
        $categories = Category::all();
        return view('discounts.create', compact('categories'));
        // Return a view to create a new discount for a category
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        // Find the category
        $category = Category::findOrFail($request->category_id);

        // Update the discount for the category
        $category->discount = $request->discount;
        $category->save();

        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount added successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('discounts.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        // Find the category
        $category = Category::findOrFail($id);

        // Update the discount for the category
        $category->discount = $request->discount;
        $category->save();

        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount updated successfully');
    }

    public function destroy($id)
    {
        // Find the category
        $category = Category::findOrFail($id);

        // Remove the discount for the category
        $category->discount = null;
        $category->save();

        return redirect()->route('manage_discounts.index')
            ->with('success', 'Discount removed successfully');
    }
}
