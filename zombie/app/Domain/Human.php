<?php

namespace App\Domain;

use App\Domain\Enum\HealthStatus;
use App\Domain\Enum\ProfessionType;

class Human
{
    public function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly int         $age,
        private readonly Profession $profession,
        public HealthStatus         $health,
        public int                  $lastEatAt,
        private ?string             $deathCause,
    )
    {
    }

    public static function create(
        int          $id,
        string       $name,
        int          $age,
        string       $profession,
        HealthStatus $health,
        int          $lastEatAt,
        ?string      $deathCause,
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
            HealthStatus::from($human['health']),
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
        $this->health = HealthStatus::Healthy;
    }

    public function getsInjured(string $injury): void
    {
        if ($this->isNotHealthy()) {
            $this->die($injury);
        }
        if ($this->isHealthy()) {
            $this->health = HealthStatus::Injured;
        }
    }

    public function professionName(): string
    {
        return $this->profession->name;
    }

    public function professionTranslatedName(): string
    {
        return $this->profession->translatedName();
    }

    public function professionType(): ProfessionType
    {
        return $this->profession->type;
    }

    public function isHealthy(): bool
    {
        return $this->health->equals(HealthStatus::Healthy);
    }

    public function isNotHealthy(): bool
    {
        return $this->health->equals(HealthStatus::Infected) || $this->isInjured();
    }

    public function isInjured(): bool
    {
        return $this->health->equals(HealthStatus::Injured);
    }

    public function die(string $reason): void
    {
        $this->health = HealthStatus::Dead;
        $this->deathCause = $reason;
    }

    public function getDeathCause(): ?string
    {
        return $this->deathCause;
    }

    public function isAlive(): bool
    {
        if ($this->isHealthy() || $this->isInjured() || $this->health->equals(HealthStatus::Infected)) {
            return true;
        } else return false;
    }

    public function becomeZombie(): void
    {
        $this->health = HealthStatus::Turned;
    }

    public function becomeInfected(): void
    {
        $this->health = HealthStatus::Infected;
    }
}
