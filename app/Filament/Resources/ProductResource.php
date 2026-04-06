<?php

namespace App\Filament\Resources;

use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Media;
use App\Models\Product;
use App\Support\MediaUrl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información principal')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('categories')
                        ->label('Categorías')
                        ->relationship('categories', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('brand_id')
                        ->label('Marca')
                        ->relationship('brand', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Product::class, 'slug', ignoreRecord: true),
                    Forms\Components\Textarea::make('short_description')
                        ->label('Descripción corta')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->label('Descripción completa')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Imágenes')
                ->description('Agrega imágenes eligiendo desde la galería de medios o subiendo nuevas.')
                ->schema([
                    Forms\Components\Repeater::make('images')
                        ->relationship()
                        ->label('Imágenes del producto')
                        ->schema([

                            // ── Almacena el path real (DB column) ─────────────
                            Forms\Components\Hidden::make('path'),

                            // ── Preview de la imagen actual ───────────────────
                            Forms\Components\Placeholder::make('image_preview')
                                ->label('Vista previa')
                                ->live()
                                ->content(function (Get $get): HtmlString {
                                    $path = $get('path');
                                    $url  = $path ? MediaUrl::image($path) : null;
                                    if ($url) {
                                        return new HtmlString(
                                            '<img src="' . e($url) . '" alt="Vista previa"
                                                 style="max-height:160px;max-width:100%;border-radius:0.5rem;object-fit:cover;"
                                                 loading="lazy">'
                                        );
                                    }
                                    return new HtmlString(
                                        '<div style="height:80px;display:flex;align-items:center;justify-content:center;'
                                        . 'background:#f3f4f6;border-radius:0.5rem;border:2px dashed #d1d5db;'
                                        . 'color:#9ca3af;font-size:0.875rem;">Sin imagen seleccionada</div>'
                                    );
                                })
                                ->columnSpanFull(),

                            // ── Botones de selección ──────────────────────────
                            Forms\Components\Actions::make([

                                // Botón 1: Elegir de la galería de medios
                                Forms\Components\Actions\Action::make('pick_from_gallery')
                                    ->label('Elegir de galería')
                                    ->icon('heroicon-o-photo')
                                    ->color('gray')
                                    ->slideOver()
                                    ->form([
                                        Forms\Components\Select::make('media_id')
                                            ->label('Imagen de la galería de medios')
                                            ->options(fn (): array => Media::orderByDesc('created_at')
                                                ->get()
                                                ->mapWithKeys(fn (Media $m) => [
                                                    $m->id => ($m->filename ?: basename($m->path)),
                                                ])
                                                ->all()
                                            )
                                            ->searchable()
                                            ->native(false)
                                            ->required()
                                            ->live()
                                            ->placeholder('Buscar imagen por nombre…')
                                            ->helperText('Las imágenes se administran en Contenido → Galería de Medios.'),

                                        Forms\Components\Placeholder::make('gallery_preview')
                                            ->label('Vista previa')
                                            ->content(function (Get $get): HtmlString {
                                                $mediaId = $get('media_id');
                                                if (! $mediaId) {
                                                    return new HtmlString(
                                                        '<p style="color:#9ca3af;font-size:0.875rem;">Selecciona una imagen para ver la vista previa.</p>'
                                                    );
                                                }
                                                $media = Media::find($mediaId);
                                                $url   = $media ? MediaUrl::image($media->path) : null;
                                                if (! $url) {
                                                    return new HtmlString('<p style="color:#9ca3af;">Imagen no disponible.</p>');
                                                }
                                                return new HtmlString(
                                                    '<img src="' . e($url) . '" alt="' . e($media->alt ?? '') . '"
                                                         style="max-height:220px;max-width:100%;border-radius:0.5rem;object-fit:cover;"
                                                         loading="lazy">'
                                                );
                                            }),
                                    ])
                                    ->action(function (array $data, Set $set): void {
                                        $media = Media::find($data['media_id']);
                                        if ($media) {
                                            $set('path', $media->path);
                                        }
                                    }),

                                // Botón 2: Subir imagen nueva (la registra también en Media)
                                Forms\Components\Actions\Action::make('upload_new_image')
                                    ->label('Subir imagen nueva')
                                    ->icon('heroicon-o-arrow-up-tray')
                                    ->color('primary')
                                    ->slideOver()
                                    ->form([
                                        Forms\Components\FileUpload::make('upload')
                                            ->label('Archivo de imagen')
                                            ->image()
                                            ->disk('public')
                                            ->directory('media')
                                            ->maxSize(4096)
                                            ->acceptedFileTypes([
                                                'image/jpeg',
                                                'image/png',
                                                'image/webp',
                                                'image/gif',
                                            ])
                                            ->imagePreviewHeight('160')
                                            ->required(),

                                        Forms\Components\TextInput::make('filename')
                                            ->label('Nombre descriptivo')
                                            ->maxLength(255)
                                            ->required()
                                            ->placeholder('Ej: Lente de sol modelo X – frontal'),

                                        Forms\Components\TextInput::make('upload_alt')
                                            ->label('Texto alternativo (SEO)')
                                            ->maxLength(255)
                                            ->placeholder('Describe la imagen para accesibilidad'),
                                    ])
                                    ->action(function (array $data, Set $set): void {
                                        $storagePath = $data['upload'];
                                        $mimeType    = Storage::disk('public')->mimeType($storagePath) ?: 'image/jpeg';
                                        $size        = Storage::disk('public')->size($storagePath) ?: 0;

                                        Media::create([
                                            'filename'  => $data['filename'],
                                            'path'      => $storagePath,
                                            'mime_type' => $mimeType,
                                            'size'      => $size,
                                            'alt'       => $data['upload_alt'] ?? null,
                                        ]);

                                        $set('path', $storagePath);
                                    }),

                            ])->columnSpanFull(),

                            // ── Metadatos de la imagen ────────────────────────
                            Forms\Components\TextInput::make('alt')
                                ->label('Texto alternativo')
                                ->maxLength(255),

                            Forms\Components\Toggle::make('is_cover')
                                ->label('Imagen portada'),
                        ])
                        ->columns(2)
                        ->reorderable('sort_order')
                        ->addActionLabel('Agregar imagen'),
                ]),

            Forms\Components\Section::make('Opciones')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_available')
                        ->label('Disponible')
                        ->default(true),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Destacado'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Activo')
                        ->default(true),
                    Forms\Components\Toggle::make('is_on_sale')
                        ->label('En liquidación')
                        ->helperText('Aparece en la sección Liquidación del catálogo.')
                        ->default(false),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Orden')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Textarea::make('whatsapp_text')
                        ->label('Texto personalizado WhatsApp')
                        ->placeholder('Dejar vacío para usar el texto automático')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Compra online (Stripe)')
                ->description('Activa la compra directa por Stripe para este producto. Requiere que Stripe esté habilitado en Configuración del sitio.')
                ->columns(2)
                ->collapsed()
                ->schema([
                    Forms\Components\Toggle::make('is_purchasable')
                        ->label('Permitir compra online')
                        ->helperText('Muestra el botón "Comprar" en la página del producto.')
                        ->default(false),
                    Forms\Components\TextInput::make('price')
                        ->label('Precio (USD)')
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0)
                        ->step(0.01)
                        ->helperText('Precio para Stripe. Dejar vacío si no se vende online.'),
                    Forms\Components\TextInput::make('stripe_price_id')
                        ->label('Stripe Price ID (opcional)')
                        ->placeholder('price_...')
                        ->helperText('Si tienes un Price creado en el dashboard de Stripe, pégalo aquí.')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('SEO')
                ->columns(1)
                ->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta título')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta descripción')
                        ->rows(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['categories', 'brand']))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categorías')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Disponible')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_on_sale')
                    ->label('Oferta')
                    ->boolean()
                    ->trueColor('danger')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(ProductImporter::class)
                    ->label('Importar CSV')
                    ->icon('heroicon-o-arrow-up-tray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categories')->relationship('categories', 'name'),
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Activo'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Destacado'),
                Tables\Filters\TernaryFilter::make('is_on_sale')->label('En liquidación'),
                Tables\Filters\TernaryFilter::make('is_purchasable')->label('Compra online'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
