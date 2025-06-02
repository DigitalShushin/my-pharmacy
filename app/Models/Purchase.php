<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'invoice_number',
        'purchase_date', // include this line for date
        'net_amount',
        'vat',
        'discount',
        'total_amount',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function stocks() {
        return $this->hasMany(PurchaseStock::class);
    }
}
