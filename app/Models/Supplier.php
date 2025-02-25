<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    
    protected $table = 'suppliers'; // Ensure this matches your database table

    protected $fillable = ['id', 'name', 'contact_person', 'phone', 'email', 'address', 'companies_array', 'created_at', 'updated_at']; // Define fillable attributes
}
