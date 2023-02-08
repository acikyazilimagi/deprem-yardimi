<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        if (! $this->app->runningInConsole()) {
            if (Schema::hasTable('settings')) {
                $settings = Setting::pluck('value', 'meta')->toArray();
                config($settings);
            }
        }

        Collection::macro('selectOptions', fn () => $this->map(fn ($value) => [
            'value' => $value,
            'text' => $value,
        ]));
    }
}
