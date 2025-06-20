<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseStock;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SalesItem;

class SalesReturnController extends Controller
{
    public function index()
    {   
        $saleReturns = SaleReturn::with('customer')->orderBy('id', 'desc')->get();
        return view('sale-returns.index', compact('saleReturns'));
    }

    
    public function create(Request $request)
    {
        if (!$request->has('sale_id')) {
            return view('sale-returns.lookup'); // show the input box only
        }

        $sale = Sale::with(['customer', 'items.product'])->find($request->sale_id);

        if (!$sale) {
            return redirect()->back()->with('error', 'Sale not found.');
        }
        
        $previousReturns = SaleReturn::with('items.product')
                            ->where('sale_id', $sale->id)
                            ->latest()
                            ->get();

        // You can also calculate sold quantity here
        // $products = $sale->items->map(function ($item) {
        //     $item->product->netSoldQty = $item->quantity;
        //     $item->product->selling_price = $item->rate;
        //     return $item->product;
        // });

        // $sale = Sale::with(['items', 'customer'])->findOrFail($saleId);

        $products = Product::all(); // or with stock if needed

        $filteredProducts = [];
        
        foreach ($products as $product) {
            // $stock = 0;
            // $sp = 0;

            // // Total stock (quantity + bonus) * pack
            // foreach ($product->purchaseStocks as $stockItem) {
            //     $bonusPack = ($stockItem->bonus ?? 0) + ($stockItem->quantity ?? 0);
            //     $stock += $bonusPack * ($stockItem->pack ?? 1);
            //     $sp = $stockItem->selling_price ?? 0;
            // }

            // // Sold quantity total (includes this sale)
            // $totalSold = 0;
            // foreach ($product->saleItems as $saleItem) {
            //     $totalSold += $saleItem->quantity ?? 0;
            // }

            // // Current sale's quantity for this product
            // $existingSaleItemQty = $sale->items->firstWhere('product_id', $product->id)?->quantity ?? 0;

            // // Exclude this sale's quantity from sold to get accurate available stock
            // $availableStock = $stock - ($totalSold - $existingSaleItemQty);

            // $product->stock = $availableStock;
            // $product->selling_price = $sp;
            $filteredProducts[] = $product;
        }

        return view('sale-returns.create', [
            'customer' => $sale->customer,
            'products' => $filteredProducts,
            'sale' => $sale,
            'previousReturns' => $previousReturns
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'customer_id' => 'required|exists:customers,id',
            'sales' => 'required|array',
            'total_refund' => 'required|numeric|min:0',
        ]);

        $saleReturn = SaleReturn::create([
            'sale_id' => $request->sale_id,
            'customer_id' => $request->customer_id,
            // 'return_date' => $request->return_date,
            'return_date' => $request->return_date,
            'reason' => $request->reason,
            'total_refund' => $request->total_refund ?? 0,
        ]);

        foreach ($request->sales as $item) {

            

        // Skip if quantity is not valid
        if (!isset($item['return_quantity']) || $item['return_quantity'] <= 0) {
            continue;
        }
            
            SaleReturnItem::create([
                'sale_return_id' => $saleReturn->id,
                'product_id' => $item['product_id'],
                'sale_item_id' => $item['sale_item_id'] ?? null,
                'quantity' => $item['return_quantity'],
                'rate' => $item['rate'],
                'remarks' => $item['remarks'] ?? null,
            ]);
        }

        return redirect()->route('sale-returns.index')->with('success', 'Sale Return added successfully.');
    }

    public function destroy($id)
    {
        $saleReturn = SaleReturn::findOrFail($id);
        $saleReturn->delete(); // Cascade will handle purchase_stocks

        return response()->json(['success' => true, 'message' => 'Sale deleted successfully.']);
    }

}
