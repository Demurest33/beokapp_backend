<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'product_option_id'];

    // Relación con opción de producto
    public function productOption()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
