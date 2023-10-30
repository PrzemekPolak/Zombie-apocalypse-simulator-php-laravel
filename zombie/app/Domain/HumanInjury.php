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

    public static function fromArray(array $humanInjury): self
    {
        return new self(
            $humanInjury['human_id'],
            $humanInjury['injured_at'],
            $humanInjury['injury_cause'],
        );
    }
}
