<?php

namespace App\Application\Service\TurnActions;

use App\Application\HumanBites;
use App\Application\Humans;
use App\Application\Service\TurnAction;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Zombie;

class CheckWhoTurnsIntoZombie implements TurnAction
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly SimulationTurns $simulationTurns,
        private readonly HumanBites      $humanBites,
        private readonly Zombies         $zombies,
    )
    {
    }

    public function execute(): void
    {
        $bitten = $this->humanBites->fromTurn($this->simulationTurns->currentTurn() - 1);

        foreach ($bitten as $bite) {
            $human = $this->humans->find($bite->humanId);
            $human->becomeZombie();
            $this->zombies->add(Zombie::fromHuman($human));
        }
    }
}
