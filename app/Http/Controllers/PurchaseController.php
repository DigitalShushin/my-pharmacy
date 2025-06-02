<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseStock;
// use Shokri\NepaliDate\NepaliDate;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $purchases = Purchase::with('supplier')->latest()->get();
        return view('purchases.index', compact('purchases'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // $suppliers = Supplier::all();
        // return view('purchases.create', compact('suppliers'));

        $suppliers = Supplier::all();   
        $products = Product::all();
        return view('purchases.create', compact('products', 'suppliers'));

        
    }

    // Helper function
    private function convertDevanagariToEnglish($nepaliDate)
    {
        $devanagari = ['०','१','२','३','४','५','६','७','८','९'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($devanagari, $english, $nepaliDate);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert Nepali date to English
        // $nepaliDate = $request->input('purchase_date');
        // $englishDate = NepaliDate::convertToEnglish($nepaliDate); 

        $nepaliDate = $request->input('purchase_date');
        $converted = $this->convertDevanagariToEnglish($nepaliDate);
        // $nepaliDate = $request->input('purchase_date'); // from Nepali date picker
        $englishDate = LaravelNepaliDate::from($converted)->toEnglishDate(); // converts to AD

        // Subtract 1 day because of 1 day error occuring in AnuzPandey's LaravelNepaliDate package
        // $englishDate = Carbon::parse($englishDate)->subDay()->format('Y-m-d'); // format to Y-m-d

        // dd(LaravelNepaliDate::from('2081-01-15')->toEnglishDate());

        // dd($nepaliDate); 

        $request->validate([
            // 'supplier_id' => 'required|exists:suppliers,id',
            // 'supplier_name' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required',
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'net_amount' => 'required|numeric',
            'vat' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            // 'products.*.quantity' => 'required|integer|min:1',
            // 'products.*.cost_price' => 'required|numeric',
            // 'products.*.marked_rate' => 'required|numeric',
            // 'products.*.selling_price' => 'required|numeric',
            'products.*.expiry_date' => 'nullable|date',
        ]);


        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $englishDate,
            'net_amount' => $request->net_amount,
            'vat' => $request->vat ?? 0,
            'discount' => $request->discount ?? 0,
            'total_amount' => $request->total_amount,
            'invoice_number' => $request->invoice_number,
        ]);

        $netAmount = $request->net_amount; // 20460
        $totalAmount = $request->total_amount; // 21963.81

        foreach ($request->products as $index => $item) {
            $pack = $item['pack']; // 10
            $quantity = $item['quantity']; //10
            $rate = $item['rate']; // 200
            $bonus = $item['bonus']; // 20
            $cc = $item['cc'] ?? 0; // 0

            $totalPacks = $quantity + $bonus; // 10 + 20 = 30

            $ccOnBonus = $bonus * $rate * ($cc / 100); // 20 * 200 * (7.5 / 100) = 300

            $amount = ($quantity * $rate) + $ccOnBonus; // (10 * 200) + 300 = 2300

            $proportion = $amount / $netAmount; // 2300 / 20460 = 0.1124
            $costPerPack = ($proportion * $totalAmount) / $totalPacks; // (0.1124 * 21963.81) / 30 = 82.24

            $costPricePerPack = $costPerPack / $pack; // cost price per pack
            $sellingPrice = ($rate * 1.16) / $pack; // Selling price is 16% of cost price

            PurchaseStock::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'batch' => $item['batch'] ?? 0,
                'pack' => $item['pack'] ?? 0,
                'quantity' => $item['quantity'] ?? 0,
                'bonus' => $item['bonus'] ?? 0,
                'rate' => $item['rate'] ?? 0,
                'cc' => $item['cc'] ?? 0,
                'cc_on_bonus' => round($ccOnBonus, 2),
                'marked_rate' => $item['marked_rate'] ?? 0,
                'cost_price' => round($costPricePerPack, 2),
                'selling_price' => round($sellingPrice, 2),
                'expiry_date' => $item['expiry_date'] ?? null,
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
