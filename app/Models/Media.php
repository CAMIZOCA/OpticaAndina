<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['filename', 'path', 'mime_type', 'size', 'alt'];

    protected $casts = [
        'size' => 'integer',
    ];

    public function getUrlAttribute(): ?string
    {
        return MediaUrl::image($this->path);
    }

    public function getFormattedSizeAttribute(): string
    {
        if ($this->size < 1024) {
            return $this->size . ' B';
        }
        if ($this->size < 1_048_576) {
            return round($this->size / 1024, 1) . ' KB';
        }
        return round($this->size / 1_048_576, 2) . ' MB';
    }
}
