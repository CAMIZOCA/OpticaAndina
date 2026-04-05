<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Configuración';

    protected static ?string $navigationGroup = 'Ajustes';

    protected static ?string $title = 'Configuración del sitio';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?int $navigationSort = 1;

    /** Keys that store JSON arrays (Repeater fields). */
    protected const JSON_KEYS = [
        'nosotros_team',
        'about_features',
        'home_process',
        'home_sections_order',
    ];

    /** Available orderable sections on the home page. */
    public static function homeSectionOptions(): array
    {
        return [
            'services' => '🔧 Nuestros Servicios',
            'stats' => '📊 Estadísticas (Nos avala…)',
            'about' => '💡 Cuidado profesional y personalizado',
            'process' => '⚙️  Nuestro Proceso',
            'service_gallery' => '🖼️  Galería de Servicios',
            'featured_products' => '🛍️  Productos Destacados',
            'brands' => '🏷️  Marcas',
            'categories' => '📁 Categorías',
            'latest_posts' => '📰 Artículos Recientes',
            'faq' => '❓ Preguntas Frecuentes',
        ];
    }

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

                        // ─── General ─────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-building-storefront')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')->label('Nombre del sitio')->required(),
                                Forms\Components\TextInput::make('site_tagline')->label('Slogan'),
                                Forms\Components\TextInput::make('founding_year')->label('Año de fundación'),
                            ]),

                        // ─── Logos ───────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Logos')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Logo del Header')
                                    ->description('Se muestra en la barra de navegación superior (fondo blanco). Formatos: PNG, JPG, SVG, WebP. Tamaño recomendado: 320×80 px.')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_header')
                                            ->label('Logo header (escritorio)')->image()->disk('public')->directory('brand')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(2048)->imagePreviewHeight('80')->downloadable()
                                            ->helperText('Visible en pantallas medianas y grandes (≥768 px). Si no sube un logo, se mostrará el nombre del sitio en texto.'),
                                        Forms\Components\FileUpload::make('logo_mark')
                                            ->label('Logo móvil / isotipo (mobile)')->image()->disk('public')->directory('brand')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(1024)->imagePreviewHeight('60')->downloadable()
                                            ->helperText('Icono cuadrado que aparece en el header en móvil (<768 px). Tamaño recomendado: 80×80 px. Si no sube ninguno, se usará el archivo logo-mark.svg estático.'),
                                    ]),
                                Forms\Components\Section::make('Logo del Footer')
                                    ->description('Se muestra en el pie de página (fondo oscuro azul). Usa preferentemente una versión blanca o clara del logo. Tamaño recomendado: 160×50 px.')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_footer')
                                            ->label('Logo footer')->image()->disk('public')->directory('brand')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                                            ->maxSize(2048)->imagePreviewHeight('80')->downloadable()
                                            ->helperText('Si no sube un logo, se mostrará el isotipo por defecto.'),
                                    ]),
                            ]),

                        // ─── Contacto ────────────────────────────────────────
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

                        // ─── Página Inicio ───────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Página Inicio')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Hero principal')
                                    ->description('Texto destacado que aparece en la parte superior de la página de inicio.')
                                    ->schema([
                                        Forms\Components\TextInput::make('hero_title')
                                            ->label('Título del hero')->placeholder('Tu visión, nuestro compromiso'),
                                        Forms\Components\Textarea::make('hero_subtitle')
                                            ->label('Subtítulo del hero')->rows(3)
                                            ->placeholder('Más de 15 años cuidando la salud visual…'),
                                        Forms\Components\TextInput::make('hero_cta_text')
                                            ->label('Texto del botón CTA')->placeholder('Ver Catálogo'),
                                    ]),

                                Forms\Components\Section::make('Sección "Cuidado profesional y personalizado"')
                                    ->description('Bloque de texto + lista de características que aparece en el inicio.')
                                    ->schema([
                                        Forms\Components\TextInput::make('about_title')
                                            ->label('Título de la sección')
                                            ->placeholder('Cuidado profesional y personalizado'),
                                        Forms\Components\Textarea::make('about_content')
                                            ->label('Texto principal')->rows(4)
                                            ->placeholder('En Óptica Andina nos dedicamos a…'),
                                        Forms\Components\Repeater::make('about_features')
                                            ->label('Características destacadas (lista con ✓)')
                                            ->schema([
                                                Forms\Components\TextInput::make('feature')
                                                    ->label('Característica')
                                                    ->placeholder('Atención personalizada y profesional')
                                                    ->required(),
                                            ])
                                            ->defaultItems(4)->reorderable()->collapsible()
                                            ->helperText('Aparecen con un ✓ verde en el inicio.'),
                                    ]),

                                Forms\Components\Section::make('Imágenes del Inicio')
                                    ->description('Imágenes que aparecen en el hero y en la sección "Cuidado profesional".')
                                    ->schema([
                                        Forms\Components\FileUpload::make('hero_image')
                                            ->label('Imagen lateral del Hero')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                            ->maxSize(3072)
                                            ->imagePreviewHeight('120')
                                            ->helperText('Se muestra a la derecha del texto principal. Tamaño recomendado: 900×700 px.'),
                                        Forms\Components\FileUpload::make('about_image')
                                            ->label('Imagen sección "Cuidado profesional"')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                            ->maxSize(3072)
                                            ->imagePreviewHeight('120')
                                            ->helperText('Se muestra en la sección "Cuidado profesional y personalizado". Tamaño recomendado: 800×600 px.'),
                                    ]),

                                Forms\Components\Section::make('Artículos recientes del Blog')
                                    ->schema([
                                        Forms\Components\Select::make('home_articles_count')
                                            ->label('Cantidad de artículos a mostrar en el inicio')
                                            ->options(['2' => '2 artículos', '3' => '3 artículos', '4' => '4 artículos', '6' => '6 artículos'])
                                            ->default('3')
                                            ->helperText('Número de artículos del blog visibles en la página de inicio.'),
                                    ]),
                            ]),

                        // ─── Proceso ─────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Nuestro Proceso')
                            ->icon('heroicon-o-arrow-path')
                            ->schema([
                                Forms\Components\Section::make('Pasos del proceso')
                                    ->description('Pasos que se muestran en la sección "Nuestro Proceso" del inicio. Arrastra para reordenar.')
                                    ->schema([
                                        Forms\Components\Repeater::make('home_process')
                                            ->label('Pasos')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Título del paso')->required()->placeholder('Agendar Cita'),
                                                Forms\Components\Textarea::make('text')
                                                    ->label('Descripción')->rows(2)->required()
                                                    ->placeholder('Reserva tu cita en línea o por WhatsApp'),
                                                Forms\Components\TextInput::make('icon')
                                                    ->label('Ícono (Font Awesome)')->placeholder('fas fa-calendar')
                                                    ->helperText('Ej: fas fa-calendar · fas fa-eye · fas fa-glasses · fas fa-check-circle'),
                                            ])
                                            ->defaultItems(4)->reorderable()->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                                    ]),
                            ]),

                        // ─── Orden secciones inicio ──────────────────────────
                        Forms\Components\Tabs\Tab::make('Orden del Inicio')
                            ->icon('heroicon-o-bars-3')
                            ->schema([
                                Forms\Components\Section::make('Reorganizar secciones de la página de inicio')
                                    ->description('Arrastra las filas para cambiar el orden de aparición. Desactiva el toggle para ocultar una sección. El Hero siempre va primero y el CTA final siempre al último.')
                                    ->schema([
                                        Forms\Components\Repeater::make('home_sections_order')
                                            ->label('Secciones')
                                            ->schema([
                                                Forms\Components\Select::make('key')
                                                    ->label('Sección')
                                                    ->options(self::homeSectionOptions())
                                                    ->required()
                                                    ->distinct()
                                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                                Forms\Components\Toggle::make('visible')
                                                    ->label('Mostrar')
                                                    ->default(true)
                                                    ->inline(false),
                                            ])
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => self::homeSectionOptions()[$state['key'] ?? ''] ?? ($state['key'] ?? null))
                                            ->defaultItems(0)
                                            ->addActionLabel('+ Agregar sección'),
                                    ]),
                            ]),

                        // ─── Página Nosotros ─────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Página Nosotros')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Forms\Components\Section::make('Historia')
                                    ->schema([
                                        Forms\Components\Textarea::make('nosotros_historia_1')
                                            ->label('Párrafo 1 — Origen')->rows(4)
                                            ->placeholder('Óptica Andina nació en Tumbaco…'),
                                        Forms\Components\Textarea::make('nosotros_historia_2')
                                            ->label('Párrafo 2 — Trayectoria')->rows(4)
                                            ->placeholder('Con más de 15 años de experiencia…'),
                                        Forms\Components\Textarea::make('nosotros_historia_3')
                                            ->label('Párrafo 3 — Oferta actual')->rows(4)
                                            ->placeholder('Contamos con tecnología moderna…'),
                                    ]),
                                Forms\Components\Section::make('Imagen de la historia')
                                    ->schema([
                                        Forms\Components\FileUpload::make('nosotros_imagen')
                                            ->label('Foto del local / equipo')->image()
                                            ->disk('public')->directory('pages')
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                            ->maxSize(3072)->imagePreviewHeight('160')
                                            ->helperText('Tamaño recomendado: 800×600 px.'),
                                    ]),
                                Forms\Components\Section::make('Equipo')
                                    ->schema([
                                        Forms\Components\Repeater::make('nosotros_team')
                                            ->label('Miembros del equipo')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Nombre')->required()->placeholder('Dra. María García'),
                                                Forms\Components\TextInput::make('role')
                                                    ->label('Cargo')->required()->placeholder('Optómetra Certificada'),
                                                Forms\Components\FileUpload::make('photo')
                                                    ->label('Foto')->image()->disk('public')->directory('team')
                                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                                    ->maxSize(1024)->imagePreviewHeight('100'),
                                            ])
                                            ->reorderable()->collapsible()->defaultItems(0),
                                    ]),
                            ]),

                        // ─── SEO ─────────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\Section::make('Meta y Open Graph')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_title')
                                            ->label('Título SEO principal')
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('seo_description')
                                            ->label('Descripción SEO principal')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('og_image')
                                            ->label('Imagen Open Graph')
                                            ->image()
                                            ->disk('public')
                                            ->directory('seo')
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Analytics y seguimiento')
                                    ->description('Activa las herramientas pegando el código o ID correspondiente. Deja en blanco para desactivar.')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('google_analytics')
                                            ->label('Google Analytics 4 — Measurement ID')
                                            ->placeholder('G-XXXXXXXXXX')
                                            ->helperText('ID de medición de GA4'),

                                        Forms\Components\TextInput::make('microsoft_clarity')
                                            ->label('Microsoft Clarity — Project ID')
                                            ->placeholder('Ej: abcdef1234')
                                            ->helperText('Heatmaps y grabaciones de sesión (gratis)'),

                                        Forms\Components\TextInput::make('google_search_console')
                                            ->label('Google Search Console — verification content')
                                            ->placeholder('Sólo el valor del atributo content')
                                            ->helperText('De: <meta name="google-site-verification" content="ESTE_VALOR">')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('bing_site_auth')
                                            ->label('Bing Webmaster Tools — BingSiteAuth content')
                                            ->placeholder('Valor content de la verificación Bing')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('custom_head_scripts')
                                            ->label('Scripts personalizados en <head>')
                                            ->rows(5)
                                            ->helperText('HTML libre (Facebook Pixel, LinkedIn Insight, etc.). Se inyecta en el <head> de todas las páginas.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ─── Redes sociales ──────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Redes sociales')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')->label('Facebook')->url(),
                                Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                                Forms\Components\TextInput::make('tiktok_url')->label('TikTok')->url(),
                                Forms\Components\Textarea::make('instagram_widget_html')
                                    ->label('Widget de Instagram (código embed)')
                                    ->helperText('Pega aquí el código de embed de LightWidget, Behold.so u otro servicio de feed de Instagram. Si está vacío, se muestra un enlace al perfil.')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),

                        // ─── Stripe ───────────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('Stripe / Pagos')
                            ->icon('heroicon-o-credit-card')
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
                                            ->password()
                                            ->revealable(),
                                        Forms\Components\TextInput::make('stripe_secret_key')
                                            ->label('Clave secreta (Secret key)')
                                            ->placeholder('sk_live_...')
                                            ->helperText('Empieza con sk_test_ (pruebas) o sk_live_ (producción). Nunca compartas esta clave.')
                                            ->password()
                                            ->revealable(),
                                    ]),
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
            $stored = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $stored]);
        }

        SiteSetting::flushCache();

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }
}
