<?php

namespace App\Presentation\Controller\Action;

use App\Application\Command\PopulateDbWithInitialDataCommand;
use App\Application\Command\UpdateChancesOfSimulationSettingsCommand;
use App\Application\CommandBus;
use App\Application\SimulationTurns;
use App\Presentation\Controller\Controller;
use App\Presentation\Request\StartSimulationRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class SimulationSetupAction extends Controller
{
    public function __construct(
        private readonly SimulationTurns $simulationTurns,
        private readonly CommandBus      $commandBus,
    )
    {
    }

    public function __invoke(StartSimulationRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(new UpdateChancesOfSimulationSettingsCommand($request->toArray()));

        if ($this->startingNewSimulation()) {
            $this->commandBus->dispatch(new PopulateDbWithInitialDataCommand(
                $request->input('humanNumber'),
                $request->input('zombieNumber'),
            ));
        }

        return new JsonResponse();
    }

    private function startingNewSimulation(): bool
    {
        return true === empty($this->simulationTurns->all());
    }
}
