<?php

namespace App\Services;

use App\Models\Human;
use App\Models\HumanBite;
use App\Models\HumanInjury;
use App\Models\Resource;
use App\Models\SimulationSetting;
use App\Models\SimulationTurn;
use App\Models\Zombie;
use Illuminate\Support\Facades\DB;

class SimulationTurnService
{
    public function __construct()
    {
        $this->currentTurn = SimulationTurn::currentTurn();
    }

    public function checkWhoDiedFromStarvation(): void
    {
        $humans = Human::alive()->where('last_eat_at', '<=', $this->currentTurn - 3)->get();

        DB::transaction(function () use ($humans) {
            for ($i = 0; $i < $humans->count(); $i++) {
                $humans[$i]->die('starvation');
            }
        });
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
        $injuredHumans = HumanInjury::where('injured_at', '>', $this->currentTurn - 2)->get();

        foreach ($injuredHumans as $injuredHuman) {
            $human = Human::find($injuredHuman->human_id);
            if ($human->isNotHealthy()) {
                $human->die($injuredHuman->injury_cause);
            }
        }
    }

    public function checkWhoTurnIntoZombie(): void
    {
        $bitten = HumanBite::where('turn_id', $this->currentTurn - 1)->get();
        foreach ($bitten as $bite) {
            $human = Human::find($bite->human_id);
            $this->turnHumanIntoZombie($human);
        }
    }

    private function turnHumanIntoZombie(Human $human): void
    {
        $zombie = $human->replicate(['last_eat_at', 'death_cause']);
        $zombie->health = 'infected';
        $zombie->setTable('zombies');
        $zombie->save();
        $human->update(['health' => 'turned']);
    }

    /**
     * generates injuries not caused by zombies
     * @return void
     */
    public function humanNonBiteInjuries(): void
    {
        $count = $this->calculateTimesEventOccured('injuryChance');
        $humans = Human::alive()->inRandomOrder()->get()->take($count);
        foreach ($humans as $human) {
            $injury = $this->chooseInjuryCause();
            HumanInjury::add($human->id, $injury, $this->currentTurn);
            if ($human->isNotHealthy()) {
                $human->die($injury);
            }
            if ($human->health === 'healthy') {
                $human->setHealth('injured');
            }
        }
    }

    private function calculateTimesEventOccured(string $event)
    {
        $humanCount = Human::all()->count();
        $event = SimulationSetting::getEventChance($event);
        return $event * $humanCount / 100;
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


    public function zombieEncounters(): void
    {
        $defaultChanceForBite = SimulationSetting::getEventChance('chanceForBite');
        $weapon = Resource::where('type', 'weapon')->first()->quantity;

        $encounterNumber = Zombie::stillWalking()->count();
        $count = $this->calculateTimesEventOccured('injuryChance');
        $humans = Human::alive()->inRandomOrder()->get()->take($count);
        $zombies = Zombie::stillWalking()->inRandomOrder()->get();
        foreach ($humans as $human) {

            $encounterNumber = --$encounterNumber;
            $chanceForBite = $defaultChanceForBite;
            //Scenarios for encounters
            if ($weapon > 0) {
                $weapon = --$weapon;
                $chanceForBite -= 20;
            }

            if (in_array($human->proffesion, ['soldier', 'police'])) {
                $chanceForBite -= 10;
            }
            if (rand(0, 99) < $chanceForBite) {
                $zombie = $zombies->shift();
                $zombie->bite($human);
            } else {
                $zombie = $zombies->shift();
                $human->killZombie($zombie);
            }

            //Break if there are no more zombies
            if ($encounterNumber === 0) break;
        }

        Resource::where('type', 'weapon')->first()->update(['weapon' => $weapon]);
    }

    /**
     * injured humans attempt to heal their injuries
     * @return void
     */
    public function healHumanInjuries(): void
    {
        $humans = Human::where('health', 'injured')->get();
        $resource = Resource::where('type', 'health')->first();
        $health = $resource->quantity;

        DB::transaction(function () use ($humans, $health, $resource) {
            for ($i = 0; $i < $humans->count(); $i++) {
                if (($health > 0) && random_int(0, 10) === 5) {
                    $health = --$health;
                    $resource->update(['health' => $health]);
                    $humans[$i]->update(['health' => 'healthy']);
                }
            }
        });
    }

    /**
     * humans need to eat food
     * @return void
     */
    public function humansEatFood(): void
    {
        $humans = Human::alive()->inRandomOrder()->get();
        $food = Resource::where('type', 'food')->first()->quantity;
        $resource = Resource::where('type', 'food')->first();
        $turn = $this->currentTurn;
        DB::transaction(function () use ($humans, $turn, $food) {
            for ($i = 0; $i < $humans->count(); $i++) {
                if ($food > 0) {
                    $food = --$food;
                    $humans[$i]->update(['last_eat_at' => $turn]);
                }
            }
        });
        $resource->update(['quantity' => $food - $humans->count()]);
    }

    public function generateResources(): void
    {
        $healthProducers = Human::getNumberOfResourceProducers('health');
        $foodProducers = Human::getNumberOfResourceProducers('food');
        $weaponsProducers = Human::getNumberOfResourceProducers('weapon');
        $health = Resource::getResourceQuantity('health');
        $food = Resource::getResourceQuantity('food');
        $weapon = Resource::getResourceQuantity('weapon');
        Resource::setResourceQuantity('health', $health + $healthProducers * 1);
        Resource::setResourceQuantity('food', $food + $foodProducers * 2);
        Resource::setResourceQuantity('weapon', $weapon + $weaponsProducers * 1);
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
            ['label' => 'Obecna tura', 'value' => $this->currentTurn, 'icon' => 'clock-solid.svg'],
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
}
