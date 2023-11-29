<?php

namespace App\Presentation\Controller\Action;

use App\Application\Service\SimulationRunningService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RunWholeSimulationAction extends Controller
{
    public function __construct(
        private readonly SimulationRunningService $simulationRunningService,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->simulationRunningService->runWholeSimulationOnServer();

        return new JsonResponse();
    }
}
