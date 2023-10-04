<?php

namespace App\Domain;

class Human
{
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly int     $age,
        public readonly string  $profession,
        public readonly string  $health,
        public int              $last_eat_at,
        public readonly ?string $death_cause,
    )
    {
    }

    public function ateFood(int $turn): void
    {
        $this->last_eat_at = $turn;
    }
}
