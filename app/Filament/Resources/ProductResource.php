<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
                    Forms\Components\Select::make('category_id')
                        ->label('Categoría')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
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
                ->schema([
                    Forms\Components\Repeater::make('images')
                        ->relationship()
                        ->label('Imágenes del producto')
                        ->schema([
                            Forms\Components\FileUpload::make('path')
                                ->label('Imagen')
                                ->image()
                                ->directory('products')
                                ->required(),
                            Forms\Components\TextInput::make('alt')
                                ->label('Texto alternativo')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('sort_order')
                                ->label('Orden')
                                ->numeric()
                                ->default(0),
                            Forms\Components\Toggle::make('is_cover')
                                ->label('Imagen portada'),
                        ])
                        ->columns(2)
                        ->reorderable('sort_order'),
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
            ->modifyQueryUsing(fn ($query) => $query->with(['category', 'brand']))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
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
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
