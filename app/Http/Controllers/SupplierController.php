<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        return view('apps-supplier', compact('suppliers'));
    }

    // public function index()
    // {
    //     // Fetch suppliers from the database
    //     $suppliers = Supplier::select('id', 'name')->get();
    //     return view('apps-supplier', compact('suppliers'));
    // }

    public function add()
    {
        return view('apps-supplier-manage');
    }
}
