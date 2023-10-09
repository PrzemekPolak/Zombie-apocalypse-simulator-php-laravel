<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\Human;

class HumanBuilder
{
    public function __construct(
        public int     $id,
        public string  $name,
        public int     $age,
        public string  $profession,
        public string  $health,
        public int     $lastEatAt,
        public ?string $deathCause,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            mt_rand(1, 999999),
            'Name',
            mt_rand(1, 100),
            'musician',
            'healthy',
            0,
            null,
        );
    }

    public function withInjury(): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->age,
            $this->profession,
            'injured',
            $this->lastEatAt,
            $this->deathCause,
        );
    }

    public function withProfession(string $profession): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->age,
            $profession,
            $this->health,
            $this->lastEatAt,
            $this->deathCause,
        );
    }

    public function lastAteAt(int $turn): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->age,
            $this->profession,
            $this->health,
            $turn,
            $this->deathCause,
        );
    }

    public function build(): Human
    {
        return new Human(
            $this->id,
            $this->name,
            $this->age,
            $this->profession,
            $this->health,
            $this->lastEatAt,
            $this->deathCause,
        );
    }
}
