<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use App\Services\ImageOptimizer;
use Filament\Resources\Pages\CreateRecord;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['path'])) {
            $fullPath = storage_path('app/public/' . $data['path']);
            if (file_exists($fullPath)) {
                $data['mime_type'] = mime_content_type($fullPath) ?: 'application/octet-stream';
                $data['size']      = filesize($fullPath);
            } else {
                $data['mime_type'] = 'application/octet-stream';
                $data['size']      = 0;
            }
        }

        if (empty($data['filename'])) {
            $data['filename'] = basename($data['path'] ?? 'archivo');
        }

        // Auto-optimize on upload (quality 80, max 1920px by default)
        if (
            ! empty($data['path'])
            && ! empty($data['mime_type'])
            && ImageOptimizer::canOptimize($data['mime_type'])
        ) {
            $result       = ImageOptimizer::optimize($data['path']);
            $data['size'] = $result['size'];
        }

        return $data;
    }
}
