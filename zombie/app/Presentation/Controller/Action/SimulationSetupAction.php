<?php

namespace App\Presentation\Controller\Action;

use App\Application\SimulationTurns;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Presentation\Http\Controller;
use App\Presentation\Requests\StartSimulationRequest;
use App\Services\SimulationSettingService;
use Symfony\Component\HttpFoundation\JsonResponse;

class SimulationSetupAction extends Controller
{
    public function __construct(
        private readonly SimulationSettingService $simulationSettingService,
        private readonly SimulationTurns          $simulationTurns,
    )
    {
    }

    public function __invoke(StartSimulationRequest $request): JsonResponse
    {
        SimulationSetting::updateAllSettings($request);
        // do only if starting a new simulation
        if (!SimulationTurn::simulationIsOngoing()) {
            $this->simulationSettingService->populateDbWithInitialData($request);
            $this->simulationTurns->createNewTurn();
        }

        return new JsonResponse();
    }
}
