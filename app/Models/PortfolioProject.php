<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioProject extends Model
{
    protected $fillable = [
        'portfolio_id',
        'name',
        'description',
        'skills_used',
        'images',
        'project_url',
        'client_name'
    ];

    protected $casts = [
        'skills_used' => 'array',
        'images' => 'array'
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
} 