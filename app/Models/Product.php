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

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price', 'selected_options', 'image_url')
            ->withTimestamps();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $attributes = [ //valores predeterminaods para ciertos atributos
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

}
