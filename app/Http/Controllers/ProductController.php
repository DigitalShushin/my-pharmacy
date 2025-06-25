<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {        
        // $products = Product::all(); 
        // return view('products.index', compact('products'));

        // Fetch products with their associated company
        $products = Product::with('company')->orderBy('name', 'asc')->get();

        return view('products.index', compact('products'));

    }

    public function create()
    {
        // $companies = Company::all();
        $companies = Company::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('products.create', compact('companies'));
    }   

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:products,name',
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            Product::create([
                'name' => $request->name,
                'company_id' => $request->company_id,
                'min_stock' => $request->min_stock ?? 0, // Default to 0 if not provided
            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                // Duplicate entry error
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['name' => 'This medicine name already exists.']);
            }

            // Other SQL errors
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    

    public function edit(Product $product)
    {
        $companies = Company::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|unique:products,name,' . $product->id,
            'company_id' => 'required|exists:companies,id',
        ]);

        $product->update([
            'name' => $request->name,
            'company_id' => $request->company_id,
            'min_stock' => $request->min_stock ?? 0, // Default to 0 if not provided
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function minimumStock()
{
    $products = Product::with('company', 'category')
        ->whereRaw('
            (
                SELECT COALESCE(SUM(quantity + bonus), 0)
                FROM purchase_stocks
                WHERE product_id = products.id
            )
            <
            min_stock
        ')
        ->get();

    return view('products.minimum_stock', compact('products'));
}
    
}
