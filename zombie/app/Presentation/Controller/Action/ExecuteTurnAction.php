<?php

namespace App\Presentation\Controller\Action;

use App\Application\Service\SimulationRunningService;
use App\Presentation\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExecuteTurnAction extends Controller
{
    public function __construct(
        private readonly SimulationRunningService $simulationRunningService,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->simulationRunningService->runSimulation();

        return new JsonResponse();
    }
}
