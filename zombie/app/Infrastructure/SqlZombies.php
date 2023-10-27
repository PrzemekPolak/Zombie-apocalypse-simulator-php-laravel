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

    public function stillWalking(): array
    {
        return $this->mapToDomainZombiesArray(ModelZombie::stillWalking()->toArray());
    }

    public function all(): array
    {
        return $this->mapToDomainZombiesArray(ModelZombie::all()->toArray());
    }

    public function getRandomZombies(int $count = 1, bool $returnAllStillWalking = false): array
    {
        $finalCount = $returnAllStillWalking ? ModelZombie::stillWalking()->count() : $count;
        return $this->mapToDomainZombiesArray(ModelZombie::stillWalking()->inRandomOrder()->get()->take($finalCount)->toArray());
    }

    /** @return Zombie[] */
    private function mapToDomainZombiesArray(array $dbArray): array
    {
        return array_map(static function ($zombie) {
            return Zombie::fromArray($zombie);
        }, $dbArray);
    }
}
