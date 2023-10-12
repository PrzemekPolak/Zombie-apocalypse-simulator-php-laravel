<?php

namespace App\Domain;

class HumanBite
{
    public function __construct(
        public readonly int $humanId,
        public readonly int $zombieId,
        public readonly int $turn,
    )
    {
    }

    public function fromArray(array $humanBite): self
    {
        return new self(
            $humanBite['human_id'],
            $humanBite['zombie_id'],
            $humanBite['turn_id'],
        );
    }
}
