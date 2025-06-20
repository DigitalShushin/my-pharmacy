<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseStock;
use App\Models\Customer;

class SaleController extends Controller
{
    public function index()
    {   
        $sales = Sale::orderBy('created_at', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    public function getStockAttribute()
    {
        $purchased = $this->purchaseStocks()->sum(DB::raw('(quantity + bonus) * pack'));
        $sold = $this->salesItems()->sum('quantity');
        return $purchased - $sold;
    }

    public function getByPhone(Request $request)
    {
        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    // public function create(Request $request)
    // {
        
    //     $customer = null;
    //     if ($request->filled('customer_phone')) {
    //         $customer = Customer::where('phone', $request->customer_phone)->first();
    //     }
        
        
    //     $products = Product::with('purchaseStocks')
    //                         ->whereHas('purchaseStocks', function ($query) {
    //                                 $query->where('quantity', '>', 0)
    //                                       ->orWhere('bonus', '>', 0);
    //                             })
    //                         ->orderBy('name', 'asc')
    //                         ->get();

    //     foreach ($products as $product) {
    //         $stock = 0;
    //         $sp = 0;
    //         foreach ($product->purchaseStocks as $stockItem) {
    //             $bonusPack = ($stockItem->bonus ?? 0) + ($stockItem->quantity ?? 0);
    //             $stock += $bonusPack * ($stockItem->pack ?? 1);
    //             $sp = $stockItem->selling_price ?? 0;
    //         }
    //         $product->stock = $stock;
    //         $product->selling_price = $sp;
            
    //     }

    //     return view('sales.create', compact('products', 'customer'));
    // }

    public function create(Request $request)
    {
        $customer = null;
        if ($request->filled('customer_phone')) {
            $customer = Customer::where('phone', $request->customer_phone)->first();
        }

        $products = Product::with(['purchaseStocks', 'saleItems'])
                    ->orderBy('name', 'asc')
                    ->get();

        $filteredProducts = [];

        foreach ($products as $product) {
            $stock = 0;
            $sp = 0;

            // 1. Calculate purchased stock
            foreach ($product->purchaseStocks as $stockItem) {
                $bonusPack = ($stockItem->bonus ?? 0) + ($stockItem->quantity ?? 0);
                $stock += $bonusPack * ($stockItem->pack ?? 1);
                $sp = $stockItem->selling_price ?? 0;
            }

            // 2. Subtract sold quantity
            $sold = 0;
            foreach ($product->saleItems as $saleItem) {
                $sold += $saleItem->quantity ?? 0;
            }

            $returned = 0;
            foreach ($product->saleReturnItems ?? [] as $returnItem) {
                $returned += $returnItem->quantity ?? 0;
            }

            // 4. Final available stock
            $availableStock = $stock - $sold + $returned;

            // $availableStock = $stock - $sold;

            // 3. Only keep products with available stock
            if ($availableStock > 0) {
                $product->stock = $availableStock;
                $product->selling_price = $sp;
                $filteredProducts[] = $product;
            }
        }

        return view('sales.create', [
            'products' => $filteredProducts,
            'customer' => $customer
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_phone' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'nullable',
            'customer_email' => 'nullable|email',
            'customer_person' => 'nullable',
            // 'customer_id' => 'required|string|max:255',
            'net_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
        ]);

        // Check if a customer with the same phone exists
        $existingCustomer = Customer::where('phone', $validated['customer_phone'])->first();

        // Insert only if customer doesn't exist or info mismatch
        if (!$existingCustomer) {
            // Create new customer
            $customer = Customer::create([
                'phone' => $request->customer_phone,
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'address' => $request->customer_address,
                'contact_person' => $request->customer_person,
            ]);
        } 
        else {
            // Use the existing customer
            $customer = $existingCustomer;
        }

        $sale = Sale::create([
            // 'customer_id' => $request->customer_id,
            'customer_id' => $customer->id,
            'sales_date' => $request->sales_date,
            'net_amount' => $request->net_amount,
            'vat' => $request->vat ?? 0,
            'discount_percentage' => $request->discount_percent ?? 0,
            'discount' => $request->discount ?? 0,
            'total_amount' => $request->total_amount,
        ]);

        foreach ($request->sales as $item) {
            // Automatically get the first available stock for the product (FIFO logic)
            $stock = \App\Models\PurchaseStock::where('product_id', $item['product_id'])
                        ->whereRaw('(quantity + bonus) > 0')
                        ->orderBy('created_at') // FIFO: older stock first
                        ->first();

            SalesItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'stock_id' => $stock->id,
                'quantity' => $item['quantity'] ?? 0,
                'rate' => $item['rate'] ?? 0,
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale added successfully.');
    }

    // public function edit(Sale $sale)
    // {
    //     $sale->load('customer');
    //     $products = Product::orderBy('name', 'asc')->get();
    //     $customers = Customer::all();
    //     return view('sales.edit', compact('sale', 'products', 'customers'));
    // }

//     public function edit(Sale $sale)
// {
//     $sale->load('customer');

//     // Reuse the same logic from `create()` to get stock and selling price
//     $products = Product::with(['purchaseStocks', 'saleItems'])
//                 ->orderBy('name', 'asc')
//                 ->get();

//     $filteredProducts = [];

//     foreach ($products as $product) {
//         $stock = 0;
//         $sp = 0;

//         foreach ($product->purchaseStocks as $stockItem) {
//             $bonusPack = ($stockItem->bonus ?? 0) + ($stockItem->quantity ?? 0);
//             $stock += $bonusPack * ($stockItem->pack ?? 1);
//             $sp = $stockItem->selling_price ?? 0;
//         }

//         $sold = 0;
//         foreach ($product->saleItems as $saleItem) {
//             $sold += $saleItem->quantity ?? 0;
//         }

//         $availableStock = $stock - $sold;

//         if ($availableStock > 0) {
//             $product->stock = $availableStock;
//             $product->selling_price = $sp;
//             $filteredProducts[] = $product;
//         }
//     }

//     $customers = Customer::all();

//     return view('sales.edit', [
//         'sale' => $sale,
//         'products' => $filteredProducts,
//         'customers' => $customers,
//     ]);
// }

    public function edit(Sale $sale)
    {
        $sale->load('items', 'customer');

        $products = Product::with(['purchaseStocks', 'saleItems'])
                    ->orderBy('name', 'asc')
                    ->get();

        $filteredProducts = [];

        foreach ($products as $product) {
            $stock = 0;
            $sp = 0;

            // Total stock (quantity + bonus) * pack
            foreach ($product->purchaseStocks as $stockItem) {
                $bonusPack = ($stockItem->bonus ?? 0) + ($stockItem->quantity ?? 0);
                $stock += $bonusPack * ($stockItem->pack ?? 1);
                $sp = $stockItem->selling_price ?? 0;
            }

            // Sold quantity total (includes this sale)
            $totalSold = 0;
            foreach ($product->saleItems as $saleItem) {
                $totalSold += $saleItem->quantity ?? 0;
            }

            // Returned quantity (add it back)
            $totalReturned = 0;
            foreach ($product->saleReturnItems as $returnItem) {
                $totalReturned += $returnItem->quantity ?? 0;
            }

            // Current sale's quantity for this product
            $existingSaleItemQty = $sale->items->firstWhere('product_id', $product->id)?->quantity ?? 0;

            // Exclude this sale's quantity from sold to get accurate available stock
            $availableStock = $stock - ($totalSold - $existingSaleItemQty) + $totalReturned;

            if ($availableStock > 0) {
                $product->stock = $availableStock;
                $product->selling_price = $sp;
                $filteredProducts[] = $product;
            }
        }

        $customers = Customer::all();

        return view('sales.edit', [
            'sale' => $sale,
            'products' => $filteredProducts,
            'customers' => $customers,
        ]);
    }
    

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'customer_phone' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'nullable',
            'customer_email' => 'nullable|email',
            'customer_person' => 'nullable',
            'net_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
        ]);

        // Find or update customer
        $customer = Customer::where('phone', $validated['customer_phone'])->first();

        if (!$customer) {
            $customer = Customer::create([
                'phone' => $request->customer_phone,
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'address' => $request->customer_address,
                'contact_person' => $request->customer_person,
            ]);
        } else {
            $customer->update([
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'address' => $request->customer_address,
                'contact_person' => $request->customer_person,
            ]);
        }

        // Update the sale
        $sale->update([
            'customer_id' => $customer->id,
            'sales_date' => $request->sales_date,
            'net_amount' => $request->net_amount,
            'vat' => $request->vat ?? 0,
            'discount_percentage' => $request->discount_percent ?? 0,
            'discount' => $request->discount ?? 0,
            'total_amount' => $request->total_amount,
        ]);

        // Delete old sale items
        $sale->items()->delete();

        // Recreate sale items from request
        foreach ($request->sales as $item) {
            // Get stock using FIFO logic
            $stock = \App\Models\PurchaseStock::where('product_id', $item['product_id'])
                ->whereRaw('(quantity + bonus) > 0')
                ->orderBy('created_at')
                ->first();

            SalesItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'stock_id' => $stock->id,
                'quantity' => $item['quantity'] ?? 0,
                'rate' => $item['rate'] ?? 0,
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }
    
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete(); // Cascade will handle purchase_stocks

        return response()->json(['success' => true, 'message' => 'Sale deleted successfully.']);
    }
}
