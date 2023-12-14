<?php

namespace App\Presentation\Controller\Action;

use App\Application\Humans;
use App\Application\SimulationTurns;
use App\Domain\Human;
use App\Presentation\Http\Controller;
use App\Presentation\View\HumanView;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetRandomHumansAction extends Controller
{
    public function __construct(
        private readonly Humans          $humans,
        private readonly SimulationTurns $simulationTurns,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $currentTurn = $this->simulationTurns->currentTurn();

        return new JsonResponse(
            array_map(
                static fn(Human $human) => HumanView::fromDto($human, $currentTurn),
                $this->humans->getRandomHumans(3)
            )
        );
    }
}
