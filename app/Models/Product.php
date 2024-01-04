<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    // For Serialization
    protected $hidden = [
        'category_id'
    ];

    // For Serialization
    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];



    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
