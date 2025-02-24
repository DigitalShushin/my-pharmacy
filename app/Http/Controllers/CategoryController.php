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

        // Debugging: Dump and die to check the fetched categories
        //  dd($categories);

        return view('apps-category', ['categories' => $categories]); 
    }

    
}

