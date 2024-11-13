<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación con valores de opciones
    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }
}
