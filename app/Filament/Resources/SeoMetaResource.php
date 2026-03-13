<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoMetaResource\Pages;
use App\Models\SeoMeta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoMetaResource extends Resource
{
    protected static ?string $model           = SeoMeta::class;
    protected static ?string $navigationIcon  = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationLabel = 'SEO por página';
    protected static ?string $modelLabel      = 'Meta SEO';
    protected static ?string $pluralModelLabel = 'Metas SEO';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?int    $navigationSort  = 1;

    /** Páginas del sitio disponibles */
    public static function pageKeyOptions(): array
    {
        return [
            'home'      => 'Inicio (home)',
            'nosotros'  => 'Nosotros',
            'servicios' => 'Servicios (listado)',
            'catalogo'  => 'Catálogo (listado)',
            'marcas'    => 'Marcas (listado)',
            'blog'      => 'Blog (listado)',
            'contacto'  => 'Contacto',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Identificación')
                ->schema([
                    Forms\Components\Select::make('page_key')
                        ->label('Página')
                        ->required()
                        ->options(self::pageKeyOptions())
                        ->native(false)
                        ->unique(SeoMeta::class, 'page_key', ignoreRecord: true)
                        ->helperText('Cada página puede tener solo un registro SEO.'),
                ]),

            Forms\Components\Section::make('Meta tags principales')
                ->description('Aparecen en los resultados de búsqueda de Google.')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título SEO')
                        ->maxLength(70)
                        ->helperText('Ideal: 50–60 caracteres. Se muestra en la pestaña del navegador y en Google.')
                        ->live(onBlur: true)
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('charCount')
                                ->label(fn ($state) => strlen($state ?? '') . '/70')
                                ->disabled()
                        ),

                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta descripción')
                        ->rows(3)
                        ->maxLength(160)
                        ->helperText('Ideal: 120–155 caracteres. Aparece debajo del título en Google.'),

                    Forms\Components\Toggle::make('noindex')
                        ->label('No indexar (noindex)')
                        ->helperText('Activa solo si quieres ocultar esta página de Google.'),

                    Forms\Components\TextInput::make('canonical')
                        ->label('URL canónica')
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://opticaandina.test/pagina')
                        ->helperText('Déjalo vacío para usar la URL actual automáticamente.'),
                ]),

            Forms\Components\Section::make('Open Graph (redes sociales)')
                ->description('Controla cómo se ve el enlace al compartir en Facebook, WhatsApp, etc.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('og_title')
                        ->label('Título OG')
                        ->maxLength(95)
                        ->placeholder('Si está vacío, usa el título SEO')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('og_description')
                        ->label('Descripción OG')
                        ->rows(2)
                        ->maxLength(300)
                        ->placeholder('Si está vacío, usa la meta descripción')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('og_image')
                        ->label('Imagen OG')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                        ->maxSize(2048)
                        ->imagePreviewHeight('120')
                        ->helperText('Tamaño recomendado: 1200×630 px. Máx. 2 MB.')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_key')
                    ->label('Página')
                    ->formatStateUsing(fn ($state) => self::pageKeyOptions()[$state] ?? $state)
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Título SEO')
                    ->limit(55)
                    ->tooltip(fn ($record) => $record->title)
                    ->searchable(),

                Tables\Columns\TextColumn::make('meta_description')
                    ->label('Meta descripción')
                    ->limit(80)
                    ->tooltip(fn ($record) => $record->meta_description)
                    ->toggleable(),

                Tables\Columns\ImageColumn::make('og_image')
                    ->label('Imagen OG')
                    ->disk('public')
                    ->width(60)
                    ->height(32),

                Tables\Columns\IconColumn::make('noindex')
                    ->label('Noindex')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye-slash')
                    ->falseIcon('heroicon-o-eye')
                    ->trueColor('danger')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modificado')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('noindex')->label('Noindex'),
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
            ->defaultSort('page_key');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSeoMetas::route('/'),
            'create' => Pages\CreateSeoMeta::route('/create'),
            'edit'   => Pages\EditSeoMeta::route('/{record}/edit'),
        ];
    }
}
