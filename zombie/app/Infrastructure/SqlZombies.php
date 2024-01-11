<?php

namespace App\Infrastructure;

use App\Application\Zombies;
use App\Domain\Zombie;
use App\Infrastructure\Models\Zombie as ModelZombie;
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

    public function stillWalking(): array
    {
        return $this->mapToDomainZombiesArray(ModelZombie::stillWalking()->get()->toArray());
    }

    public function all(): array
    {
        return $this->mapToDomainZombiesArray(ModelZombie::all()->toArray());
    }

    public function getNumberOfRandomStillWalkingZombies(int $count): array
    {
        return $this->mapToDomainZombiesArray(ModelZombie::stillWalking()->inRandomOrder()->get()->take($count)->toArray());
    }

    public function removeAll(): void
    {
        ModelZombie::truncate();
    }

    /** @return Zombie[] */
    private function mapToDomainZombiesArray(array $dbArray): array
    {
        return array_map(static function ($zombie) {
            return Zombie::fromArray($zombie);
        }, $dbArray);
    }
}
