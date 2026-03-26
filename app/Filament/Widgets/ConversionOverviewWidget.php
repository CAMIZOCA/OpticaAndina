<?php

namespace App\Filament\Widgets;

use App\Models\ConversionEvent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ConversionOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        if (! Schema::hasTable('conversion_events')) {
            return [
                Stat::make('Sesiones (30d)', 0)
                    ->description('Ejecuta migraciones para activar el tracking')
                    ->color('gray'),
            ];
        }

        $from = Carbon::now()->subDays(30);
        $baseQuery = ConversionEvent::query()->where('created_at', '>=', $from);

        $sessions = (clone $baseQuery)
            ->where('event_name', 'page_view')
            ->whereNotNull('session_token')
            ->distinct('session_token')
            ->count('session_token');

        $leads = (clone $baseQuery)
            ->where('event_category', 'lead')
            ->count();

        $whatsappClicks = (clone $baseQuery)
            ->where('event_name', 'whatsapp_click')
            ->count();

        $primaryCtaClicks = (clone $baseQuery)
            ->where('event_name', 'primary_cta_click')
            ->count();

        return [
            Stat::make('Sesiones (30d)', number_format($sessions))
                ->description('Pageviews agrupadas por visitante')
                ->icon('heroicon-o-users')
                ->color('info'),
            Stat::make('Leads (30d)', number_format($leads))
                ->description('Formularios enviados correctamente')
                ->icon('heroicon-o-envelope')
                ->color('success'),
            Stat::make('Clics WhatsApp (30d)', number_format($whatsappClicks))
                ->description('Conversaciones iniciadas')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('warning'),
            Stat::make('CTA principal (30d)', number_format($primaryCtaClicks))
                ->description('Botones principales del sitio')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->color('primary'),
        ];
    }
}
