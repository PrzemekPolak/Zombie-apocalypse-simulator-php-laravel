<?php

namespace App\Presentation\Controller\Action;

use App\Http\Controllers\Controller;
use App\Services\SimulationSettingService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClearSimulationAction extends Controller
{
    public function __construct(
        private readonly SimulationSettingService $simulationSettingService,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->simulationSettingService->clearSimulationTables();

        return new JsonResponse();
    }
}
