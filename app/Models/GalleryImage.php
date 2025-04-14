<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'image_path',
        'caption',
        'sort_order'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
} 