<?php

namespace App\Modules\Stripe\Providers;

use App\Stripe\Services\StripeService;
use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'stripe');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'stripe');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations', 'stripe');
        $this->loadConfigsFrom(__DIR__ . '/../config');

        // binding services to service container
        $this->app->singleton(StripeService::class, function () {
            return new StripeService();
        });

        if (config('stripe.force_https')) {
            $url->forceScheme('https');
        }
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
