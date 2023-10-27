<?php

namespace App\Services;

use App\Application\HumanBites;
use App\Application\HumanInjuries;
use App\Application\Humans;
use App\Application\Resources;
use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Application\Zombies;
use App\Domain\HumanBite as DomainHumanBite;
use App\Domain\HumanInjury as DomainHumanInjury;
use App\Models\Human;
use App\Models\HumanBite;
use App\Models\HumanInjury;
use App\Models\Resource;
use App\Models\SimulationTurn;
use App\Models\Zombie;
use App\Domain\Zombie as DomainZombie;

class SimulationTurnService
{
    public function __construct(
        private readonly Humans             $humans,
        private readonly Resources          $resources,
        private readonly SimulationTurns    $simulationTurns,
        private readonly SimulationSettings $simulationSettings,
        private readonly HumanInjuries      $humanInjuries,
        private readonly HumanBites         $humanBites,
        private readonly Zombies            $zombies,
        private readonly ProbabilityService $probabilityService,
    )
    {
    }

    public function checkWhoDiedFromStarvation(): void
    {
        $humans = $this->humans->whoLastAteAt($this->simulationTurns->currentTurn() - 3);
        foreach ($humans as $human) {
            $human->die('starvation');
        }

        $this->humans->save($humans);
    }

    public function conductTurn(): void
    {
        $this->checkWhoDiedFromStarvation();
        $this->checkWhoBleedOut();
        $this->checkWhoTurnIntoZombie();
        $this->humanNonBiteInjuries();
        $this->zombieEncounters();
        $this->healHumanInjuries();
        $this->humansEatFood();
        $this->generateResources();
    }

    public function checkWhoBleedOut(): void
    {
        $humanInjuries = $this->humanInjuries->fromTurn($this->simulationTurns->currentTurn() - 2);

        foreach ($humanInjuries as $humanInjury) {
            $human = $this->humans->find($humanInjury->humanId);
            if ($human->isInjured()) {
                $human->die($humanInjury->injuryCause);

                $this->humans->save([$human]);
            }
        }
    }

    public function checkWhoTurnIntoZombie(): void
    {
        $bitten = $this->humanBites->fromTurn($this->simulationTurns->currentTurn() - 1);

        foreach ($bitten as $bite) {
            $human = $this->humans->find($bite->humanId);
            $human->becomeZombie();
            $this->zombies->add(DomainZombie::fromHuman($human));

            $this->humans->save([$human]);
        }
    }

    public function humanNonBiteInjuries(): void
    {
        $humans = $this->humans->getRandomHumans($this->calculateTimesEventOccurred('injuryChance'));
        foreach ($humans as $human) {
            $injury = $this->chooseInjuryCause();
            $human->getsInjured($injury);
            $this->humanInjuries->add(new DomainHumanInjury(
                $human->id,
                $this->simulationTurns->currentTurn(),
                $injury,
            ));
        }
        $this->humans->save($humans);
    }

    public function zombieEncounters(): void
    {
        $defaultChanceForBite = $this->simulationSettings->getEventChance('chanceForBite');
        $humanIsImmuneChance = $this->simulationSettings->getEventChance('immuneChance');
        $turn = $this->simulationTurns->currentTurn();
        $weapons = $this->resources->getByType('weapon');

        $humans = $this->humans->getRandomHumans($this->calculateTimesEventOccurred('encounterChance'));
        $zombies = $this->zombies->getRandomZombies(returnAllStillWalking: true);

        $encounterNumber = min(count($humans), count($zombies));
        for ($i = 0; $i < $encounterNumber; $i++) {
            $human = $humans[$i];
            $zombie = $zombies[$i];

            $chanceForBite = $defaultChanceForBite;
            //Scenarios for encounters
            if ($weapons->getQuantity() > 0) {
                $weapons->consume();
                $chanceForBite -= 20;
            }

            if ('fighting' === $human->professionType()) {
                $chanceForBite -= 10;
            }
            if ($this->probabilityService->willItHappen($chanceForBite)) {
                if ($this->probabilityService->willItHappen($humanIsImmuneChance)) {
                    $human->getsInjured('zombie bite');
                    $this->humanInjuries->add(new DomainHumanInjury(
                        $human->id,
                        $turn,
                        'zombie bite',
                    ));
                } else {
                    $human->becomeInfected();
                    $this->humanBites->add(new DomainHumanBite(
                        $human->id,
                        $zombie->id,
                        $turn,
                    ));
                }
            } else {
                $zombie->getsKilled();
            }
        }

        $this->resources->save($weapons);
        $this->humans->save($humans);
        $this->zombies->save($zombies);
    }

    public function healHumanInjuries(): void
    {
        $humans = $this->humans->injured();
        $healthItems = $this->resources->getByType('health');

        for ($i = 0; $i < count($humans); $i++) {
            if ($healthItems->getQuantity() > 0 && $this->probabilityService->willItHappen(25)) {
                $healthItems->consume();
                $humans[$i]->getsHealthy();
            }
        }
        $this->humans->save($humans);
        $this->resources->save($healthItems);
    }

    public function humansEatFood(): void
    {
        $humans = $this->humans->allAlive();
        $food = $this->resources->getByType('food');
        for ($i = 0; $i < count($humans); $i++) {
            if ($food->getQuantity() > 0) {
                $food->consume();
                $humans[$i]->ateFood($this->simulationTurns->currentTurn());
            }
        }
        $this->humans->save($humans);
        $this->resources->save($food);
    }

    public function generateResources(): void
    {
        $resourcesTypes = ['health', 'food', 'weapon'];
        foreach ($resourcesTypes as $resourceType) {
            $resource = $this->resources->getByType($resourceType);
            $resource->produce($this->humans->getNumberOfResourceProducers($resourceType));
            $this->resources->save($resource);
        }
    }

    /**
     * Checks different rules for simulation to end. If all are false then returns false.
     * If some condition is met, returns string with information about it
     * @return bool|string
     */
    public function checkIfSimulationShouldEnd(): bool|string
    {
        $endReason = false;
        if (Human::alive()->count() <= 0) {
            $endReason = 'Ludzie wygineli';
        } else if (Zombie::stillWalking()->count() <= 0) {
            $endReason = 'Zombie wygineły';
        } else if (Resource::where('type', 'food')->first()->quantity <= 0) {
            $endReason = 'Jedzenie się skończyło';
        } else if (SimulationTurn::all()->sortByDesc('id')->first()->id >= 20) {
            $endReason = 'Wynaleziono szczepionkę';
        }
        return $endReason;
    }

    public function getFrontendDataForDashboard(): array
    {
        return [
            ['label' => 'Obecna tura', 'value' => $this->simulationTurns->currentTurn(), 'icon' => 'clock-solid.svg'],
            ['label' => 'Żywi ludzie', 'value' => Human::alive()->count(), 'icon' => 'person-solid.svg'],
            ['label' => 'Zombie', 'value' => Zombie::stillWalking()->count(), 'icon' => 'biohazard-solid.svg'],
            ['label' => 'Jedzenie', 'value' => Resource::where('type', 'food')->first()->quantity, 'icon' => 'utensils-solid.svg'],
            ['label' => 'Lekarstwa', 'value' => Resource::where('type', 'health')->first()->quantity, 'icon' => 'briefcase-medical-solid.svg'],
            ['label' => 'Broń', 'value' => Resource::where('type', 'weapon')->first()->quantity, 'icon' => 'gun-solid.svg'],
        ];
    }

    public function getSimulationEndStatistics(): array
    {
        return [
            'turns' => SimulationTurn::all()->count(),
            'reasonForEnding' => $this->checkIfSimulationShouldEnd(),
            'zombieNumber' => Zombie::stillWalking()->count(),
            'deadZombies' => Zombie::where('health', 'dead')->count(),
            'humanNumber' => Human::alive()->count(),
            'deadHumans' => Human::where('health', 'dead')->count(),
            'turnedHumans' => Human::where('health', 'turned')->count(),
            'allBites' => HumanBite::all()->count(),
            'allInjuries' => HumanInjury::all()->count(),
        ];
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
