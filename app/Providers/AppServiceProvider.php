<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\BladeUtilService;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // according to https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);

        // binding services to service container
        $this->app->singleton(BladeUtilService::class, function () {
            return new BladeUtilService();
        });

        // add blade directive
        Blade::directive('toJsData', function ($expression) {
            return "<?php echo (isset{$expression} && (is_object{$expression} || is_array{$expression}) ? json_encode{$expression} : {$expression}); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
