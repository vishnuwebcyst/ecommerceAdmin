<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['image_link'];

    protected $casts = [
        'image_link' => 'string',
    ];

    public function getImageLinkAttribute()
    {
        if ($this->image) {
            $imageUrl = url($this->image);
        } else {
            $imageUrl = url('uploads/products/no-product-image.png');
        }
        return $imageUrl;
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(subcategory::class);
    }
}
