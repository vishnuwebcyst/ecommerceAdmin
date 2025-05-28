<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_id',
        'total_price',
        "total_quantity",
        'remarks',
        'status',
        'payment_type',
        'payment_status',
        'discount',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProducts::class);
    }

    public function products()
    {
        return $this->hasManyThrough(product::class, OrderProducts::class, 'product_id', 'id', 'order_id', 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address(){
        return $this->hasOne(Address::class,"id","address_id");
    }


    public function product_image()
    {
        return $this->hasManyThrough(product_image::class, OrderProducts::class,"order_id","product_id","id","product_id");
    }



}
