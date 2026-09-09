<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;

use App\Http\Middleware\RedirectUnauthorizedFilamentUser;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;

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

            ->databaseNotifications()

            ->colors([
                'primary' => Color::Amber,
            ])

            ->brandName('IT Asset Management')

            ->brandLogo(asset('images/favicon.png'))

            ->brandLogoHeight('40px')

            ->sidebarCollapsibleOnDesktop()


            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )


            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )


            ->pages([
                Dashboard::class,
            ])


            ->widgets([])


            ->middleware([

                EncryptCookies::class,

                AddQueuedCookiesToResponse::class,

                StartSession::class,

                AuthenticateSession::class,

                /*
                 * ======================================================
                 * DASHBOARD ACCESS CHECK
                 * ======================================================
                 *
                 * User:
                 *
                 * super_admin  -> boleh
                 * staff_it     -> boleh
                 * permission > 0 -> boleh
                 * permission = 0 -> /permintaan-it
                 *
                 */

                RedirectUnauthorizedFilamentUser::class,

                ShareErrorsFromSession::class,

                VerifyCsrfToken::class,

                SubstituteBindings::class,

                DisableBladeIconComponents::class,

                DispatchServingFilamentEvent::class,

            ])


            ->authMiddleware([

                Authenticate::class,

            ])


            ->maxContentWidth(
                Width::Full
            );
    }
}
