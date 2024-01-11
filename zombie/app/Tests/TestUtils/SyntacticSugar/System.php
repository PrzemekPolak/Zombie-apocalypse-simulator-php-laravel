<?php

namespace App\Tests\TestUtils\SyntacticSugar;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Human;
use App\Domain\HumanBite;
use App\Domain\HumanInjury;
use App\Domain\Resource;
use App\Domain\SimulationSetting;
use App\Domain\SimulationTurn;
use App\Domain\Zombie;

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

    public function zombies(): Zombies
    {
        return $this->zombies;
    }

    public function resources(): Resources
    {
        return $this->resources;
    }

    public function simulationTurns(): SimulationTurns
    {
        return $this->simulationTurns;
    }

    public function simulationSettings(): SimulationSettings
    {
        return $this->simulationSettings;
    }

    public function humanInjuries(): HumanInjuries
    {
        return $this->humanInjuries;
    }

    public function humanBites(): HumanBites
    {
        return $this->humanBites;
    }

    public function hasHumans(Human ...$humans): void
    {
        $this->humans->save($humans);
    }

    public function hasZombies(Zombie ...$zombies): void
    {
        $this->zombies->save($zombies);
    }

    public function hasResources(Resource ...$resources): void
    {
        $this->resources->save($resources);
    }

    public function hasSimulationTurns(SimulationTurn ...$simulationTurns): void
    {
        $this->simulationTurns->save($simulationTurns);
    }

    public function hasSimulationSettings(SimulationSetting ...$simulationSettings): void
    {
        $this->simulationSettings->save($simulationSettings);
    }

    public function hasHumanInjuries(HumanInjury ...$humanInjuries): void
    {
        $this->humanInjuries->save($humanInjuries);
    }

    public function hasHumanBites(HumanBite ...$humanBites): void
    {
        $this->humanBites->save($humanBites);
    }
}
