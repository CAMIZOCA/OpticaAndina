<?php

namespace App\Filament\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Nombre del producto')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('Gafas Ray-Ban Aviator'),

            ImportColumn::make('slug')
                ->label('Slug (opcional)')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('gafas-ray-ban-aviator'),

            ImportColumn::make('categories')
                ->label('Categorías (nombres separados por |)')
                ->rules(['nullable', 'string'])
                ->example('Gafas de Sol|Lentes de Hombre'),

            ImportColumn::make('brand')
                ->label('Marca (nombre)')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Ray-Ban'),

            ImportColumn::make('short_description')
                ->label('Descripción corta')
                ->rules(['nullable', 'string'])
                ->example('Clásico estilo aviador con protección UV400.'),

            ImportColumn::make('description')
                ->label('Descripción completa')
                ->rules(['nullable', 'string'])
                ->example('Descripción detallada del producto.'),

            ImportColumn::make('is_available')
                ->label('Disponible (1=sí, 0=no)')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('1'),

            ImportColumn::make('is_featured')
                ->label('Destacado (1=sí, 0=no)')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('0'),

            ImportColumn::make('is_active')
                ->label('Activo (1=sí, 0=no)')
                ->boolean()
                ->rules(['nullable', 'boolean'])
                ->example('1'),

            ImportColumn::make('whatsapp_text')
                ->label('Texto WhatsApp personalizado (opcional)')
                ->rules(['nullable', 'string'])
                ->example('Hola, me interesa este producto.'),

            ImportColumn::make('sort_order')
                ->label('Orden (número)')
                ->numeric()
                ->rules(['nullable', 'integer', 'min:0'])
                ->example('0'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        $slug = $this->data['slug'] ?: Str::slug($this->data['name']);

        return Product::firstOrNew(['slug' => $slug]);
    }

    protected function afterSave(): void
    {
        // Auto-generate slug if missing
        if (empty($this->record->slug)) {
            $this->record->slug = Str::slug($this->record->name);
            $this->record->save();
        }

        // Resolve brand by name
        if (!empty($this->data['brand'])) {
            $brand = Brand::where('name', $this->data['brand'])
                ->orWhere('slug', Str::slug($this->data['brand']))
                ->first();
            if ($brand) {
                $this->record->brand_id = $brand->id;
                $this->record->save();
            }
        }

        // Resolve categories by name (pipe-separated)
        if (!empty($this->data['categories'])) {
            $names = array_map('trim', explode('|', $this->data['categories']));
            $categoryIds = Category::whereIn('name', $names)->pluck('id')->toArray();
            if (!empty($categoryIds)) {
                $this->record->categories()->sync($categoryIds);
            }
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Se importaron ' . number_format($import->successful_rows) . ' ' . str('producto')->plural($import->successful_rows) . '.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron.';
        }

        return $body;
    }
}
