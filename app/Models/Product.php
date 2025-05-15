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
}
