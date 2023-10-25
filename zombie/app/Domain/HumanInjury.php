<?php

namespace App\Domain;

class HumanInjury
{
    public function __construct(
        public readonly int    $humanId,
        public readonly int    $turn,
        public readonly string $injuryCause,
    )
    {
    }
}
