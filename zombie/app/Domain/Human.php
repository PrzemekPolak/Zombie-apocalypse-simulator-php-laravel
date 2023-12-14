<?php

namespace App\Domain;

use App\Domain\Enum\ProfessionType;

class Human
{
    public function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly int         $age,
        private readonly Profession $profession,
        public string               $health,
        public int                  $lastEatAt,
        private ?string             $deathCause,
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

    public function getsInjured(string $injury): void
    {
        if ($this->isNotHealthy()) {
            $this->die($injury);
        }
        if ($this->isHealthy()) {
            $this->health = 'injured';
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
        return $this->health === 'healthy';
    }

    public function isNotHealthy(): bool
    {
        return $this->health === 'infected' || $this->isInjured();
    }

    public function isInjured(): bool
    {
        return $this->health === 'injured';
    }

    public function die(string $reason): void
    {
        $this->health = 'dead';
        $this->deathCause = $reason;
    }

    public function getDeathCause(): ?string
    {
        return $this->deathCause;
    }

    public function isAlive(): bool
    {
        if ('healthy' === $this->health || 'injured' === $this->health || 'infected' === $this->health) {
            return true;
        } else return false;
    }

    public function becomeZombie(): void
    {
        $this->health = 'turned';
    }

    public function becomeInfected(): void
    {
        $this->health = 'infected';
    }
}
