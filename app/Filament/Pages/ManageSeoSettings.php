<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManageSeoSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $navigationLabel = 'SEO y Redes';
    protected static ?string $title = 'SEO y Redes Sociales';
    protected static ?int $navigationSort = 5;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Meta y Open Graph')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Título SEO principal')->columnSpanFull(),
                        Forms\Components\Textarea::make('seo_description')
                            ->label('Descripción SEO principal')->rows(3)->columnSpanFull(),
                        Forms\Components\FileUpload::make('og_image')
                            ->label('Imagen Open Graph')->image()->disk('public')->directory('seo')
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

                Forms\Components\Section::make('Redes sociales')
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')->label('Facebook')->url(),
                        Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                        Forms\Components\TextInput::make('tiktok_url')->label('TikTok')->url(),
                        Forms\Components\Textarea::make('instagram_widget_html')
                            ->label('Widget de Instagram (código embed)')
                            ->helperText('Pega el código de embed de LightWidget, Behold.so u otro servicio.')
                            ->rows(5),
                    ]),
            ])
            ->statePath('data');
    }
}
