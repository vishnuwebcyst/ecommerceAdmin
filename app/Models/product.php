<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    public function image()
    {
        return $this->hasOne('App\Models\product_image', "product_id", "id");
    }
    public function category()
    {
        return $this->hasOne('App\Models\category', "id", "category_id");
    }
    public function sub_category()
    {
        return $this->hasOne('App\Models\subcategory', "id", "subcategory_id");
    }
    public function units()
    {
        return $this->hasOne('App\Models\unit', "id", "unit_type");
    }
    public function product_units()
    {
        return $this->hasMany('App\Models\product_unit', "product_id", "id");
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProducts::class, 'product_id', 'id');
    }

    public function scopeBestSellers($query, $limit = 10)
    {
        return $query->with('image')
            ->join('order_products', 'products.id', '=', 'order_products.product_id')
            ->select('products.*', DB::raw('SUM(order_products.quantity) as total_quantity_sold'))
            ->groupBy('products.id')
            ->orderByDesc('total_quantity_sold')
            ->take($limit);
    }

    public function scopeTrending($query, $limit = 10)
    {
        // return $query->with(['image', 'product_units']) // Eager load images and units
        //     ->join('order_products', 'products.id', '=', 'order_products.product_id')
        //     ->join('product_units', 'order_products.product_unit_id', '=', 'product_units.id')
        //     ->select(
        //         'products.id',
        //         'products.name',
        //         'products.description',
        //         DB::raw('SUM(order_products.quantity) as total_recent_sales'),
        //         DB::raw('AVG(product_units.price) as average_unit_price')
        //     ) // Average price, or you could use MIN/MAX
        //     ->where('order_products.created_at', '>=', now()->subDays(30)) // Filter by last 30 days
        //     ->groupBy('products.id', 'products.name', 'products.description')
        //     ->orderByDesc('total_recent_sales')
        //     ->take($limit);
        return $query->with(['image', 'product_units', 'orderProducts'])
            ->whereHas('orderProducts', function ($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->select(
                'products.id',
                'products.name',
                'products.description',
                DB::raw('SUM(orderProducts.quantity) as total_recent_sales'),
                DB::raw('AVG(product_units.price) as average_unit_price')
            ) // Average price, or you could use MIN/MAX
            ->groupBy('products.id', 'products.name', 'products.description')
            ->orderByDesc('total_recent_sales')
            ->take($limit);
    }

    public function scopeBestDeals($query, $limit = 10)
    {
        return $query->with('image')
            ->select('products.*', DB::raw('(price - discount_price) as discount_amount'))
            ->whereNotNull('discount_price')
            ->where('discount_price', '<', 'price') // Ensure discount price is less than the original price
            ->orderByDesc('discount_amount')
            ->take($limit);
    }
}
