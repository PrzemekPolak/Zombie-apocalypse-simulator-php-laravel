<?php

namespace App\Infrastructure;

use App\Application\HumanBites;
use App\Domain\HumanBite;
use App\Infrastructure\Models\HumanBite as ModelHumanBite;
use Illuminate\Support\Facades\DB;

class SqlHumanBites implements HumanBites
{
    public function fromTurn(int $turn): array
    {
        return $this->mapToDomainHumanBitesArray(ModelHumanBite::where('turn_id', $turn - 1)->get()->toArray());
    }

    public function save(array $humanBites): void
    {
        DB::transaction(function () use ($humanBites) {
            foreach ($humanBites as $humanBite) {
                ModelHumanBite::updateOrCreate(
                    [
                        'human_id' => $humanBite->humanId,
                        'zombie_id' => $humanBite->zombieId,
                        'turn_id' => $humanBite->turn,
                    ],
                    [
                        'human_id' => $humanBite->humanId,
                        'zombie_id' => $humanBite->zombieId,
                        'turn_id' => $humanBite->turn,
                    ]
                );
            }
        });
    }

    public function all(): array
    {
        return $this->mapToDomainHumanBitesArray(ModelHumanBite::all()->toArray());
    }

    public function removeAll(): void
    {
        ModelHumanBite::truncate();
    }

    /** @return HumanBite[] */
    private function mapToDomainHumanBitesArray(array $dbArray): array
    {
        return array_map(static function ($humanBite) {
            return HumanBite::fromArray($humanBite);
        }, $dbArray);
    }
}
