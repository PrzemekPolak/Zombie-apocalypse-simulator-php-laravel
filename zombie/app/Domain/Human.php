<?php

namespace App\Domain;

class Human
{
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly int     $age,
        public readonly string  $profession,
        public string           $health,
        public int              $last_eat_at,
        public readonly ?string $death_cause,
    )
    {
    }

    public static function fromArray(array $human): self
    {
        return new self(
            $human['id'],
            $human['name'],
            $human['age'],
            $human['profession'],
            $human['health'],
            $human['last_eat_at'],
            $human['death_cause'],
        );
    }

    public function ateFood(int $turn): void
    {
        $this->last_eat_at = $turn;
    }

    public function getsHealthy(): void
    {
        $this->health = 'healthy';
    }
}
