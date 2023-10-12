<?php

namespace App\Infrastructure;

use App\Application\Zombies;
use App\Domain\Zombie;
use App\Models\Zombie as ModelZombie;
use Illuminate\Support\Facades\DB;

class SqlZombies implements Zombies
{
    /** @param Zombie[] $zombies */
    public function save(array $zombies): void
    {
        DB::transaction(function () use ($zombies) {
            foreach ($zombies as $zombie) {
                ModelZombie::updateOrCreate(
                    [
                        'id' => $zombie->id
                    ],
                    [
                        'name' => $zombie->name,
                        'age' => $zombie->age,
                        'profession' => $zombie->professionName(),
                        'health' => $zombie->health,
                    ]
                );
            }
        });
    }

    public function add(Zombie $zombie): void
    {
        $newZombie = new ModelZombie();
        $newZombie->name = $zombie->name;
        $newZombie->age = $zombie->age;
        $newZombie->profession = $zombie->professionName();
        $newZombie->health = $zombie->health;
        $newZombie->save();
    }
}
