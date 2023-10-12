<?php

namespace App\Tests\SyntacticSugar;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Human;
use App\Domain\HumanBite;
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
        private readonly HumanBites         $humanBites,
        private readonly Zombies            $zombies,
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

    public function getZombies(): Zombies
    {
        return $this->zombies;
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

    public function hasHumanBites(HumanBite ...$humanBites): void
    {
        foreach ($humanBites as $humanBite) {
            $this->humanBites->add(
                $humanBite->humanId,
                $humanBite->zombieId,
                $humanBite->turn,
            );
        }
    }
}
