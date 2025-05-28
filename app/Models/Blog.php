<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'author',
        'image'
    ];

    protected $appends = ['image_link'];

    protected $casts = [
        'image_link' => 'string',
    ];

    public function getImageLinkAttribute()
    {
        if ($this->image) {
            $imageUrl = url($this->image);
        } else {
            $imageUrl = url('uploads/blogs/broken-image.jpeg');
        }
        return $imageUrl;
    }
}
