<?php

namespace App\Application\Handler;

use App\Application\Command\PopulateDbWithInitialDataCommand;
use App\Application\Factory\HumanFactory;
use App\Application\Factory\ZombieFactory;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\Enum\ResourceType;
use App\Domain\Resource;

class PopulateDbWithInitialDataHandler
{
    public function __construct(
        private readonly Resources       $resources,
        private readonly Humans          $humans,
        private readonly Zombies         $zombies,
        private readonly SimulationTurns $simulationTurns,
    )
    {
    }

    public function __invoke(PopulateDbWithInitialDataCommand $command): void
    {
        $this->resources->save([
            Resource::create(ResourceType::Health, $command->humansCount),
            Resource::create(ResourceType::Food, $command->humansCount * 10),
            Resource::create(ResourceType::Weapon, $command->humansCount),
        ]);

        $this->humans->save(HumanFactory::createMany($command->humansCount));
        $this->zombies->save(ZombieFactory::createMany($command->zombiesCount));

        $this->simulationTurns->createNewTurn();
    }
}
