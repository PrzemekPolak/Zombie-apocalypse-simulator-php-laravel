<?php

namespace App\Infrastructure;

use App\Application\HumanBites;
use App\Domain\HumanBite;
use App\Models\HumanBite as ModelHumanBite;

class SqlHumanBites implements HumanBites
{
    public function fromTurn(int $turn): array
    {
        return $this->mapToDomainHumanBitesArray(ModelHumanBite::where('turn_id', $turn - 1)->get()->toArray());
    }

    public function add(int $humanId, int $zombieId, int $turn): void
    {
        ModelHumanBite::add($humanId, $zombieId, $turn);
    }

    /** @return HumanBite[] */
    private function mapToDomainHumanBitesArray(array $dbArray): array
    {
        return array_map(static function ($human) {
            return HumanBite::fromArray($human);
        }, $dbArray);
    }
}
