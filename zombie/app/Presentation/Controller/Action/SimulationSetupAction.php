<?php

namespace App\Presentation\Controller\Action;

use App\Application\Command\PopulateDbWithInitialDataCommand;
use App\Application\CommandBus;
use App\Application\SimulationTurns;
use App\Models\SimulationSetting;
use App\Presentation\Http\Controller;
use App\Presentation\Requests\StartSimulationRequest;
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
        SimulationSetting::updateAllSettings($request);

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
