<?php

namespace App\Infrastructure;

use App\Application\Humans;
use App\Models\Human;
use App\Domain\Human as DomainHuman;
use Illuminate\Support\Facades\DB;

class SqlHumans implements Humans
{
    public function __construct()
    {
        $this->human = new Human();
    }

    /** @return DomainHuman[] */
    public function allAlive(): array
    {
        return array_map(static function ($human) {
            return new DomainHuman(
                $human['id'],
                $human['name'],
                $human['age'],
                $human['profession'],
                $human['health'],
                $human['last_eat_at'],
                $human['death_cause'],
            );
        }, Human::alive()->get()->toArray());
    }

    public function countAlive(): int
    {
        return Human::alive()->count();
    }

    public function update(int $id, array $fields): void
    {
        $this->human->where(['id' => $id])->update($fields);
    }

    /** @param $humans DomainHuman[] */
    public function saveFromArray(array $humans): void
    {
        DB::transaction(function () use ($humans) {
            foreach ($humans as $human) {
                $this->human->where(['id' => $human->id])->update(
                    [
                        'name' => $human->name,
                        'age' => $human->age,
                        'profession' => $human->profession,
                        'health' => $human->health,
                        'last_eat_at' => $human->last_eat_at,
                        'death_cause' => $human->death_cause,
                    ]
                );
            }
        });
    }

    public function getNumberOfResourceProducers(string $resourceType): int
    {
        return $this->human::getNumberOfResourceProducers($resourceType);
    }
}
