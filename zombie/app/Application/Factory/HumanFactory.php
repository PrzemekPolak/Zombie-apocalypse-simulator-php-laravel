<?php

namespace App\Application\Factory;

use App\Domain\Enum\HealthStatus;
use App\Domain\Human;
use App\Domain\Profession;

class HumanFactory extends AbstractFactory
{
    public static function create(int $id): Human
    {
        return new Human(
            $id,
            self::faker()->name(),
            self::faker()->numberBetween(12, 80),
            Profession::create(self::faker()->randomElement(['doctor', 'nurse', 'farmer', 'hunter', 'engineer', 'mechanic', 'student', 'programmer'])),
            HealthStatus::Healthy,
            0,
            null,
        );
    }
}
