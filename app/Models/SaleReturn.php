<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    protected $table = 'sale_returns';

    protected $casts = [
        'return_date' => 'date',
    ];

    protected $fillable = [
        'sale_id',
        'customer_id',
        'return_date',
        'reason',
        'total_refund',
    ];	
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // public function items()
    // {
    //     return $this->hasMany(SalesItem::class);
    // }

    public function items()
{
    return $this->hasMany(SaleReturnItem::class);
}

}
