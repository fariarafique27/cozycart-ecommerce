<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder; // 👈 Make sure this is imported!
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'stock', 'image_path'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function hasEnoughStock(int $requestedQuantity): bool
    {
        return $this->stock >= $requestedQuantity;
    }

    public static function getCount(): int
    {
        return self::count();
    }

    // --- Scopes ---

    public function scopePrioritizeImages(Builder $query): Builder
    {
        return $query->orderByRaw('CASE WHEN image_path IS NULL THEN 1 ELSE 0 END ASC');
    }

    public function scopeFilterByCategory(Builder $query, ?string $slug): Builder
    {
        return $query->when($slug && $slug !== 'all', function ($q) use ($slug) {
            $q->whereHas('category', fn($sub) => $sub->where('slug', $slug));
        });
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }
}