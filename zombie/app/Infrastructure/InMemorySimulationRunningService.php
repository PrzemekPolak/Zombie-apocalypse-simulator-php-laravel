<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Service\SimulationRunningService;
use App\Application\Service\TurnAction;
use App\Application\Service\TurnActions\GenerateHumanNonBiteInjuries;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;

class InMemorySimulationRunningService implements SimulationRunningService
{
    private readonly Humans $inMemoryHumans;
    private readonly SimulationTurns $inMemorySimulationTurns;
    private readonly SimulationSettings $inMemorySimulationSettings;
    private readonly HumanInjuries $inMemoryHumanInjuries;

    public function __construct(
        private readonly Humans             $humans,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
    )
    {
        $this->inMemoryHumans = new InMemoryHumans();
        $this->inMemorySimulationTurns = new InMemorySimulationTurns();
        $this->inMemorySimulationSettings = new InMemorySimulationSettings();
        $this->inMemoryHumanInjuries = new InMemoryHumanInjuries();
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
            new GenerateHumanNonBiteInjuries(
                $this->inMemoryHumans,
                $this->inMemorySimulationTurns,
                $this->inMemorySimulationSettings,
                $this->inMemoryHumanInjuries,
            )
        ];
    }

    private function prepareDataForSimulation(): void
    {
        $this->inMemoryHumans->save($this->humans->all());
        $this->inMemorySimulationTurns->save($this->simulationTurns->all());
        $this->inMemorySimulationSettings->save($this->simulationSettings->all());
        $this->inMemoryHumanInjuries->save($this->humanInjuries->all());
    }

    private function saveChangesOnSimulationEnd(): void
    {
        $this->humans->save($this->inMemoryHumans->all());
        $this->simulationTurns->save($this->inMemorySimulationTurns->all());
        $this->simulationSettings->save($this->inMemorySimulationSettings->all());
        $this->humanInjuries->save($this->inMemoryHumanInjuries->all());
    }
}
