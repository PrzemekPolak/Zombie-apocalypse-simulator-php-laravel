<?php

namespace App\Infrastructure;

use App\Application\HumanInjuries;
use App\Domain\HumanInjury;
use App\Models\HumanInjury as ModelHumanInjury;
use Illuminate\Support\Facades\DB;

class SqlHumanInjuries implements HumanInjuries
{
    public function fromTurn(int $turn): array
    {
        return $this->mapToDomainHumanInjuriesArray(ModelHumanInjury::where(['injured_at' => $turn])->get()->toArray());
    }

    public function save(array $humanInjuries): void
    {
        DB::transaction(function () use ($humanInjuries) {
            foreach ($humanInjuries as $humanInjury) {
                ModelHumanInjury::updateOrCreate(
                    [
                        'human_id' => $humanInjury->humanId,
                        'injured_at' => $humanInjury->turn,
                    ],
                    [
                        'human_id' => $humanInjury->humanId,
                        'injured_at' => $humanInjury->turn,
                        'injury_cause' => $humanInjury->injuryCause,
                    ]
                );
            }
        });
    }

    public function all(): array
    {
        return $this->mapToDomainHumanInjuriesArray(ModelHumanInjury::all()->toArray());
    }

    public function removeAll(): void
    {
        ModelHumanInjury::truncate();
    }

    /** @return HumanInjury[] */
    private function mapToDomainHumanInjuriesArray(array $dbArray): array
    {
        return array_map(static function ($humanInjury) {
            return HumanInjury::fromArray($humanInjury);
        }, $dbArray);
    }
}
