<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model           = User::class;
    protected static ?string $navigationIcon  = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuarios admin';
    protected static ?string $modelLabel      = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?int    $navigationSort  = 98;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Información del usuario')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Correo electrónico')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(User::class, 'email', ignoreRecord: true),
                ]),

            Forms\Components\Section::make('Contraseña')
                ->description('Déjalo en blanco para mantener la contraseña actual al editar.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('password')
                        ->label('Nueva contraseña')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->maxLength(255)
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->helperText('Mínimo 8 caracteres.'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirmar contraseña')
                        ->password()
                        ->revealable()
                        ->same('password')
                        ->dehydrated(false)
                        ->required(fn (string $operation): bool => $operation === 'create'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Correo copiado'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última modificación')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Tables\Actions\DeleteAction $action, User $record) {
                        // Evitar que el usuario se borre a sí mismo
                        if ($record->id === auth()->id()) {
                            $action->cancel();
                            \Filament\Notifications\Notification::make()
                                ->title('No puedes eliminar tu propio usuario')
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
