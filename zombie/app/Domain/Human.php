<?php

namespace App\Domain;

class Human
{
    public function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly int         $age,
        private readonly Profession $profession,
        public string               $health,
        public int                  $lastEatAt,
        public readonly ?string     $deathCause,
    )
    {
    }

    public static function create(
        int     $id,
        string  $name,
        int     $age,
        string  $profession,
        string  $health,
        int     $lastEatAt,
        ?string $deathCause,
    ): self
    {
        return new self(
            $id,
            $name,
            $age,
            Profession::create($profession),
            $health,
            $lastEatAt,
            $deathCause,
        );
    }

    public static function fromArray(array $human): self
    {
        return new self(
            $human['id'],
            $human['name'],
            $human['age'],
            Profession::create($human['profession']),
            $human['health'],
            $human['last_eat_at'],
            $human['death_cause'],
        );
    }

    public function ateFood(int $turn): void
    {
        $this->lastEatAt = $turn;
    }

    public function getsHealthy(): void
    {
        $this->health = 'healthy';
    }

    public function professionName(): string
    {
        return $this->profession->name;
    }

    public function professionType(): string
    {
        return $this->profession->type;
    }
}
