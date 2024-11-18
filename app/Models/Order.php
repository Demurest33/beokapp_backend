<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'pick_up_date', 'payment_type', 'total', 'message'
    ];

    public function user()
    {
        return $this->belongsTo(MyUser::class, 'user_id', 'id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price', 'selected_options', 'image_url')
            ->withTimestamps();
    }
}
