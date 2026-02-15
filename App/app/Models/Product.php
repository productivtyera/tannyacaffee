<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'category_id',
        'base_price',
        'image_path',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(ProductRecipe::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalHppAttribute()
    {
        return $this->recipes->sum(function ($recipe) {
            return $recipe->amount_needed * ($recipe->stock->price_per_unit ?? 0);
        });
    }

    public function getMarginAttribute()
    {
        $hpp = $this->total_hpp;
        if ($this->base_price <= 0) return 0;
        return (($this->base_price - $hpp) / $this->base_price) * 100;
    }

    public function getGrossProfitAttribute()
    {
        return $this->base_price - $this->total_hpp;
    }
}
