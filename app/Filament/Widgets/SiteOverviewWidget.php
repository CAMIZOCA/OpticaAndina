<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Schema;

class SiteOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $unreadMessages = $this->safeCount(
            'contact_messages',
            fn () => ContactMessage::where('is_read', false)->count()
        );

        return [
            Stat::make('Entradas publicadas', $this->safeCount('blog_posts', fn () => BlogPost::published()->count()))
                ->description('Artículos visibles en el blog')
                ->icon('heroicon-o-newspaper')
                ->color('info'),

            Stat::make('Servicios activos', $this->safeCount('services', fn () => Service::active()->count()))
                ->description('Servicios visibles en el sitio')
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('success'),

            Stat::make('Productos en catálogo', $this->safeCount('products', fn () => Product::active()->count()))
                ->description('Productos disponibles')
                ->icon('heroicon-o-squares-2x2')
                ->color('warning'),

            Stat::make('Mensajes sin leer', $unreadMessages)
                ->description('Formularios de contacto nuevos')
                ->icon('heroicon-o-envelope')
                ->color($unreadMessages > 0 ? 'danger' : 'gray'),

            Stat::make('Marcas', $this->safeCount('brands', fn () => Brand::active()->count()))
                ->description('Marcas activas en el catálogo')
                ->icon('heroicon-o-tag')
                ->color('primary'),
        ];
    }

    private function safeCount(string $table, \Closure $query): int
    {
        try {
            if (!Schema::hasTable($table)) {
                return 0;
            }
            return (int) $query();
        } catch (\Throwable) {
            return 0;
        }
    }
}
