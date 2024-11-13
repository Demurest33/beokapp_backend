<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'availability_start',
        'availability_end',
        'available_days'
    ];

    protected $casts = [
        'available_days' => 'array', // Para manejar los días como un array
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getAvailableDaysAttribute($value)
    {
        return json_decode($value);
    }

}
