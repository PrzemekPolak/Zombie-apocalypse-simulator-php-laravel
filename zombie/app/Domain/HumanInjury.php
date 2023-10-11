<?php

namespace App\Domain;

class HumanInjury
{
    public function __construct(
        public readonly int    $injuredAt,
        public readonly string $injuryCause,
        public readonly int    $humanId,
    )
    {
    }
}
