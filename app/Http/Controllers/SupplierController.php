<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display the list of suppliers
    public function index()
    {
        $suppliers = Supplier::all(); // You can use pagination if you have many suppliers
        return view('suppliers.index', compact('suppliers'));
    }

    // Show form to create a new supplier
    public function create()
    {
        return view('suppliers.create');
    }

    // Store the new supplier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'contact_person' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'companies_array' => 'required|array', // Ensures that an array is passed
            'pan_number' => 'nullable|string',
            'registration_number' => 'nullable|string',
        ]);

        // Join companies array to save as string (if you're not using JSON type column)
        if (isset($validated['companies_array'])) {
            $validated['companies_array'] = implode(',', $validated['companies_array']);
        }

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');
    }

}

