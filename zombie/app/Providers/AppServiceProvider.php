<?php

namespace App\Providers;

use App\Application\Humans;
use App\Application\Resources;
use App\Infrastructure\SqlHumans;
use App\Infrastructure\SqlResources;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Humans::class, SqlHumans::class);
        $this->app->bind(Resources::class, SqlResources::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
