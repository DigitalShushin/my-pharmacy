<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'category_id', 'company_id', 'image_path'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function purchaseStocks()
    {
        return $this->hasMany(PurchaseStock::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SalesItem::class, 'product_id');
    }

    public function saleReturnItems()
    {
        return $this->hasMany(SaleReturnItem::class);
    }
}
