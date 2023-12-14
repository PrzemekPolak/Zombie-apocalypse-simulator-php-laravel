<?php

namespace App\Presentation\Controller\Action;

use App\Application\Zombies;
use App\Domain\Zombie;
use App\Presentation\Http\Controller;
use App\Presentation\View\ZombieView;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetRandomZombiesAction extends Controller
{
    public function __construct(
        private readonly Zombies $zombies,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                static fn(Zombie $zombie) => ZombieView::fromDto($zombie),
                $this->zombies->getRandomZombies(3)
            )
        );
    }
}
