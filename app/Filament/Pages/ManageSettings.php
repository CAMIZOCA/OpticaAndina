<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configuración';
    protected static ?string $title = 'Configuración del sitio';
    protected static string $view = 'filament.pages.manage-settings';
    protected static ?int $navigationSort = 99;

    /** Keys that store JSON arrays (Repeater, etc.) */
    protected const JSON_KEYS = [
        'nosotros_team',
        'about_features',
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::getAll();

        // Decode JSON fields so Filament Repeater receives arrays
        foreach (self::JSON_KEYS as $key) {
            if (isset($settings[$key]) && is_string($settings[$key])) {
                $decoded = json_decode($settings[$key], true);
                $settings[$key] = is_array($decoded) ? $decoded : [];
            }
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Configuración')
                    ->tabs([
                        // ─── General ───────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-building-storefront')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')->label('Nombre del sitio')->required(),
                                Forms\Components\TextInput::make('site_tagline')->label('Slogan'),
                                Forms\Components\TextInput::make('founding_year')->label('Año de fundación'),
                            ]),

                        // ─── Logos ─────────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Logos')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Logo del Header')
                                    ->description('Se muestra en la barra de navegación superior (fondo blanco). Formatos: PNG, JPG, SVG, WebP. Tamaño recomendado: 320×80 px.')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_header')
                                            ->label('Logo header')
                                            ->image()
                                            ->disk('public')
                                            ->directory('brand')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(2048)
                                            ->imagePreviewHeight('80')
                                            ->downloadable()
                                            ->helperText('Si no sube un logo, se mostrará el nombre del sitio en texto.'),
                                    ]),
                                Forms\Components\Section::make('Logo del Footer')
                                    ->description('Se muestra en el pie de página (fondo oscuro azul). Usa preferentemente una versión blanca o clara del logo. Tamaño recomendado: 160×50 px.')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_footer')
                                            ->label('Logo footer')
                                            ->image()
                                            ->disk('public')
                                            ->directory('brand')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(2048)
                                            ->imagePreviewHeight('80')
                                            ->downloadable()
                                            ->helperText('Si no sube un logo, se mostrará el isotipo por defecto.'),
                                    ]),
                            ]),

                        // ─── Contacto ──────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Contacto')
                            ->icon('heroicon-o-phone')
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

                        // ─── Página Inicio ─────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Página Inicio')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Hero principal')
                                    ->description('Texto destacado que aparece en la parte superior de la página de inicio.')
                                    ->schema([
                                        Forms\Components\TextInput::make('hero_title')
                                            ->label('Título del hero')
                                            ->placeholder('Tu visión, nuestro compromiso'),
                                        Forms\Components\Textarea::make('hero_subtitle')
                                            ->label('Subtítulo del hero')
                                            ->rows(3)
                                            ->placeholder('Más de 15 años cuidando la salud visual…'),
                                        Forms\Components\TextInput::make('hero_cta_text')
                                            ->label('Texto del botón CTA')
                                            ->placeholder('Ver Catálogo'),
                                    ]),
                                Forms\Components\Section::make('Sección "Sobre nosotros" en el inicio')
                                    ->description('Breve descripción de la óptica que aparece en el inicio.')
                                    ->schema([
                                        Forms\Components\Textarea::make('about_content')
                                            ->label('Texto principal')
                                            ->rows(4)
                                            ->placeholder('En Óptica Vista Andina nos dedicamos a…'),
                                        Forms\Components\Repeater::make('about_features')
                                            ->label('Características destacadas')
                                            ->schema([
                                                Forms\Components\TextInput::make('feature')
                                                    ->label('Característica')
                                                    ->placeholder('Atención personalizada y profesional')
                                                    ->required(),
                                            ])
                                            ->defaultItems(4)
                                            ->reorderable()
                                            ->collapsible()
                                            ->helperText('Lista de puntos que destacan el servicio (aparecen con tick verde).'),
                                    ]),
                            ]),

                        // ─── Página Nosotros ───────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Página Nosotros')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Forms\Components\Section::make('Historia')
                                    ->schema([
                                        Forms\Components\Textarea::make('nosotros_historia_1')
                                            ->label('Párrafo 1 — Origen')
                                            ->rows(4)
                                            ->placeholder('Óptica Vista Andina nació en Tumbaco…'),
                                        Forms\Components\Textarea::make('nosotros_historia_2')
                                            ->label('Párrafo 2 — Trayectoria')
                                            ->rows(4)
                                            ->placeholder('Con más de 15 años de experiencia…'),
                                        Forms\Components\Textarea::make('nosotros_historia_3')
                                            ->label('Párrafo 3 — Oferta actual')
                                            ->rows(4)
                                            ->placeholder('Contamos con tecnología moderna…'),
                                    ]),
                                Forms\Components\Section::make('Imagen de la historia')
                                    ->schema([
                                        Forms\Components\FileUpload::make('nosotros_imagen')
                                            ->label('Foto del local / equipo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                            ->maxSize(3072)
                                            ->imagePreviewHeight('160')
                                            ->helperText('Se muestra junto al texto de la historia. Tamaño recomendado: 800×600 px.'),
                                    ]),
                                Forms\Components\Section::make('Equipo')
                                    ->schema([
                                        Forms\Components\Repeater::make('nosotros_team')
                                            ->label('Miembros del equipo')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Nombre')
                                                    ->required()
                                                    ->placeholder('Dra. María García'),
                                                Forms\Components\TextInput::make('role')
                                                    ->label('Cargo / Especialidad')
                                                    ->required()
                                                    ->placeholder('Optómetra Certificada'),
                                                Forms\Components\FileUpload::make('photo')
                                                    ->label('Foto')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('team')
                                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                                    ->maxSize(1024)
                                                    ->imagePreviewHeight('100'),
                                            ])
                                            ->reorderable()
                                            ->collapsible()
                                            ->defaultItems(0)
                                            ->helperText('Añade los integrantes del equipo que se mostrarán en la página Nosotros.'),
                                    ]),
                            ]),

                        // ─── SEO ───────────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')->label('Título SEO principal'),
                                Forms\Components\Textarea::make('seo_description')->label('Descripción SEO principal')->rows(3),
                                Forms\Components\FileUpload::make('og_image')->label('Imagen Open Graph')->image()->directory('seo'),
                                Forms\Components\TextInput::make('google_analytics')->label('Google Analytics ID')->placeholder('G-XXXXXXXXXX'),
                            ]),

                        // ─── Redes sociales ────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Redes sociales')
                            ->icon('heroicon-o-share')
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
            // Encode arrays (Repeater fields) as JSON for storage
            $stored = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $stored]);
        }

        // Flush the shared settings cache once
        SiteSetting::flushCache();

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }
}
