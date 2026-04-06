<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ManageContactSettings;
use App\Filament\Pages\ManageGeneralSettings;
use App\Filament\Pages\ManageHomeSettings;
use App\Filament\Pages\ManageNosotrosSettings;
use App\Filament\Pages\ManagePaymentSettings;
use App\Filament\Pages\ManageSeoSettings;
use App\Filament\Resources\BlogPostResource;
use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\MediaResource;
use App\Filament\Resources\FaqResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\RedirectResource;
use App\Filament\Resources\SeoMetaResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\StatResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\ConversionOverviewWidget;
use App\Filament\Widgets\ConversionPagesWidget;
use App\Filament\Widgets\RecentContactMessages;
use App\Filament\Widgets\SiteOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->profile(isSimple: false)
            ->brandName('Óptica Andina')
            ->colors([
                'primary' => Color::Teal,
            ])
            ->resources([
                BlogPostResource::class,
                BrandResource::class,
                CategoryResource::class,
                ContactMessageResource::class,
                MediaResource::class,
                FaqResource::class,
                ProductResource::class,
                RedirectResource::class,
                SeoMetaResource::class,
                ServiceResource::class,
                StatResource::class,
                UserResource::class,
            ])
            ->pages([
                Pages\Dashboard::class,
                ManageGeneralSettings::class,
                ManageContactSettings::class,
                ManageHomeSettings::class,
                ManageNosotrosSettings::class,
                ManageSeoSettings::class,
                ManagePaymentSettings::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                SiteOverviewWidget::class,
                ConversionOverviewWidget::class,
                RecentContactMessages::class,
                ConversionPagesWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
