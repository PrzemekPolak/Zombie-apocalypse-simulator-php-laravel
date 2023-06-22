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
    private function currentTurn()
    {
        return SimulationTurn::latest()->first()->id;
    }

    private function turnHumanIntoZombie(Human $human): void
    {
        $zombie = $human->replicate(['last_eat_at']);
        $zombie->health = 'infected';
        $zombie->setTable('zombies');
        $zombie->save();
        $human->delete();
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

    public function nextTurn()
    {
        $turn = new SimulationTurn();
        $turn->status = 'active';
        $turn->save();
    }

    public function endSimulation()
    {
        $turn = new SimulationTurn();
        $turn->status = 'end';
        $turn->save();
    }

    public function checkWhoDiedFromStarvation(): void
    {
        $turn = $this->currentTurn();
        $humans = Human::alive()->get();
        foreach ($humans as $human) {
            if ($turn - $human->last_eat_at >= 3) {
                $human->update(['health', 'dead']);
            }
        }
    }

    public function checkWhoBleedOut(): void
    {
        $turn = $this->currentTurn();
        $humans = Human::alive()->get();
        foreach ($humans as $human) {
            if ($human->health === 'injured' && $turn - HumanInjury::where('human_id', $human->id)->latest()->first()->injured_at >= 2) {
                $human->update(['health', 'dead']);
            }
        }
    }

    public function checkWhoTurnIntoZombie(): void
    {
        $turn = $this->currentTurn();
        $humans = Human::alive()->get();
        foreach ($humans as $human) {
            $turn_id = HumanBite::where('human_id', $human->id)->latest()->first()->turn_id ?? null;
            if ($turn_id !== null && ($turn - $turn_id >= 1)) {
                $this->turnHumanIntoZombie($human);
            }
        }
    }

    public function generateResources(): void
    {
        $healthProducers = Human::alive()->whereIn('profession', ['doctor', 'nurse'])->whereIn('health', ['healthy', 'infected'])->count();
        $foodProducers = Human::alive()->whereIn('profession', ['farmer', 'hunter'])->whereIn('health', ['healthy', 'infected'])->count();
        $weaponsProducers = Human::alive()->whereIn('profession', ['engineer', 'mechanic'])->whereIn('health', ['healthy', 'infected'])->count();
        $health = Resource::where('type', 'health')->first();
        $health->update(['quantity' => $health->quantity + $healthProducers * 2]);
        $food = Resource::where('type', 'food')->first();
        $food->update(['quantity' => $food->quantity + $foodProducers * 4]);
        $weapon = Resource::where('type', 'weapon')->first();
        $weapon->update(['quantity' => $weapon->quantity + $weaponsProducers * 1]);
    }

    public function zombieEncounters(): void
    {
        $encounterChance = SimulationSetting::where('event', 'encounterChance')->first()->chance;
        $defaultChanceForBite = SimulationSetting::where('event', 'chanceForBite')->first()->chance;

        $humans = Human::alive()->get();
        $weapon = Resource::where('type', 'weapon')->first()->quantity;

        $encounterNumber = Zombie::stillWalking()->count();
        foreach ($humans as $human) {
            if (rand(0, 99) < $encounterChance) {
                $encounterNumber = --$encounterNumber;
                $chanceForBite = $defaultChanceForBite;
                $zombie = Zombie::stillWalking()->inRandomOrder()->first();
                if ($weapon > 0) {
                    $weapon = --$weapon;
                    $chanceForBite = $chanceForBite - 20;
                }
                if (in_array($human->proffesion, ['soldier', 'police'])) {
                    $chanceForBite = $chanceForBite - 20;
                };
                if (rand(0, 99) < $chanceForBite) {
                    $zombie->bite($human);
                } else {
                    $human->killZombie($zombie);
                }
            }
            if ($encounterNumber === 0) break;
        }
        Resource::where('type', 'weapon')->first()->update(['weapon' => $weapon]);
    }

    // generates injuries not caused by zombies
    public function humanNonBiteInjuries(): void
    {
        $injuryChance = SimulationSetting::where('event', 'injuryChance')->first()->chance;

        $humans = Human::alive()->get();
        $currentTurn = SimulationTurn::latest()->first()->id;
        foreach ($humans as $human) {
            if (rand(0, 99) < $injuryChance) {
                $injury = new HumanInjury();
                $injury->human_id = $human->id;
                $injury->injury_cause = $this->chooseInjuryCause();
                $injury->injured_at = $currentTurn;
                $injury->save();
                $human->update(['health' => 'injured']);
            }
        }
    }

    // injured humans attempt to heal their injuries
    public function healHumanInjuries(): void
    {
        $humans = Human::where('health', 'injured')->get();
        $health = Resource::where('type', 'health')->first()->quantity;

        foreach ($humans as $human) {
            if ($health > 0) {
                $human->useHealingResource();
                $health = --$health;
            }
        }
    }

    // humans need to eat food
    public function humansEatFood(): void
    {
        $humans = Human::alive()->inRandomOrder()->get();
        $food = Resource::where('type', 'food')->first()->quantity;

        foreach ($humans as $human) {
            if ($food > 0) {
                $food = --$food;
            }
        }
        Resource::where('type', 'food')->first()->update(['food' => $food]);
    }

    public function checkIfSimulationShouldEnd()
    {
        $endReason = false;
        if (Human::alive()->count() === 0) $endReason = 'Ludzie wygineli';
        else if (Zombie::stillWalking()->count() === 0) $endReason = 'Zombie wygineły';
        else if (Resource::where('type', 'food')->first()->quantity <= 0) $endReason = 'Jedzenie się skończyło';
        else if (SimulationTurn::all()->sortByDesc('id')->first()->id >= 10) $endReason = 'Wynaleziono szczepionkę';
        return $endReason;
    }
}
