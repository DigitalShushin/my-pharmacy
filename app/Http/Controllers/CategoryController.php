<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch categories from the database
        $categories = Category::select('id', 'name')->get();
        //dd($categories);
        // Pass the categories to the view
        //return view('apps-category', ['categories' => $categories]); 
        return view('apps-category', compact('categories'));
    }

    public function add()
    {
        return view('apps-category-add');
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category = Category::createCategory($validated);

            // Return a success response
            return redirect()->route('category')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return redirect()->route('category')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category = Category::updateCategory($id, $validated);

            // Return a success response
            return response()->json(['success' => true, 'message' => 'Category updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}

