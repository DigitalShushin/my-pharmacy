<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnItem extends Model
{
    use HasFactory;

    protected $table = 'sale_return_items';

    protected $fillable = [
        'sale_return_id',
        'product_id',
        'sale_item_id',
        'quantity',
        'rate',
        'remarks',
    ];	
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(PurchaseStock::class, 'stock_id');
    }

    public function saleReturn()
    {
        return $this->belongsTo(SaleReturn::class);
    }
}
