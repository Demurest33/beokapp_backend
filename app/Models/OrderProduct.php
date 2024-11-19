<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';  // Define el nombre de la tabla intermedia

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'selected_options', 'image_url', 'product_name'
    ];

    protected $casts = [
        'selected_options' => 'array',  // Convertir las opciones seleccionadas a un array
    ];
}
