<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Todas las Entradas';

    protected static ?string $navigationGroup = 'Entradas';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Artículo')
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
                        ->unique(BlogPost::class, 'slug', ignoreRecord: true),
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Resumen')
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content')
                        ->label('Contenido')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Imagen destacada')
                        ->image()
                        ->disk('public')
                        ->directory('blog'),
                    Forms\Components\TextInput::make('image_alt')
                        ->label('Alt de la imagen')
                        ->maxLength(255),
                    Forms\Components\TagsInput::make('tags')
                        ->label('Etiquetas')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Publicación y SEO')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->label('Publicado')
                        ->live(),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Fecha de publicación')
                        ->default(now()),
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
                Tables\Columns\ImageColumn::make('image')->label('Imagen')->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('Publicado')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Fecha')->dateTime('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('reading_time')->label('Lectura (min)')->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Publicado'),
            ])
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
