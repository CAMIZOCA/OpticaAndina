<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManagePaymentSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Stripe / Pagos';
    protected static ?string $title = 'Stripe / Pagos';
    protected static ?int $navigationSort = 6;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Compra online con Stripe')
                    ->description('Activa el botón "Comprar ahora" en productos marcados como comprables. Las claves se obtienen en dashboard.stripe.com.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('stripe_enabled')
                            ->label('Habilitar pagos con Stripe')
                            ->helperText('Muestra el botón de compra en productos con precio configurado.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('stripe_public_key')
                            ->label('Clave pública (Publishable key)')
                            ->placeholder('pk_live_...')
                            ->helperText('Empieza con pk_test_ (pruebas) o pk_live_ (producción).')
                            ->password()->revealable(),
                        Forms\Components\TextInput::make('stripe_secret_key')
                            ->label('Clave secreta (Secret key)')
                            ->placeholder('sk_live_...')
                            ->helperText('Nunca compartas esta clave.')
                            ->password()->revealable(),
                    ]),
            ])
            ->statePath('data');
    }
}
