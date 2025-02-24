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
}

