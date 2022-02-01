<?php

namespace App\Providers;

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
        if(!env('APP_ENV','local')) {
            Event::listen(MigrationsStarted::class, function () {
                DB::statement('SET SESSION sql_require_primary_key=0');
            });
            Event::listen(MigrationsEnded::class, function () {
                DB::statement('SET SESSION sql_require_primary_key=1');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
