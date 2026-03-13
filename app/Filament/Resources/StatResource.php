<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatResource\Pages;
use App\Models\Stat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Estadísticas';
    protected static ?string $navigationGroup = 'Contenido';
    protected static ?int    $navigationSort  = 6;
    protected static ?string $modelLabel      = 'Estadística';
    protected static ?string $pluralModelLabel = 'Estadísticas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Cifra')
                ->description('Cada estadística muestra un número destacado con una etiqueta en la sección "Nos avala nuestra experiencia".')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label('Valor / Número')
                        ->required()
                        ->placeholder('6.500+')
                        ->helperText('Ej: 6500+, 15 años, 98%')
                        ->maxLength(30),

                    Forms\Components\TextInput::make('label')
                        ->label('Etiqueta')
                        ->required()
                        ->placeholder('Exámenes realizados')
                        ->maxLength(100),

                    Forms\Components\TextInput::make('icon')
                        ->label('Ícono (Font Awesome)')
                        ->placeholder('fas fa-eye')
                        ->helperText('Clase CSS de Font Awesome. Ej: fas fa-eye, fas fa-user, fas fa-star')
                        ->maxLength(80),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Orden')
                        ->numeric()
                        ->default(0)
                        ->helperText('Número menor = aparece primero.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Visible en el sitio')
                        ->default(true)
                        ->inline(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(60),

                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->searchable()
                    ->weight('bold')
                    ->size('lg'),

                Tables\Columns\TextColumn::make('label')
                    ->label('Etiqueta')
                    ->searchable(),

                Tables\Columns\TextColumn::make('icon')
                    ->label('Ícono')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activa'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
            'index'  => Pages\ListStats::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit'   => Pages\EditStat::route('/{record}/edit'),
        ];
    }
}
