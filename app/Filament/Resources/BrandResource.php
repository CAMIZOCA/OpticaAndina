<?php

namespace App\Filament\Resources;

use App\Filament\Imports\BrandImporter;
use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model           = Brand::class;
    protected static ?string $navigationIcon  = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Marcas';
    protected static ?string $modelLabel      = 'Marca';
    protected static ?string $pluralModelLabel = 'Marcas';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre de la marca')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                            $set('slug', Str::slug($state ?? ''))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->required()
                        ->maxLength(100)
                        ->unique(Brand::class, 'slug', ignoreRecord: true)
                        ->helperText('Se genera automáticamente desde el nombre.'),

                    Forms\Components\TextInput::make('country')
                        ->label('País de origen')
                        ->maxLength(60)
                        ->placeholder('Ej: Italia, USA, Ecuador'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Activa')
                        ->default(true),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Marca Destacada')
                        ->helperText('Las marcas destacadas aparecen primero y en formato ampliado.')
                        ->default(false),

                    Forms\Components\Textarea::make('description')
                        ->label('Descripción')
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Logo')
                ->description('PNG/WebP/SVG con fondo transparente. Tamaño recomendado: 400×200 px, máx. 1 MB.')
                ->schema([
                    Forms\Components\FileUpload::make('logo')
                        ->label('Logo de la marca')
                        ->image()
                        ->disk('public')
                        ->directory('brands')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                        ->maxSize(1024)
                        ->imagePreviewHeight('100')
                        ->downloadable(),
                ]),

            Forms\Components\Section::make('Contenido')
                ->description('Bloques de contenido que aparecen en la página de la marca. Puedes combinar texto, imágenes y galerías libremente.')
                ->schema([
                    Forms\Components\Repeater::make('content_blocks')
                        ->label('Bloques')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->label('Tipo de bloque')
                                ->options([
                                    'text'       => 'Texto',
                                    'image'      => 'Imagen',
                                    'image_text' => 'Imagen + Texto',
                                    'gallery'    => 'Galería de imágenes',
                                ])
                                ->required()
                                ->live()
                                ->columnSpanFull(),

                            // ── TEXT ─────────────────────────────────────────
                            Forms\Components\TextInput::make('heading')
                                ->label('Título (opcional)')
                                ->maxLength(255)
                                ->visible(fn (Get $get) => in_array($get('type'), ['text', 'image_text'])),

                            Forms\Components\RichEditor::make('body')
                                ->label('Contenido')
                                ->columnSpanFull()
                                ->visible(fn (Get $get) => in_array($get('type'), ['text', 'image_text'])),

                            // ── IMAGE ─────────────────────────────────────────
                            Forms\Components\FileUpload::make('path')
                                ->label('Imagen')
                                ->image()
                                ->disk('public')
                                ->directory('brands/content')
                                ->maxSize(3072)
                                ->visible(fn (Get $get) => $get('type') === 'image'),

                            Forms\Components\TextInput::make('alt')
                                ->label('Texto alternativo')
                                ->maxLength(255)
                                ->visible(fn (Get $get) => $get('type') === 'image'),

                            Forms\Components\TextInput::make('caption')
                                ->label('Pie de foto (opcional)')
                                ->maxLength(255)
                                ->visible(fn (Get $get) => $get('type') === 'image'),

                            Forms\Components\Select::make('width')
                                ->label('Ancho')
                                ->options(['full' => 'Ancho completo', 'half' => 'Mitad de pantalla'])
                                ->default('full')
                                ->visible(fn (Get $get) => $get('type') === 'image'),

                            // ── IMAGE_TEXT ────────────────────────────────────
                            Forms\Components\FileUpload::make('image_path')
                                ->label('Imagen')
                                ->image()
                                ->disk('public')
                                ->directory('brands/content')
                                ->maxSize(3072)
                                ->visible(fn (Get $get) => $get('type') === 'image_text'),

                            Forms\Components\TextInput::make('image_alt')
                                ->label('Texto alternativo de la imagen')
                                ->maxLength(255)
                                ->visible(fn (Get $get) => $get('type') === 'image_text'),

                            Forms\Components\Select::make('image_side')
                                ->label('Posición de la imagen')
                                ->options(['left' => 'Izquierda', 'right' => 'Derecha'])
                                ->default('left')
                                ->visible(fn (Get $get) => $get('type') === 'image_text'),

                            // ── GALLERY ───────────────────────────────────────
                            Forms\Components\Repeater::make('images')
                                ->label('Imágenes de la galería')
                                ->schema([
                                    Forms\Components\FileUpload::make('path')
                                        ->label('Imagen')
                                        ->image()
                                        ->disk('public')
                                        ->directory('brands/content')
                                        ->maxSize(3072),
                                    Forms\Components\TextInput::make('alt')
                                        ->label('Texto alternativo')
                                        ->maxLength(255),
                                ])
                                ->columns(2)
                                ->maxItems(16)
                                ->reorderable()
                                ->columnSpanFull()
                                ->visible(fn (Get $get) => $get('type') === 'gallery'),

                            Forms\Components\Select::make('columns')
                                ->label('Columnas en la galería')
                                ->options([2 => '2 columnas', 3 => '3 columnas', 4 => '4 columnas'])
                                ->default(3)
                                ->visible(fn (Get $get) => $get('type') === 'gallery'),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(fn (array $state): ?string => match ($state['type'] ?? null) {
                            'text'       => 'Texto: ' . Str::limit($state['heading'] ?? strip_tags($state['body'] ?? ''), 50),
                            'image'      => 'Imagen' . ($state['caption'] ? ': ' . $state['caption'] : ''),
                            'image_text' => 'Imagen + Texto: ' . Str::limit($state['heading'] ?? '', 50),
                            'gallery'    => 'Galería (' . count($state['images'] ?? []) . ' fotos)',
                            default      => 'Bloque sin tipo',
                        })
                        ->addActionLabel('Agregar bloque'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->width(80)
                    ->height(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('country')
                    ->label('País')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Productos')
                    ->counts('products')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacada')
                    ->boolean()
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activa'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modificado')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(BrandImporter::class)
                    ->label('Importar CSV')
                    ->icon('heroicon-o-arrow-up-tray'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Estado'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Destacada'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit'   => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
