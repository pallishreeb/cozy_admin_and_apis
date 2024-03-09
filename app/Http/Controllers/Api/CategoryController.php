<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('services')->get();
        return response()->json(['categories' => $categories], 200);
    }

    public function show($id)
    {
        $category = Category::with('services')->findOrFail($id);
        return response()->json(['category' => $category], 200);
    }
}
