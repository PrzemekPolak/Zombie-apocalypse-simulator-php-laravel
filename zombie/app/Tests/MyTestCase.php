<?php

namespace App\Tests;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\SimulationRunningService;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Infrastructure\InMemoryHumanBites;
use App\Infrastructure\InMemoryHumanInjuries;
use App\Infrastructure\InMemoryHumans;
use App\Infrastructure\InMemoryResources;
use App\Infrastructure\InMemorySimulationRunningService;
use App\Infrastructure\InMemorySimulationSettings;
use App\Infrastructure\InMemorySimulationTurns;
use App\Infrastructure\InMemoryZombies;
use App\Tests\SyntacticSugar\System;
use Tests\TestCase;

class MyTestCase extends TestCase
{
    private System $system;

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

        $this->app->bind(SimulationRunningService::class,
            function () use (
                $humans,
                $resources,
                $simulationTurns,
                $simulationSettings,
                $humanInjuries,
                $humanBites,
                $zombies,
            ) {
                return new InMemorySimulationRunningService(
                    $humans,
                    $resources,
                    $simulationTurns,
                    $simulationSettings,
                    $humanInjuries,
                    $humanBites,
                    $zombies,
                );
            });

        $this->system = new System(
            $this->app->instance(Humans::class, $humans),
            $this->app->instance(Resources::class, $resources),
            $this->app->instance(SimulationTurns::class, $simulationTurns),
            $this->app->instance(SimulationSettings::class, $simulationSettings),
            $this->app->instance(HumanInjuries::class, $humanInjuries),
            $this->app->instance(HumanBites::class, $humanBites),
            $this->app->instance(Zombies::class, $zombies),
        );
    }

    public function system(): System
    {
        return $this->system;
    }
}
