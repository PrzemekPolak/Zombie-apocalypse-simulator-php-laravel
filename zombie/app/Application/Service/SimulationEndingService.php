<?php

namespace App\Application\Service;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationTurns;
use App\Application\Zombies;

class SimulationEndingService
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly Resources       $resources,
        private readonly SimulationTurns $simulationTurns,
        private readonly Zombies         $zombies,
    )
    {
    }

    public function checkIfSimulationShouldEnd(): bool
    {
        return !empty($this->getReasonsWhySimulationIsFinished());
    }

    public function getReasonsWhySimulationIsFinished(): array
    {
        $endReasons = [];
        if ($this->humans->countAlive() <= 0) {
            $endReasons[] = 'Ludzie wygineli';
        }
        if (count($this->zombies->stillWalking()) <= 0) {
            $endReasons[] = 'Zombie wygineły';
        }
        if ($this->resources->getByType('food')->getQuantity() <= 0) {
            $endReasons[] = 'Jedzenie się skończyło';
        }
        if ($this->simulationTurns->currentTurn() >= 20) {
            $endReasons[] = 'Wynaleziono szczepionkę';
        }
        return $endReasons;
    }
}
