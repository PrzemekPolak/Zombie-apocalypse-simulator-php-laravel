<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\Enum\HealthStatus;
use App\Domain\Human;
use App\Domain\Profession;

class HumanBuilder
{
    public function __construct(
        public int          $id,
        public string       $name,
        public int          $age,
        public Profession   $profession,
        public HealthStatus $health,
        public int          $lastEatAt,
        public ?string      $deathCause,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            mt_rand(1, 999999),
            'Name',
            mt_rand(1, 100),
            Profession::create('musician'),
            HealthStatus::Healthy,
            0,
            null,
        );
    }

    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->name,
            $this->age,
            $this->profession,
            $this->health,
            $this->lastEatAt,
            $this->deathCause,
        );
    }

    public function withInjury(): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->age,
            $this->profession,
            HealthStatus::Injured,
            $this->lastEatAt,
            $this->deathCause,
        );
    }

    public function withHealth(HealthStatus $healthStatus): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->age,
            $this->profession,
            $healthStatus,
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
            Profession::create($profession),
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
