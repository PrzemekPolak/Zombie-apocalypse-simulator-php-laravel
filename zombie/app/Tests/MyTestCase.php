<?php

namespace App\Tests;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Infrastructure\InMemoryHumans;
use App\Infrastructure\InMemoryResources;
use App\Infrastructure\InMemorySimulationSettings;
use App\Infrastructure\InMemorySimulationTurns;
use App\Services\SimulationTurnService;
use App\Tests\SyntacticSugar\System;
use Tests\TestCase;

require_once('App\Tests\functions.php');

class MyTestCase extends TestCase
{
    private System $system;
    private SimulationTurnService $simulationTurnService;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->bind(Humans::class, InMemoryHumans::class);
        $this->app->bind(Resources::class, InMemoryResources::class);
        $this->app->bind(SimulationTurns::class, InMemorySimulationTurns::class);
        $this->app->bind(SimulationSettings::class, InMemorySimulationSettings::class);

        $humans = $this->app->make(Humans::class);
        $resources = $this->app->make(Resources::class);
        $simulationTurns = $this->app->make(SimulationTurns::class);
        $simulationSettings = $this->app->make(SimulationSettings::class);

        $this->system = new System(
            $humans,
            $resources,
            $simulationTurns,
            $simulationSettings,
        );

        $this->simulationTurnService = new SimulationTurnService(
            $humans,
            $resources,
            $simulationTurns,
            $simulationSettings,
        );
    }

    public function system(): System
    {
        return $this->system;
    }

    public function simulationTurnService(): SimulationTurnService
    {
        return $this->simulationTurnService;
    }

}
