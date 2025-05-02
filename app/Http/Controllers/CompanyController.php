<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        // $companies = Company::all();
        $companies = Company::with('parent')->paginate(20); // eager load parent company
        $parentCompanies = Company::all(); // List of all companies to use in the parent dropdown

        return view('companies.index', compact('companies', 'parentCompanies'));
    }

    public function create()
    {
        $companies = Company::all(); // fetch all companies
        return view('companies.create', compact('companies'));
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
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Company not found']);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->name = $request->input('name');
        $company->parent_id = $request->input('parent_id');
        $company->save();

        return response()->json(['message' => 'Company updated successfully']);
    }
}

