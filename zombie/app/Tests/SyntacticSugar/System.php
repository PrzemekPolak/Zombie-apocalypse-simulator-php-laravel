<?php

namespace App\Tests\SyntacticSugar;

use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Domain\Human;
use App\Domain\Resource;
use App\Domain\SimulationSetting;
use App\Domain\SimulationTurn;

class System
{
    public function __construct(
        private readonly Humans             $humans,
        private readonly Resources          $resources,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
    )
    {
    }

    public function humans(): Humans
    {
        return $this->humans;
    }

    public function resources(): Resources
    {
        return $this->resources;
    }

    public function getHumanInjuries(): HumanInjuries
    {
        return $this->humanInjuries;
    }

    public function hasHumans(Human ...$humans): void
    {
        foreach ($humans as $human) {
            $this->humans->add($human);
        }
    }

    public function hasResources(Resource ...$resources): void
    {
        foreach ($resources as $resource) {
            $this->resources->add($resource);
        }
    }

    public function hasSimulationTurns(SimulationTurn ...$simulationTurns): void
    {
        foreach ($simulationTurns as $simulationTurn) {
            $this->simulationTurns->add($simulationTurn);
        }
    }

    public function hasSimulationSettings(SimulationSetting ...$simulationSettings): void
    {
        foreach ($simulationSettings as $simulationSetting) {
            $this->simulationSettings->add($simulationSetting);
        }
    }
}
