<?php

namespace App\Services;

use App\Models\Human;
use App\Models\HumanBite;
use App\Models\HumanInjury;
use App\Models\Resource;
use App\Models\SimulationTurn;
use App\Models\Zombie;

class SimulationTurnService
{
    private function currentTurn()
    {
        return SimulationTurn::latest()->first()->id;
    }

    private function turnHumanIntoZombie(Human $human): void
    {
        $zombie = $human->replicate(['name', 'age', 'profession']);
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
        $humans = Human::all();
        foreach ($humans as $human) {
            if ($turn - $human->last_eat_at >= 3) {
                $human->update(['health', 'dead']);
            }
        }
    }

    public function checkWhoBleedOut(): void
    {
        $turn = $this->currentTurn();
        $humans = Human::all();
        foreach ($humans as $human) {
            if ($human->health === 'injured' && $turn - HumanInjury::where('human_id', $human->id)->latest()->first()->injured_at >= 2) {
                $human->update(['health', 'dead']);
            }
        }
    }

    public function checkWhoTurnIntoZombie(): void
    {
        $turn = $this->currentTurn();
        $humans = Human::all();
        foreach ($humans as $human) {
            if ($turn - HumanBite::where('human_id', $human->id)->latest()->first()->turn_id >= 1) {
                $this->turnHumanIntoZombie($human);
            }
        }
    }

    public function generateResources(): void
    {
        $healthProducers = Human::whereIn('profession', ['doctor', 'nurse'])->whereIn('health', ['healthy', 'infected'])->count();
        $foodProducers = Human::whereIn('profession', ['farmer', 'hunter'])->whereIn('health', ['healthy', 'infected'])->count();
        $weaponsProducers = Human::whereIn('profession', ['engineer', 'mechanic'])->whereIn('health', ['healthy', 'infected'])->count();
        $health = Resource::where('type', 'health')->first();
        $health->update(['quantity' => $health->quantity + $healthProducers * 2]);
        $food = Resource::where('type', 'food')->first();
        $food->update(['quantity' => $food->quantity + $foodProducers * 4]);
        $weapon = Resource::where('type', 'weapon')->first();
        $weapon->update(['quantity' => $weapon->quantity + $weaponsProducers * 1]);
    }

    public function zombieEncounters(): void
    {
        $encounterChance = 20; // TODO: later will be taken from settings table
        $defaultChanceForBite = 40;

        $humans = Human::all();
        $weapon = Resource::where('type', 'weapon')->first()->quantity;

        foreach ($humans as $human) {
            if (rand(0, 99) < $encounterChance) {
                $chanceForBite = $defaultChanceForBite;
                $zombie = Zombie::inRandomOrder()->limit(1)->get();
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
        }
        Resource::where('type', 'weapon')->first()->update(['weapon' => $weapon]);
    }

    // generates injuries not caused by zombies
    public function humanNonBiteInjuries(): void
    {
        $injuryChance = 1; // TODO: should be from db

        $humans = Human::all();
        foreach ($humans as $human) {
            if (rand(0, 99) < $injuryChance) {
                $injury = new HumanInjury();
                $injury->human_id = $human->id;
                $injury->injury_cause = $this->chooseInjuryCause();
                $injury->save();
            }
        }
    }

    // injured humans attempt to heal their injuries
    public function healHumanInjuries(): void
    {
        $humans = Human::all()->where('health', 'injured');
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
        $humans = Human::inRandomOrder()->all();
        $food = Resource::where('type', 'food')->first()->quantity;

        foreach ($humans as $human) {
            if ($food > 0) {
                $food = --$food;
            }
        }
        Resource::where('type', 'food')->first()->update(['food' => $food]);
    }
}
