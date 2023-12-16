<?php

namespace App\Application\Service\TurnActions;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\Service\TurnAction;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Enum\ProfessionType;
use App\Domain\Enum\ResourceType;
use App\Domain\Human;
use App\Domain\HumanBite;
use App\Domain\HumanInjury;
use App\Domain\Zombie;
use App\Services\ProbabilityService;

class ZombieEncounters implements TurnAction
{
    public function __construct(
        private readonly Humans             $humans,
        private readonly Resources          $resources,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
        private readonly HumanBites         $humanBites,
        private readonly Zombies            $zombies,
        private readonly ProbabilityService $probabilityService,
    )
    {
    }

    public function execute(): void
    {
        $humans = $this->humans->getRandomHumans($this->timesEventOccurred());
        $zombies = $this->zombies->getRandomZombies(returnAllStillWalking: true);
        $weapons = $this->resources->getByType(ResourceType::Weapon);

        for ($i = 0; $i < min(count($humans), count($zombies)); $i++) {
            if ($weapons->isAvailable()) {
                $weapons->consume();
            }

            if ($this->probabilityService->willItHappen($this->chanceForBite($humans[$i], $weapons->isAvailable()))) {
                $this->humanGetsBitten($humans[$i], $zombies[$i]);
            } else {
                $zombies[$i]->getsKilled();
            }
        }
    }

    private function timesEventOccurred(): int
    {
        return floor($this->simulationSettings->getEventChance('encounterChance') * count($this->humans->allAlive()) / 100);
    }

    private function chanceForBite(Human $human, bool $weaponIsAvailable): int
    {
        $result = $this->simulationSettings->getEventChance('chanceForBite');

        if ($weaponIsAvailable) {
            $result -= 20;
        }

        if (ProfessionType::Fighting === $human->professionType()) {
            $result -= 10;
        }

        return $result;
    }

    private function humanGetsBitten(Human $human, Zombie $zombie): void
    {
        if ($this->probabilityService->willItHappen($this->simulationSettings->getEventChance('immuneChance'))) {
            $this->immuneHumanGetsBitten($human);
        } else {
            $this->notImmuneHumanGetsBitten($human, $zombie);
        }
    }

    private function immuneHumanGetsBitten(Human $human): void
    {
        $human->getsInjured('zombie bite');
        $this->humanInjuries->save([new HumanInjury(
            $human->id,
            $this->simulationTurns->currentTurn(),
            'zombie bite',
        )]);
    }

    private function notImmuneHumanGetsBitten(Human $human, Zombie $zombie): void
    {
        $human->becomeInfected();
        $this->humanBites->save([new HumanBite(
            $human->id,
            $zombie->id,
            $this->simulationTurns->currentTurn(),
        )]);
    }
}
