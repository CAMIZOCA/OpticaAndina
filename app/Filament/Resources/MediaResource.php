<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use App\Services\ImageOptimizer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class MediaResource extends Resource
{
    protected static ?string $model           = Media::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galería de Medios';
    protected static ?string $modelLabel      = 'Imagen';
    protected static ?string $pluralModelLabel = 'Imágenes';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?int    $navigationSort  = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Imagen')
                ->schema([
                    Forms\Components\FileUpload::make('path')
                        ->label('Archivo')
                        ->image()
                        ->disk('public')
                        ->directory('media')
                        ->required()
                        ->maxSize(4096)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/gif'])
                        ->imagePreviewHeight('200')
                        ->downloadable()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('filename')
                        ->label('Nombre del archivo')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Nombre descriptivo para identificar la imagen.'),

                    Forms\Components\TextInput::make('alt')
                        ->label('Texto alternativo (SEO)')
                        ->maxLength(255)
                        ->helperText('Describe la imagen para accesibilidad y SEO.'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Vista previa')
                    ->disk('public')
                    ->width(80)
                    ->height(60)
                    ->extraImgAttributes(['class' => 'object-cover rounded']),

                Tables\Columns\TextColumn::make('filename')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextInputColumn::make('alt')
                    ->label('Alt text')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('formatted_size')
                    ->label('Tamaño')
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('size', $direction))
                    ->color(fn (Media $record): string => match (true) {
                        $record->size < 100_000  => 'success',  // < 100 KB
                        $record->size < 500_000  => 'warning',  // 100–500 KB
                        default                  => 'danger',   // > 500 KB
                    }),

                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Tipo')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subido')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Subir imagen'),
            ])
            ->filters([])
            ->actions([
                // ── Optimizar imagen individual ───────────────────────────────
                Tables\Actions\Action::make('optimize')
                    ->label('Optimizar')
                    ->icon('heroicon-o-sparkles')
                    ->color('warning')
                    ->visible(fn (Media $record): bool => ImageOptimizer::canOptimize($record->mime_type ?? ''))
                    ->slideOver()
                    ->modalHeading('Optimizar imagen')
                    ->modalDescription('Reduce el peso del archivo aplicando compresión y/o redimensionado. Para PNG solo aplica el redimensionado (formato sin pérdida).')
                    ->modalSubmitActionLabel('Optimizar ahora')
                    ->form([
                        Forms\Components\Select::make('quality')
                            ->label('Calidad (JPEG / WebP)')
                            ->options([
                                90 => 'Alta — 90%  (mínima pérdida)',
                                80 => 'Media — 80%  (recomendada)',
                                65 => 'Agresiva — 65%  (máxima compresión)',
                            ])
                            ->default(80)
                            ->required(),

                        Forms\Components\Select::make('max_width')
                            ->label('Ancho máximo')
                            ->options([
                                0    => 'Sin límite',
                                1920 => '1920 px  (recomendado, Full HD)',
                                1280 => '1280 px  (HD)',
                                800  => '800 px  (web ligera)',
                            ])
                            ->default(1920)
                            ->required(),
                    ])
                    ->action(function (Media $record, array $data): void {
                        $sizeBefore = $record->size;

                        $result = ImageOptimizer::optimize(
                            storagePath: $record->path,
                            quality:     (int) $data['quality'],
                            maxWidth:    (int) $data['max_width'],
                        );

                        $sizeAfter = $result['size'];
                        $record->update(['size' => $sizeAfter]);

                        $savedBytes = $sizeBefore - $sizeAfter;
                        $savedKb    = round(abs($savedBytes) / 1024, 1);
                        $percent    = $sizeBefore > 0
                            ? round((abs($savedBytes) / $sizeBefore) * 100, 1)
                            : 0;

                        if ($savedBytes > 0) {
                            Notification::make()
                                ->title('Imagen optimizada ✓')
                                ->body("Ahorro: {$savedKb} KB ({$percent}% de reducción).")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Sin cambios significativos')
                                ->body('La imagen ya estaba optimizada o no se pudo reducir más.')
                                ->info()
                                ->send();
                        }
                    }),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->before(function (Media $record) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($record->path);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // ── Optimizar en lote ─────────────────────────────────────
                    Tables\Actions\BulkAction::make('optimize_bulk')
                        ->label('Optimizar seleccionadas')
                        ->icon('heroicon-o-sparkles')
                        ->color('warning')
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records): void {
                            $totalSaved = 0;
                            $skipped    = 0;
                            $processed  = 0;

                            foreach ($records as $record) {
                                /** @var Media $record */
                                if (! ImageOptimizer::canOptimize($record->mime_type ?? '')) {
                                    $skipped++;
                                    continue;
                                }

                                $sizeBefore = $record->size;
                                $result     = ImageOptimizer::optimize($record->path); // defaults: 80, 1920px

                                $record->update(['size' => $result['size']]);
                                $totalSaved += max(0, $sizeBefore - $result['size']);
                                $processed++;
                            }

                            $savedKb = round($totalSaved / 1024, 1);

                            $body = "Se procesaron {$processed} imagen(es).";
                            if ($savedKb > 0) {
                                $body .= " Ahorro total: {$savedKb} KB.";
                            }
                            if ($skipped > 0) {
                                $body .= " {$skipped} omitida(s) (SVG/GIF no soportados).";
                            }

                            Notification::make()
                                ->title('Optimización completada')
                                ->body($body)
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records) {
                            foreach ($records as $record) {
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($record->path);
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit'   => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
