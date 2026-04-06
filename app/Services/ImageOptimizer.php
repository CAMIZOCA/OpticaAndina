<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageOptimizer
{
    /**
     * MIME types that can be meaningfully processed by Intervention Image + GD.
     * SVG (vector/text) and GIF (animation) are intentionally excluded.
     */
    private const OPTIMIZABLE = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    /**
     * Returns true when the given MIME type can be optimized.
     */
    public static function canOptimize(string $mimeType): bool
    {
        return in_array(strtolower(trim($mimeType)), self::OPTIMIZABLE, true);
    }

    /**
     * Optimize an image in-place on the public storage disk.
     *
     * - JPEG / WebP: applies quality reduction + optional downscale.
     * - PNG: applies downscale only (PNG encoding is lossless; quality is ignored).
     * - Other formats: skipped silently.
     *
     * @param  string  $storagePath  Relative path as stored in Media.path, e.g. "media/01ABC.webp"
     * @param  int     $quality      Compression quality 1–100 (JPEG/WebP only)
     * @param  int     $maxWidth     0 = no width limit; positive = scale down only, never up
     * @return array{size: int}      New file size in bytes; original size returned on any error
     */
    public static function optimize(
        string $storagePath,
        int $quality = 80,
        int $maxWidth = 1920
    ): array {
        $fullPath = Storage::disk('public')->path($storagePath);

        if (! file_exists($fullPath) || ! is_readable($fullPath)) {
            return ['size' => 0];
        }

        $originalSize = (int) filesize($fullPath);

        try {
            $manager = ImageManager::gd();
            $image   = $manager->read($fullPath);

            // Scale down only — never upscale a small image
            if ($maxWidth > 0 && $image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            // Detect format from the actual file content
            $mime = strtolower(mime_content_type($fullPath) ?: '');

            if (str_contains($mime, 'jpeg') || str_contains($mime, 'jpg')) {
                $image->toJpeg($quality)->save($fullPath);
            } elseif (str_contains($mime, 'webp')) {
                $image->toWebp($quality)->save($fullPath);
            } elseif (str_contains($mime, 'png')) {
                // PNG is lossless — quality parameter intentionally omitted
                $image->toPng()->save($fullPath);
            }
            // SVG/GIF reach here only if canOptimize() was bypassed — just skip

            // Clear PHP stat cache so filesize() reflects the new file
            clearstatcache(true, $fullPath);
            $newSize = @filesize($fullPath);

            return ['size' => $newSize !== false ? (int) $newSize : $originalSize];

        } catch (\Throwable $e) {
            Log::warning('ImageOptimizer: failed to optimize image', [
                'path'  => $storagePath,
                'error' => $e->getMessage(),
            ]);

            clearstatcache(true, $fullPath);
            $currentSize = @filesize($fullPath);

            return ['size' => $currentSize !== false ? (int) $currentSize : $originalSize];
        }
    }
}
