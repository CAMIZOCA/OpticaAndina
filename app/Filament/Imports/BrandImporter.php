<?php

namespace App\Filament\Imports;

use App\Models\Brand;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class BrandImporter extends Importer
{
    protected static ?string $model = Brand::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Nombre')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('Ray-Ban'),

            ImportColumn::make('slug')
                ->label('Slug (opcional, se genera automáticamente)')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('ray-ban'),

            ImportColumn::make('country')
                ->label('País de origen')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Estados Unidos'),

            ImportColumn::make('description')
                ->label('Descripción')
                ->rules(['nullable', 'string'])
                ->example('Marca líder en gafas de sol y óptica.'),

            ImportColumn::make('is_active')
                ->label('Activo (1=sí, 0=no)')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('1'),
        ];
    }

    public function resolveRecord(): ?Brand
    {
        $slug = $this->data['slug'] ?: Str::slug($this->data['name']);

        return Brand::firstOrNew(['slug' => $slug]);
    }

    protected function afterSave(): void
    {
        if (empty($this->record->slug)) {
            $this->record->slug = Str::slug($this->record->name);
            $this->record->save();
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Se importaron ' . number_format($import->successful_rows) . ' ' . str('marca')->plural($import->successful_rows) . '.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron.';
        }

        return $body;
    }
}
