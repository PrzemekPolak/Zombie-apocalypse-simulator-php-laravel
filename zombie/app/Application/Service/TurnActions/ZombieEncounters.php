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
use App\Domain\HumanBite;
use App\Domain\HumanInjury;
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
        $defaultChanceForBite = $this->simulationSettings->getEventChance('chanceForBite');
        $humanIsImmuneChance = $this->simulationSettings->getEventChance('immuneChance');
        $turn = $this->simulationTurns->currentTurn();
        $weapons = $this->resources->getByType('weapon');

        $humans = $this->humans->getRandomHumans($this->timesEventOccurred());
        $zombies = $this->zombies->getRandomZombies(returnAllStillWalking: true);

        $encounterNumber = min(count($humans), count($zombies));
        for ($i = 0; $i < $encounterNumber; $i++) {
            $human = $humans[$i];
            $zombie = $zombies[$i];

            $chanceForBite = $defaultChanceForBite;
            //Scenarios for encounters
            if ($weapons->getQuantity() > 0) {
                $weapons->consume();
                $chanceForBite -= 20;
            }

            if ('fighting' === $human->professionType()) {
                $chanceForBite -= 10;
            }
            if ($this->probabilityService->willItHappen($chanceForBite)) {
                if ($this->probabilityService->willItHappen($humanIsImmuneChance)) {
                    $human->getsInjured('zombie bite');
                    $this->humanInjuries->save([new HumanInjury(
                        $human->id,
                        $turn,
                        'zombie bite',
                    )]);
                } else {
                    $human->becomeInfected();
                    $this->humanBites->save([new HumanBite(
                        $human->id,
                        $zombie->id,
                        $turn,
                    )]);
                }
            } else {
                $zombie->getsKilled();
            }
        }
    }

    private function timesEventOccurred(): int
    {
        $humanCount = $this->humans->countAlive();
        $event = $this->simulationSettings->getEventChance('encounterChance');
        return floor($event * $humanCount / 100);
    }
}
