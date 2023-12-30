<?php

namespace App\Presentation\Controller\Action;

use App\Application\Command\ClearSimulationTablesCommand;
use App\Application\CommandBus;
use App\Presentation\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClearSimulationAction extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->commandBus->dispatch(new ClearSimulationTablesCommand());

        return new JsonResponse();
    }
}
