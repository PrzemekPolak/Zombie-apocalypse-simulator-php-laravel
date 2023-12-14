<?php

namespace App\Presentation\View;

use App\Domain\Zombie;

class ZombieView
{
    public function __construct(
        public readonly string $name,
        public readonly int    $age,
        public readonly string $health,
        public readonly string $profession,
    )
    {
    }

    public static function fromDto(Zombie $zombie): self
    {
        return new self(
            $zombie->name,
            $zombie->age,
            $zombie->health,
            $zombie->professionTranslatedName(),
        );
    }
}
