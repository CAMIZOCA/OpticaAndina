<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentContactMessages extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Mensajes de contacto recientes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger')
                    ->width('40px'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->copyable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->default('—')
                    ->limit(40),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.admin.resources.contact-messages.index'))
                    ->action(function ($record) {
                        if (! $record->is_read) {
                            $record->update(['is_read' => true]);
                        }
                    }),
            ])
            ->paginated(false);
    }
}
