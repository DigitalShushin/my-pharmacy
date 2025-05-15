<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        // $companies = Company::all();
        //$companies = Company::with('parent')->get(); // eager load parent company
        $companies = Company::with('parent')->where(function ($query) {
            $query->whereNull('parent_id')->orWhere('parent_id', 0);
        })->orderBy('name', 'asc')->get(); // Fetch companies with no parent or parent_id = 0 and sort by name
        $parentCompanies = Company::all(); // List of all companies to use in the parent dropdown

        return view('company.index', compact('companies', 'parentCompanies'));
    }
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $parentCompanies = Company::whereNull('parent_id')->orderBy('name', 'asc')->get(); // Fetch only companies with no parent and sort parent companies by name
        return view('company.edit-form', compact('company', 'parentCompanies'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        // Validate incoming data
        $request->validate([
            'parent_id' => 'nullable|integer|exists:companies,id',
            'name' => 'required|string|max:255',
        ]);

        // Find and update the company
        $company = Company::findOrFail($id);
        $company->parent_id = $request->input('parent_id');
        $company->name = $request->input('name');
        $company->save();

        // Redirect or return response
        return redirect()->back()->with('success', 'Company updated successfully!');
    }

    public function create()
    {
        $companies = Company::all(); // fetch all companies
        return view('company.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:companies,id'
        ]);

        $company = Company::create($request->only('name', 'parent_id'));

        return response()->json([
            'message' => 'Company created!',
            'company' => $company
        ]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if ($company) {
            $company->delete();
            return response()->json(['success' => true, 'message' => 'Company deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Company not found!']);
    }
}

