<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id', 'name', 'description'];

    protected static function booted()
    {
        parent::booted();
        self::addGlobalScope(new IsActiveScope);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function cheapestProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');
    }

    public function mostExpensiveProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }
}
