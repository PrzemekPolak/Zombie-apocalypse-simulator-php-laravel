<?php

namespace App\Providers;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Infrastructure\SqlHumans;
use App\Infrastructure\SqlResources;
use App\Infrastructure\SqlSimulationSettings;
use App\Infrastructure\SqlSimulationTurns;
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
        $this->app->bind(SimulationTurns::class, SqlSimulationTurns::class);
        $this->app->bind(SimulationSettings::class, SqlSimulationSettings::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
