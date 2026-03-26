<?php

namespace App\Filament\Widgets;

use App\Models\ConversionEvent;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ConversionPagesWidget extends Widget
{
    protected static string $view = 'filament.widgets.conversion-pages-widget';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        if (! Schema::hasTable('conversion_events')) {
            return [
                'topPages' => collect(),
                'worstPages' => collect(),
            ];
        }

        $from = Carbon::now()->subDays(30);

        $pageViews = ConversionEvent::query()
            ->where('created_at', '>=', $from)
            ->where('event_name', 'page_view')
            ->selectRaw('page_path, count(*) as views')
            ->groupBy('page_path')
            ->pluck('views', 'page_path');

        $conversions = ConversionEvent::query()
            ->where('created_at', '>=', $from)
            ->whereIn('event_name', ['whatsapp_click', 'primary_cta_click', 'contact_form_submitted', 'appointment_form_submitted'])
            ->selectRaw('page_path, count(*) as conversions')
            ->groupBy('page_path')
            ->pluck('conversions', 'page_path');

        $topPages = collect($pageViews)
            ->sortDesc()
            ->take(5)
            ->map(fn ($views, $page) => [
                'page' => $page,
                'views' => (int) $views,
                'conversions' => (int) ($conversions[$page] ?? 0),
            ])
            ->values();

        $worstPages = collect($pageViews)
            ->filter(fn ($views) => (int) $views >= 10)
            ->map(function ($views, $page) use ($conversions) {
                $views = (int) $views;
                $conversionCount = (int) ($conversions[$page] ?? 0);

                return [
                    'page' => $page,
                    'views' => $views,
                    'conversions' => $conversionCount,
                    'rate' => $views > 0 ? round(($conversionCount / $views) * 100, 2) : 0,
                ];
            })
            ->sortBy([
                ['rate', 'asc'],
                ['views', 'desc'],
            ])
            ->take(5)
            ->values();

        return compact('topPages', 'worstPages');
    }
}
