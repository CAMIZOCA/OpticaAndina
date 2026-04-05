<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;

class ManageNosotrosSettings extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Página Nosotros';
    protected static ?string $title = 'Página Nosotros';
    protected static ?int $navigationSort = 4;

    protected const JSON_KEYS = ['nosotros_team'];

    public function form(Form $form): Form
    {
        return $form
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
            ])
            ->statePath('data');
    }
}
