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
        public int     $last_eat_at,
        public ?string $death_cause,
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
            $this->last_eat_at,
            $this->death_cause,
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
            $this->last_eat_at,
            $this->death_cause,
        );
    }
}
