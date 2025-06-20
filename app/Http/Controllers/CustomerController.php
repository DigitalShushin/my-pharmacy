<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; 

class CustomerController extends Controller
{
    public function getByPhone(Request $request)
    {
        $phone = $request->query('phone');
        $customer = Customer::where('phone', $phone)->first();

        if ($customer) {
            return response()->json($customer);
        } else {
            // Return empty JSON or explicit "not found"
            return response()->json([]);
            // or return response()->json(['found' => false]);
        }
    }
}
