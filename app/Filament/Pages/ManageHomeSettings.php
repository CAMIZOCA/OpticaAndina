<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManageHomeSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Página de Inicio';
    protected static ?string $title = 'Página de Inicio';
    protected static ?int $navigationSort = 3;

    protected const JSON_KEYS = [
        'about_features',
        'home_process',
        'home_sections_order',
    ];

    public static function homeSectionOptions(): array
    {
        return [
            'services'          => '🔧 Nuestros Servicios',
            'stats'             => '📊 Estadísticas (Nos avala…)',
            'about'             => '💡 Cuidado profesional y personalizado',
            'process'           => '⚙️  Nuestro Proceso',
            'service_gallery'   => '🖼️  Galería de Servicios',
            'featured_products' => '🛍️  Productos Destacados',
            'brands'            => '🏷️  Marcas',
            'categories'        => '📁 Categorías',
            'latest_posts'      => '📰 Artículos Recientes',
            'faq'               => '❓ Preguntas Frecuentes',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
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
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Imagen lateral del Hero')
                            ->image()->disk('public')->directory('pages')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->maxSize(3072)->imagePreviewHeight('120')
                            ->helperText('Tamaño recomendado: 900×700 px.'),
                        Forms\Components\FileUpload::make('about_image')
                            ->label('Imagen sección "Cuidado profesional"')
                            ->image()->disk('public')->directory('pages')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->maxSize(3072)->imagePreviewHeight('120')
                            ->helperText('Tamaño recomendado: 800×600 px.'),
                    ]),

                Forms\Components\Section::make('Artículos recientes del Blog')
                    ->schema([
                        Forms\Components\Select::make('home_articles_count')
                            ->label('Cantidad de artículos a mostrar en el inicio')
                            ->options(['2' => '2 artículos', '3' => '3 artículos', '4' => '4 artículos', '6' => '6 artículos'])
                            ->default('3'),
                    ]),

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
                                Forms\Components\TextInput::make('url')
                                    ->label('Enlace del paso (opcional)')
                                    ->url()
                                    ->placeholder('https://opticaandina.com/servicios/examen-visual')
                                    ->helperText('Si se completa, el paso se convierte en un enlace clickeable.'),
                            ])
                            ->defaultItems(4)->reorderable()->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    ]),

                Forms\Components\Section::make('Reorganizar secciones de la página de inicio')
                    ->description('Arrastra las filas para cambiar el orden de aparición. El Hero siempre va primero.')
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
            ])
            ->statePath('data');
    }
}
