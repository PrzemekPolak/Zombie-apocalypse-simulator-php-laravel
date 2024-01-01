<?php

namespace App\Providers;

use App\Application\Command\ClearSimulationTablesCommand;
use App\Application\Command\PopulateDbWithInitialDataCommand;
use App\Application\Command\UpdateChancesOfSimulationSettingsCommand;
use App\Application\CommandBus;
use App\Application\Handler\ClearSimulationTablesHandler;
use App\Application\Handler\PopulateDbWithInitialDataHandler;
use App\Application\Handler\UpdateChancesOfSimulationSettingsHandler;
use App\Infrastructure\IlluminateCommandBus;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);

        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            PopulateDbWithInitialDataCommand::class => PopulateDbWithInitialDataHandler::class,
            ClearSimulationTablesCommand::class => ClearSimulationTablesHandler::class,
            UpdateChancesOfSimulationSettingsCommand::class => UpdateChancesOfSimulationSettingsHandler::class,
        ]);
    }

    public function boot(): void
    {
        //
    }
}
