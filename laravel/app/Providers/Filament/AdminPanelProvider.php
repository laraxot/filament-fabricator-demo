<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Illuminate\Foundation\Vite;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Z3d0X\FilamentFabricator\Facades\FilamentFabricator;

use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{

    

    public function panel(Panel $panel): Panel
    {

        //Add custom tags (like `<meta>` & `<link>`)
FilamentFabricator::pushMeta([
    new HtmlString('<link rel="manifest" href="/site.webmanifest" />'),
]);
 
//Register scripts
FilamentFabricator::registerScripts([
    'https://unpkg.com/browse/tippy.js@6.3.7/dist/tippy.esm.js', //external url
    //mix('js/app.js'), //laravel-mix
    app(Vite::class)('resources/js/app.js'), //vite
    //asset('js/app.js'), // asset from public folder
]);
 
//Register styles
FilamentFabricator::registerStyles([
    'https://unpkg.com/tippy.js@6/dist/tippy.css', //external url
    //mix('css/app.css'), //laravel-mix
    app(Vite::class)('resources/css/app.css'), //vite
    //asset('css/app.css'), // asset from public folder
]);
 
FilamentFabricator::favicon(asset('favicon.ico'));

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
