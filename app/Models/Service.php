<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'image', 'icon',
        'faqs', 'cta_text', 'cta_whatsapp_text', 'sort_order', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'faqs'      => 'array',
        'is_active' => 'boolean',
    ];

    public function getWhatsappUrlAttribute(): string
    {
        $number = SiteSetting::get('whatsapp_number', '593999999999');
        $text = $this->cta_whatsapp_text
            ?? "Hola, quisiera información sobre el servicio: {$this->title}. ¿Cuándo puedo agendar una cita?";

        return 'https://wa.me/' . $number . '?text=' . urlencode($text);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
