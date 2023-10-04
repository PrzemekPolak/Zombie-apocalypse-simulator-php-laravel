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
        return $this->mapToDomainHumansArray(Human::alive()->get()->toArray());
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

    public function injured(): array
    {
        return $this->mapToDomainHumansArray(Human::where('health', 'injured')->get()->toArray());
    }

    /** @return DomainHuman[] */
    private function mapToDomainHumansArray(array $dbArray): array
    {
        return array_map(static function ($human) {
            return DomainHuman::fromArray($human);
        }, $dbArray);
    }

    public function add(DomainHuman $human): void
    {
        throw new \Exception('Not implemented!');
    }
}
