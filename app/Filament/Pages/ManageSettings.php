<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuración';
    protected static ?string $title = 'Configuración del sitio';
    protected static string $view = 'filament.pages.manage-settings';
    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::getAll();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Configuración')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')->label('Nombre del sitio')->required(),
                                Forms\Components\TextInput::make('site_tagline')->label('Slogan'),
                                Forms\Components\TextInput::make('founding_year')->label('Año de fundación'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Contacto')
                            ->schema([
                                Forms\Components\Textarea::make('address')->label('Dirección')->rows(2),
                                Forms\Components\TextInput::make('phone')->label('Teléfono'),
                                Forms\Components\TextInput::make('whatsapp_number')->label('Número WhatsApp (sin +)')->placeholder('593999000000'),
                                Forms\Components\Textarea::make('whatsapp_message')->label('Mensaje genérico WhatsApp')->rows(2),
                                Forms\Components\TextInput::make('email')->label('Email')->email(),
                                Forms\Components\TextInput::make('hours')->label('Horario de atención'),
                                Forms\Components\TextInput::make('maps_url')->label('URL Google Maps'),
                                Forms\Components\Textarea::make('maps_embed')->label('Código embed del mapa')->rows(4),
                            ]),
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')->label('Título SEO principal'),
                                Forms\Components\Textarea::make('seo_description')->label('Descripción SEO principal')->rows(3),
                                Forms\Components\FileUpload::make('og_image')->label('Imagen Open Graph')->image()->directory('seo'),
                                Forms\Components\TextInput::make('google_analytics')->label('Google Analytics ID')->placeholder('G-XXXXXXXXXX'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Redes sociales')
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')->label('Facebook')->url(),
                                Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                                Forms\Components\TextInput::make('tiktok_url')->label('TikTok')->url(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Flush the shared settings cache once (instead of per-key)
        SiteSetting::flushCache();

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }
}
