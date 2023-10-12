<?php

namespace App\Providers;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Infrastructure\SqlHumanBites;
use App\Infrastructure\SqlHumanInjuries;
use App\Infrastructure\SqlHumans;
use App\Infrastructure\SqlResources;
use App\Infrastructure\SqlSimulationSettings;
use App\Infrastructure\SqlSimulationTurns;
use App\Infrastructure\SqlZombies;
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
        $this->app->bind(HumanInjuries::class, SqlHumanInjuries::class);
        $this->app->bind(HumanBites::class, SqlHumanBites::class);
        $this->app->bind(Zombies::class, SqlZombies::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
