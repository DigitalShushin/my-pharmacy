<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseStock extends Model
{
    use HasFactory;

    protected $table = 'purchase_stocks';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'batch',
        'pack',
        'quantity',
        'bonus',
        'rate',
        'cc',
        'cc_on_bonus',
        'marked_rate',
        'cost_price',
        'selling_price',
        'expiry_date'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
