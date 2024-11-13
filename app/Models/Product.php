<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Permitir asignación masiva de estos campos
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'available',
        'category_id',
    ];

    // Opcional: establece valores predeterminados para ciertos atributos
    protected $attributes = [
        'available' => true,
    ];

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
