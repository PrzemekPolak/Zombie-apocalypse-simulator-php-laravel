<?php

namespace App\Tests;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Infrastructure\InMemoryHumanBites;
use App\Infrastructure\InMemoryHumanInjuries;
use App\Infrastructure\InMemoryHumans;
use App\Infrastructure\InMemoryResources;
use App\Infrastructure\InMemorySimulationSettings;
use App\Infrastructure\InMemorySimulationTurns;
use App\Infrastructure\InMemoryZombies;
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
        $this->app->bind(HumanInjuries::class, InMemoryHumanInjuries::class);
        $this->app->bind(HumanBites::class, InMemoryHumanBites::class);
        $this->app->bind(Zombies::class, InMemoryZombies::class);

        $humans = $this->app->make(Humans::class);
        $resources = $this->app->make(Resources::class);
        $simulationTurns = $this->app->make(SimulationTurns::class);
        $simulationSettings = $this->app->make(SimulationSettings::class);
        $humanInjuries = $this->app->make(HumanInjuries::class);
        $humanBites = $this->app->make(HumanBites::class);
        $zombies = $this->app->make(Zombies::class);

        $this->system = new System(
            $humans,
            $resources,
            $simulationTurns,
            $simulationSettings,
            $humanInjuries,
            $humanBites,
            $zombies,
        );

        $this->simulationTurnService = new SimulationTurnService(
            $humans,
            $resources,
            $simulationTurns,
            $simulationSettings,
            $humanInjuries,
            $humanBites,
            $zombies,
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
