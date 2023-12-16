<?php

namespace App\Domain;

use App\Domain\Enum\HealthStatus;

class Zombie
{
    public function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly int         $age,
        private readonly Profession $profession,
        public HealthStatus         $health,
    )
    {
    }

    public static function fromHuman(Human $human): self
    {
        return new self(
            mt_rand(1000000, 9999999),
            $human->name,
            $human->age,
            Profession::create(
                $human->professionName(),
            ),
            HealthStatus::Turned
        );
    }

    public static function fromArray(array $zombie): self
    {
        return new self(
            $zombie['id'],
            $zombie['name'],
            $zombie['age'],
            Profession::create($zombie['profession']),
            HealthStatus::from($zombie['health']),
        );
    }

    public function professionName(): string
    {
        return $this->profession->name;
    }

    public function professionTranslatedName(): string
    {
        return $this->profession->translatedName();
    }

    public function getsKilled(): void
    {
        $this->health = HealthStatus::Dead;
    }
}
