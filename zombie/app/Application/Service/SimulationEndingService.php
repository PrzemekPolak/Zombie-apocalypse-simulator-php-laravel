<?php

namespace App\Application\Service;

use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Enum\ResourceType;

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
        if ($this->simulationDidntStartYet()) {
            return false;
        }

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
        if (false === $this->resources->getByType(ResourceType::Food)->isAvailable()) {
            $endReasons[] = 'Jedzenie się skończyło';
        }
        if ($this->simulationTurns->currentTurn() >= 20) {
            $endReasons[] = 'Wynaleziono szczepionkę';
        }
        return $endReasons;
    }

    private function simulationDidntStartYet(): bool
    {
        return empty($this->simulationTurns->all());
    }
}
