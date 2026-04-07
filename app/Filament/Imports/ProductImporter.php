<?php

namespace App\Filament\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms;
use Illuminate\Support\Arr;
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
                ->fillRecordUsing(fn () => null)
                ->example('Gafas de Sol|Lentes de Hombre'),

            ImportColumn::make('brand')
                ->label('Marca (nombre)')
                ->rules(['nullable', 'string', 'max:255'])
                ->fillRecordUsing(fn () => null)
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

    public static function getOptionsFormComponents(): array
    {
        return [
            Forms\Components\Toggle::make('create_brands_automatically')
                ->label('Crear marcas automáticamente si no existen')
                ->helperText('Si una marca del CSV no se encuentra (ni por coincidencia similar ≥75%), se creará automáticamente.')
                ->default(false),

            Forms\Components\Section::make('Vista previa y mapeo de categorías')
                ->description('Para cada categoría detectada en el CSV, selecciona la categoría de destino en la base de datos.')
                ->schema(function (Forms\Get $get): array {
                    $fileList  = (array) ($get('file') ?? []);
                    $fileValue = Arr::first($fileList);

                    if (empty($fileValue)) {
                        return [
                            Forms\Components\Placeholder::make('cat_hint')
                                ->label('')
                                ->content('Sube el archivo CSV primero para ver el mapeo de categorías.'),
                        ];
                    }

                    $uniqueCategories = self::extractUniqueCsvCategories($fileValue);

                    if (empty($uniqueCategories)) {
                        return [
                            Forms\Components\Placeholder::make('cat_empty')
                                ->label('')
                                ->content('No se detectaron categorías en el archivo.'),
                        ];
                    }

                    $dbCategories = Category::orderBy('name')->pluck('name', 'id')->toArray();
                    $components   = [];

                    foreach (array_values($uniqueCategories) as $i => $csvName) {
                        $suggested = self::suggestCategoryId($csvName, $dbCategories);

                        $components[] = Forms\Components\Group::make([
                            Forms\Components\Hidden::make("category_map.{$i}.csv_name")
                                ->default($csvName),
                            Forms\Components\Select::make("category_map.{$i}.db_id")
                                ->label("CSV: \"{$csvName}\"")
                                ->options($dbCategories)
                                ->default($suggested)
                                ->searchable()
                                ->nullable()
                                ->placeholder('Ignorar (no asignar)'),
                        ]);
                    }

                    return $components;
                })
                ->live(),
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

        // Resolve brand with fuzzy matching
        if (!empty($this->data['brand'])) {
            $brand = $this->resolveBrand($this->data['brand']);
            if ($brand) {
                $this->record->brand_id = $brand->id;
                $this->record->save();
            }
        }

        // Resolve categories using the options map + exact DB match fallback
        if (!empty($this->data['categories'])) {
            $names = array_map('trim', explode('|', $this->data['categories']));
            $ids   = $this->resolveCategoryIds($names);
            if (!empty($ids)) {
                $this->record->categories()->sync($ids);
            }
        }
    }

    private function resolveBrand(string $csvName): ?Brand
    {
        // 1. Exact match by name or slug
        $brand = Brand::where('name', $csvName)
            ->orWhere('slug', Str::slug($csvName))
            ->first();
        if ($brand) return $brand;

        // 2. Fuzzy match (similar_text >= 75%)
        $bestScore = 0;
        $bestBrand = null;
        foreach (Brand::all() as $candidate) {
            similar_text(
                mb_strtolower($csvName),
                mb_strtolower($candidate->name),
                $pct
            );
            if ($pct > $bestScore) {
                $bestScore = $pct;
                $bestBrand = $candidate;
            }
        }
        if ($bestScore >= 75) return $bestBrand;

        // 3. Auto-create if option enabled
        if (!empty($this->getOptions()['create_brands_automatically'])) {
            return Brand::create([
                'name'      => $csvName,
                'slug'      => Str::slug($csvName),
                'is_active' => true,
            ]);
        }

        return null;
    }

    private function resolveCategoryIds(array $csvNames): array
    {
        $optionMap = $this->getOptions()['category_map'] ?? [];

        // Build lookup: csv_name → db_id from the options map
        $nameToId = [];
        foreach ($optionMap as $entry) {
            if (!empty($entry['csv_name']) && !empty($entry['db_id'])) {
                $nameToId[$entry['csv_name']] = (int) $entry['db_id'];
            }
        }

        $ids = [];
        foreach ($csvNames as $name) {
            if (isset($nameToId[$name])) {
                $ids[] = $nameToId[$name];
            } else {
                // Fallback: exact match in DB
                $cat = Category::where('name', $name)->first();
                if ($cat) $ids[] = $cat->id;
            }
        }

        return array_values(array_unique(array_filter($ids)));
    }

    private static function extractUniqueCsvCategories(mixed $fileValue): array
    {
        try {
            $filePath = null;

            if ($fileValue instanceof \Symfony\Component\HttpFoundation\File\File) {
                $filePath = $fileValue->getRealPath();
            } elseif (is_string($fileValue) && filled($fileValue)) {
                $tmpFile  = \Livewire\Features\SupportFileUploads\TemporaryUploadedFile::createFromLivewire($fileValue);
                $filePath = $tmpFile?->getRealPath();
            }

            if (!$filePath || !file_exists($filePath)) return [];

            $reader = \League\Csv\Reader::createFromPath($filePath, 'r');
            $reader->setHeaderOffset(0);

            $unique = [];
            foreach ($reader->getRecords() as $row) {
                $raw = $row['categories'] ?? null;
                if (blank($raw)) continue;
                foreach (array_map('trim', explode('|', $raw)) as $name) {
                    if (filled($name)) $unique[$name] = $name;
                }
            }

            return array_values($unique);
        } catch (\Throwable) {
            return [];
        }
    }

    private static function suggestCategoryId(string $csvName, array $dbCategories): ?int
    {
        // Exact match
        $id = array_search($csvName, $dbCategories, true);
        if ($id !== false) return (int) $id;

        // Fuzzy match >= 60%
        $bestScore = 0;
        $bestId    = null;
        foreach ($dbCategories as $id => $name) {
            similar_text(mb_strtolower($csvName), mb_strtolower($name), $pct);
            if ($pct > $bestScore) {
                $bestScore = $pct;
                $bestId    = $id;
            }
        }

        return ($bestScore >= 60) ? (int) $bestId : null;
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
