<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Servicios';
    protected static ?string $navigationGroup = 'Servicios';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información del servicio')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Service::class, 'slug', ignoreRecord: true),
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Resumen')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->label('Contenido')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Imagen')
                        ->image()
                        ->directory('services'),
                    Forms\Components\TextInput::make('icon')
                        ->label('Ícono Heroicon')
                        ->placeholder('heroicon-o-eye')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('Preguntas frecuentes (FAQs)')
                ->schema([
                    Forms\Components\Repeater::make('faqs')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('question')
                                ->label('Pregunta')
                                ->required(),
                            Forms\Components\Textarea::make('answer')
                                ->label('Respuesta')
                                ->required()
                                ->rows(3),
                        ])
                        ->columns(1)
                        ->collapsible(),
                ]),

            Forms\Components\Section::make('Call to Action')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('cta_text')
                        ->label('Texto del botón CTA')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('cta_whatsapp_text')
                        ->label('Mensaje WhatsApp')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Opciones y SEO')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Orden')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Activo')
                        ->default(true),
                    Forms\Components\TextInput::make('meta_title')
                        ->label('Meta título')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('meta_description')
                        ->label('Meta descripción')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Imagen'),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Activo')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Orden')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
