<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'short_description',
        'description', 'attributes', 'is_available', 'is_featured', 'is_active',
        'is_on_sale', 'price', 'is_purchasable', 'stripe_price_id',
        'sort_order', 'whatsapp_text', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'attributes'     => 'array',
        'is_available'   => 'boolean',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'is_on_sale'     => 'boolean',
        'is_purchasable' => 'boolean',
        'price'          => 'decimal:2',
    ];

    /** Categoría primaria (para rutas /catalogo/{category}/{product}). */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Todas las categorías del producto (many-to-many). */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
