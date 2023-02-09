<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\BadWordDetector;

class BadWordServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind("BadWordFacade", function (){
            return new BadWordDetector();
        });
    }
}
