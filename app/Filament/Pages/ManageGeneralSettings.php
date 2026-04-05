<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManageGeneralSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'General y Logos';
    protected static ?string $title = 'General y Logos';
    protected static ?int $navigationSort = 1;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información general')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')->label('Nombre del sitio')->required(),
                        Forms\Components\TextInput::make('site_tagline')->label('Slogan'),
                        Forms\Components\TextInput::make('founding_year')->label('Año de fundación'),
                    ]),

                Forms\Components\Section::make('Logo del Header')
                    ->description('Se muestra en la barra de navegación superior. Tamaño recomendado: 320×80 px.')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_header')
                            ->label('Logo header (escritorio)')->image()->disk('public')->directory('brand')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->maxSize(2048)->imagePreviewHeight('80')->downloadable()
                            ->helperText('Visible en pantallas medianas y grandes (≥768 px).'),
                        Forms\Components\FileUpload::make('logo_mark')
                            ->label('Logo móvil / isotipo')->image()->disk('public')->directory('brand')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->maxSize(1024)->imagePreviewHeight('60')->downloadable()
                            ->helperText('Icono cuadrado en mobile (<768 px). Tamaño recomendado: 80×80 px.'),
                    ]),

                Forms\Components\Section::make('Logo del Footer')
                    ->description('Se muestra en el pie de página (fondo oscuro). Tamaño recomendado: 160×50 px.')
                    ->schema([
                        Forms\Components\FileUpload::make('logo_footer')
                            ->label('Logo footer')->image()->disk('public')->directory('brand')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->maxSize(2048)->imagePreviewHeight('80')->downloadable(),
                    ]),

                Forms\Components\Section::make('Favicon')
                    ->description('Icono pequeño que aparece en la pestaña del navegador.')
                    ->schema([
                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('brand')
                            ->acceptedFileTypes(['image/x-icon', 'image/png', 'image/svg+xml', 'image/webp'])
                            ->maxSize(512)
                            ->imagePreviewHeight('48')
                            ->downloadable()
                            ->helperText('Formatos: .ico, .png, .svg, .webp. Tamaño recomendado: 32×32 px o 64×64 px.'),
                    ]),
            ])
            ->statePath('data');
    }
}
