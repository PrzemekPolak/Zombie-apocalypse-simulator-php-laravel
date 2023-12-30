<?php

namespace App\Application\Factory;

use App\Domain\Enum\HealthStatus;
use App\Domain\Profession;
use App\Domain\Zombie;

class ZombieFactory extends AbstractFactory
{
    public static function create(int $id): Zombie
    {
        return new Zombie(
            $id,
            self::faker()->name(),
            self::faker()->numberBetween(12, 80),
            Profession::create(self::faker()->randomElement(['doctor', 'nurse', 'farmer', 'hunter', 'engineer', 'mechanic', 'student', 'programmer'])),
            HealthStatus::Infected,
        );
    }
}
