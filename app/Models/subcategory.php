<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class subcategory extends Model
{
    protected $table = "sub_categories";
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(category::class);
    }
}