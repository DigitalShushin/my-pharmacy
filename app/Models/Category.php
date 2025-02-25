<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Ensure this matches your database table
    protected $fillable = ['name']; // Define fillable attributes

    // Create a category
    public static function createCategory($data)
    {
        return self::create([
            'name' => $data['name'],
        ]);
    }

    // Update a category
    public static function updateCategory($id, $data)
    {
        $category = self::findOrFail($id);
        return $category->update([
            'name' => $data['name'],
        ]);
    }
}
