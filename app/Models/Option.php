<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    // Permitir asignación masiva de estos campos
    protected $fillable = [
        'name',
        'values', // Asegúrate de permitir los valores
        'product_id', // Relaciona con el producto
    ];

    // Convierte el campo 'values' a un array cuando se obtenga
    protected $casts = [
        'values' => 'array',
    ];

    // Relación con el modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
