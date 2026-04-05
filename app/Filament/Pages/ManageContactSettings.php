<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManageContactSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'Contacto';
    protected static ?string $title = 'Contacto';
    protected static ?int $navigationSort = 2;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de contacto')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone')->label('Teléfono'),
                        Forms\Components\TextInput::make('email')->label('Email')->email(),
                        Forms\Components\TextInput::make('hours')->label('Horario de atención')->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('WhatsApp')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('Número WhatsApp (sin +)')
                            ->placeholder('593999000000'),
                        Forms\Components\Textarea::make('whatsapp_message')
                            ->label('Mensaje genérico WhatsApp')
                            ->rows(2)
                            ->helperText('Este mensaje se enviará al hacer clic en el botón de WhatsApp del header y el botón flotante.'),
                    ]),

                Forms\Components\Section::make('Dirección')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('Dirección principal')
                            ->rows(2)
                            ->helperText('Usada en schema JSON-LD, página de contacto y como respaldo en el header.'),
                        Forms\Components\TextInput::make('address_header')
                            ->label('Dirección en el header (opcional)')
                            ->helperText('Si se completa, esta dirección reemplaza a la dirección principal solo en el header. Útil para mostrar una versión más corta.'),
                    ]),

                Forms\Components\Section::make('Google Maps')
                    ->schema([
                        Forms\Components\TextInput::make('maps_url')->label('URL Google Maps'),
                        Forms\Components\Textarea::make('maps_embed')->label('Código embed del mapa')->rows(4),
                    ]),
            ])
            ->statePath('data');
    }
}
