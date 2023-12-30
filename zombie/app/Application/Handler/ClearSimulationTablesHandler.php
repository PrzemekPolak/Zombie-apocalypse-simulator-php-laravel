<?php

namespace App\Application\Handler;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationTurns;
use App\Application\Zombies;

class ClearSimulationTablesHandler
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly Zombies         $zombies,
        private readonly SimulationTurns $simulationTurns,
        private readonly Resources       $resources,
        private readonly HumanBites      $humanBites,
        private readonly HumanInjuries   $humanInjuries,
    )
    {
    }

    public function __invoke(): void
    {
        $this->humans->removeAll();
        $this->zombies->removeAll();
        $this->simulationTurns->removeAll();
        $this->resources->removeAll();
        $this->humanBites->removeAll();
        $this->humanInjuries->removeAll();
    }
}
