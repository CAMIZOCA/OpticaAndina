<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'short_description',
        'description', 'attributes', 'is_available', 'is_featured', 'is_active',
        'sort_order', 'whatsapp_text', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'attributes'   => 'array',
        'is_available' => 'boolean',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function getCoverImageAttribute(): ?ProductImage
    {
        return $this->images->firstWhere('is_cover', true) ?? $this->images->first();
    }

    public function getWhatsappUrlAttribute(): string
    {
        $number = SiteSetting::get('whatsapp_number', '593999999999');
        $text = $this->whatsapp_text
            ?? "Hola, me interesa el producto: {$this->name} ({$this->category?->name}). ¿Podría darme más información?";

        return 'https://wa.me/' . $number . '?text=' . urlencode($text);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
