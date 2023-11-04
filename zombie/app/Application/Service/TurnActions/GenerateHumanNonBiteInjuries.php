<?php

namespace App\Application\Service\TurnActions;

use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Service\TurnAction;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Domain\HumanInjury;

class GenerateHumanNonBiteInjuries implements TurnAction
{
    public function __construct(
        private readonly Humans             $humans,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
    )
    {
    }

    public function execute(): void
    {
        $humans = $this->humans->getRandomHumans($this->calculateTimesEventOccurred('injuryChance'));
        foreach ($humans as $human) {
            $injury = $this->chooseInjuryCause();
            $human->getsInjured($injury);
            $this->humanInjuries->save([new HumanInjury(
                $human->id,
                $this->simulationTurns->currentTurn(),
                $injury,
            )]);
        }
    }

    private function calculateTimesEventOccurred(string $event): int
    {
        $humanCount = $this->humans->countAlive();
        $event = $this->simulationSettings->getEventChance($event);
        return floor($event * $humanCount / 100);
    }

    private function chooseInjuryCause(): string
    {
        $injuryCauses = [
            "Tripped over a zombie's shoelaces",
            "Poked a zombie in the eye while trying to take a selfie",
            "Got a paper cut from a zombie-themed comic book",
            "Slipped on a banana peel while running from a zombie horde",
            "Accidentally stapled own finger while crafting zombie repellent",
            "Sprained ankle while attempting a zombie-inspired dance move",
            "Burned hand on a hot slice of zombie-shaped pizza",
            "Got a black eye from a friendly zombie high-five gone wrong",
            "Bumped head on a low-hanging zombie-themed piñata",
            "Stubbed toe on a hidden zombie action figure",
        ];
        return $injuryCauses[array_rand($injuryCauses, 1)];
    }
}
