<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Specify the table name if it is different from the model name
    protected $table = 'categories';

    // Specify the columns that are mass assignable
    protected $fillable = ['id', 'name'];
}
