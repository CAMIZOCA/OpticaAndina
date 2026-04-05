<?php

namespace App\Filament\Resources;

use App\Filament\Imports\BrandImporter;
use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Form;
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
