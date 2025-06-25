<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'category_id', 'company_id', 'image_path', 'min_stock'
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTotalStockAttribute()
    {
        return $this->purchaseStocks->sum(function ($stock) {
            return $stock->quantity + $stock->bonus;
        });
    }
}
