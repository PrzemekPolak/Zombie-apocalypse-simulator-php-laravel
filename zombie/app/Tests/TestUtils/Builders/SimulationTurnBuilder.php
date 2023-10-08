<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\SimulationTurn;

class SimulationTurnBuilder
{
    public function __construct(
        public int    $turnNumber,
        public string $status,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            1,
            'active',
        );
    }

    public function withTurnNumber(int $turn): self
    {
        return new self(
            $turn,
            $this->status,
        );
    }

    public function build(): SimulationTurn
    {
        return new SimulationTurn(
            $this->turnNumber,
            $this->status,
        );
    }
}
