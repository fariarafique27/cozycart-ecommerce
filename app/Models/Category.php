<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // A category can have many products 🧸🧸🧸
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Automatically generate slugs when adding categories
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function canBeDeleted(): bool
    {
        // Returns true if no products exist, false otherwise
        return !$this->products()->exists();
    }

    public static function getCount(): int
    {
        return self::count();
    }
}