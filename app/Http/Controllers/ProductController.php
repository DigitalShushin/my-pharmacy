<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {        
        // $products = Product::all(); 
        // return view('products.index', compact('products'));

        // Fetch products with their associated company
        $products = Product::with('company')->get();

        return view('products.index', compact('products'));

    }

    public function create()
    {
        $products = Product::orderBy('name')->get(); // Fetch companies from the database and sort by name
        return view('products.create', compact('products'));
    }
}
