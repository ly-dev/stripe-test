<?php

namespace App\Modules\Account\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'account');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'account');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations', 'account');
        // $this->loadConfigsFrom(__DIR__ . '/../config');

        // define customized validation
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            $model = User::find($parameters[0]);
            if (!empty($model) && Hash::check($value, $model->password)) {
                return true;
            }

            return false;
        });

        Validator::extend('password_policy', function ($attribute, $value, $parameters, $validator) {
            if (!empty($value) && strlen($value) > 6) {
                return true;
            }

            return false;
        });

        // define customized validation message, see ../Resource/Lang/en/validation.php
        Validator::replacer('current_password', function ($message, $attribute, $rule, $parameters) {
            if ($message == 'validation.current_password') {
                $message = trans('account::validation.current_password');
                return str_replace(':attribute', $attribute, $message);
            } else {
                return $message;
            }
        });

        Validator::replacer('password_policy', function ($message, $attribute, $rule, $parameters) {
            if ($message == 'validation.password_policy') {
                $message = trans('account::validation.password_policy');
                return str_replace(':attribute', $attribute, $message);
            } else {
                return $message;
            }
        });
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
