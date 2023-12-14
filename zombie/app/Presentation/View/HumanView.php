<?php

namespace App\Presentation\View;

use App\Domain\Human;

class HumanView
{
    public function __construct(
        public readonly string $name,
        public readonly int    $age,
        public readonly string $health,
        public readonly string $profession,
        public readonly string $lastEatAt,
    )
    {
    }

    public static function fromDto(Human $human, int $currentTurn): self
    {
        return new self(
            $human->name,
            $human->age,
            $human->health,
            $human->professionTranslatedName(),
            $currentTurn - $human->lastEatAt,
        );
    }
}
