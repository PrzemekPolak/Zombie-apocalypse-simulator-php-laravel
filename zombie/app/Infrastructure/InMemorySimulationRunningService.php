<?php

namespace App\Infrastructure;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Service\SimulationRunningService;
use App\Application\Service\TurnAction;
use App\Application\Service\TurnActions\CheckWhoBleedOut;
use App\Application\Service\TurnActions\CheckWhoTurnsIntoZombie;
use App\Application\Service\TurnActions\GenerateHumanNonBiteInjuries;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;

class InMemorySimulationRunningService implements SimulationRunningService
{
    private readonly Humans $inMemoryHumans;
    private readonly SimulationTurns $inMemorySimulationTurns;
    private readonly SimulationSettings $inMemorySimulationSettings;
    private readonly HumanInjuries $inMemoryHumanInjuries;
    private readonly HumanBites $inMemoryHumanBites;
    private readonly Zombies $inMemoryZombies;

    public function __construct(
        private readonly Humans             $humans,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
        private readonly HumanBites         $humanBites,
        private readonly Zombies            $zombies,
    )
    {
        $this->inMemoryHumans = new InMemoryHumans();
        $this->inMemorySimulationTurns = new InMemorySimulationTurns();
        $this->inMemorySimulationSettings = new InMemorySimulationSettings();
        $this->inMemoryHumanInjuries = new InMemoryHumanInjuries();
        $this->inMemoryHumanBites = new InMemoryHumanBites();
        $this->inMemoryZombies = new InMemoryZombies();
    }

    public function runSimulation(): void
    {
        $this->prepareDataForSimulation();

        foreach ($this->turnActions() as $turnAction) {
            $turnAction->execute();
        }

        $this->saveChangesOnSimulationEnd();
    }

    /** @return TurnAction[] */
    private function turnActions(): array
    {
        return [
            new CheckWhoBleedOut(
                $this->inMemoryHumans,
                $this->inMemorySimulationTurns,
                $this->inMemoryHumanInjuries,
            ),
            new CheckWhoTurnsIntoZombie(
                $this->inMemoryHumans,
                $this->inMemorySimulationTurns,
                $this->inMemoryHumanBites,
                $this->inMemoryZombies,
            ),
            new GenerateHumanNonBiteInjuries(
                $this->inMemoryHumans,
                $this->inMemorySimulationTurns,
                $this->inMemorySimulationSettings,
                $this->inMemoryHumanInjuries,
            ),
        ];
    }

    private function prepareDataForSimulation(): void
    {
        $this->inMemoryHumans->save($this->humans->all());
        $this->inMemorySimulationTurns->save($this->simulationTurns->all());
        $this->inMemorySimulationSettings->save($this->simulationSettings->all());
        $this->inMemoryHumanInjuries->save($this->humanInjuries->all());
        $this->inMemoryHumanBites->save($this->humanBites->all());
        $this->inMemoryZombies->save($this->zombies->all());
    }

    private function saveChangesOnSimulationEnd(): void
    {
        $this->humans->save($this->inMemoryHumans->all());
        $this->simulationTurns->save($this->inMemorySimulationTurns->all());
        $this->simulationSettings->save($this->inMemorySimulationSettings->all());
        $this->humanInjuries->save($this->inMemoryHumanInjuries->all());
        $this->humanBites->save($this->inMemoryHumanBites->all());
        $this->zombies->save($this->inMemoryZombies->all());
    }
}
