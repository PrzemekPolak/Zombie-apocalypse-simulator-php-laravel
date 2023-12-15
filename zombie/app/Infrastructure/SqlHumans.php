<?php

namespace App\Infrastructure;

use App\Application\Humans;
use App\Domain\Enum\ResourceType;
use App\Models\Human as ModelHuman;
use App\Domain\Human;
use Illuminate\Support\Facades\DB;

class SqlHumans implements Humans
{
    /** @return Human[] */
    public function allAlive(): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::alive()->get()->toArray());
    }

    public function countAlive(): int
    {
        return ModelHuman::alive()->count();
    }

    /** @param $humans Human[] */
    public function save(array $humans): void
    {
        DB::transaction(function () use ($humans) {
            foreach ($humans as $human) {
                ModelHuman::updateOrCreate(
                    [
                        'id' => $human->id
                    ],
                    [
                        'name' => $human->name,
                        'age' => $human->age,
                        'profession' => $human->professionName(),
                        'health' => $human->health,
                        'last_eat_at' => $human->lastEatAt,
                        'death_cause' => $human->getDeathCause(),
                    ]
                );
            }
        });
    }

    public function getNumberOfResourceProducers(ResourceType $resourceType): int
    {
        return ModelHuman::getNumberOfResourceProducers($resourceType->value);
    }

    public function injured(): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::where('health', 'injured')->get()->toArray());
    }

    public function getRandomHumans(int $count): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::alive()->inRandomOrder()->get()->take($count)->toArray());
    }

    public function find(int $humanId): Human
    {
        return Human::fromArray(ModelHuman::find($humanId)->toArray());
    }

    public function all(): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::all()->toArray());
    }

    public function whoLastAteAt(int $turn): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::alive()->where('last_eat_at', '<=', $turn)->get()->toArray());
    }

    public function allWithHealth(string $health): array
    {
        return $this->mapToDomainHumansArray(ModelHuman::where('health', $health)->get()->toArray());
    }

    /** @return Human[] */
    private function mapToDomainHumansArray(array $dbArray): array
    {
        return array_map(static function ($human) {
            return Human::fromArray($human);
        }, $dbArray);
    }
}
