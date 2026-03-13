<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model           = Redirect::class;
    protected static ?string $navigationIcon  = 'heroicon-o-arrow-path';
    protected static ?string $navigationLabel = 'Redirecciones';
    protected static ?string $modelLabel      = 'Redirección';
    protected static ?string $pluralModelLabel = 'Redirecciones';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Configuración de la redirección')
                ->description('Las rutas deben comenzar con /. El cambio tiene efecto inmediato (caché invalidada automáticamente).')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('from_path')
                        ->label('Ruta origen')
                        ->required()
                        ->maxLength(500)
                        ->placeholder('/pagina-antigua.html')
                        ->prefix(config('app.url'))
                        ->helperText('URL antigua que se quiere redirigir.')
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('to_path')
                        ->label('Ruta destino')
                        ->required()
                        ->maxLength(500)
                        ->placeholder('/nueva-pagina')
                        ->prefix(config('app.url'))
                        ->helperText('URL nueva a la que se redirige.')
                        ->columnSpan(2),

                    Forms\Components\Select::make('code')
                        ->label('Tipo de redirección')
                        ->required()
                        ->default(301)
                        ->options([
                            301 => '301 — Permanente (recomendado para SEO)',
                            302 => '302 — Temporal',
                        ])
                        ->native(false),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Activa')
                        ->default(true)
                        ->helperText('Desactiva para deshabilitar sin eliminar.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from_path')
                    ->label('Desde')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->from_path),

                Tables\Columns\TextColumn::make('to_path')
                    ->label('Hacia')
                    ->searchable()
                    ->limit(50)
                    ->color('success')
                    ->tooltip(fn ($record) => $record->to_path),

                Tables\Columns\BadgeColumn::make('code')
                    ->label('Tipo')
                    ->colors([
                        'success' => 301,
                        'warning' => 302,
                    ]),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activa'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modificado')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Estado'),
                Tables\Filters\SelectFilter::make('code')
                    ->label('Tipo')
                    ->options([301 => '301 Permanente', 302 => '302 Temporal']),
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
            ->defaultSort('from_path');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit'   => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
