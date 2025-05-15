<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Company;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display the list of suppliers
    public function index()
    {
        $suppliers = Supplier::all(); // You can use pagination if you have many suppliers
        foreach ($suppliers as $supplier) {
            // Decode or split the companies_array
            $companyIds = explode(',', $supplier->companies_array); // Use json_decode() if stored as JSON
    
            // Fetch the company names
            $companyNames = Company::whereIn('id', $companyIds)->pluck('name')->toArray();
    
            // Join the names into a string and assign it to a new attribute
            $supplier->company_names = implode(', ', $companyNames);
        }
        return view('suppliers.index', compact('suppliers'));
    }

    // Show form to create a new supplier
    public function create()
    {
        $companies = Company::orderBy('name')->get(); // Fetch companies from the database and sort by name
        return view('suppliers.create', compact('companies'));
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
            'companies_array' => 'nullable|array', // Ensures that an array is passed
            'pan_number' => 'nullable|string',
            'registration_number' => 'nullable|string',
        ]);

        // Join companies array to save as string (if you're not using JSON type column)
        // $companiesArray = implode(',', $request->companies_array);
         // Check if companies_array exists, otherwise set it to null
        $companiesArray = isset($request->companies_array) ? implode(',', $request->companies_array) : null;

        // Create the supplier manually
        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'companies_array' => $companiesArray, // Save as a comma-separated string
            'pan_number' => $request->pan_number,
            'registration_number' => $request->registration_number,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function edit($id)
    {
        // Fetch the supplier by ID
        $supplier = Supplier::findOrFail($id);

        // Fetch all companies to populate the checkboxes
        $companies = Company::orderBy('name')->get();

        // Decode or split the companies_array to pre-select checkboxes
        $selectedCompanies = explode(',', $supplier->companies_array); // Use json_decode() if stored as JSON

        return view('suppliers.edit', compact('supplier', 'companies', 'selectedCompanies'));
    }

    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'contact_person' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'companies_array' => 'nullable|array', // Ensure it's an array
            'pan_number' => 'nullable|string',
            'registration_number' => 'nullable|string',
        ]);

        // Join companies array to save as a comma-separated string
        $companiesArray = isset($request->companies_array) ? implode(',', $request->companies_array) : null;

        // Update the supplier
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'companies_array' => $companiesArray,
            'pan_number' => $request->pan_number,
            'registration_number' => $request->registration_number,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Delete the supplier
        $supplier->delete();

        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }

}

