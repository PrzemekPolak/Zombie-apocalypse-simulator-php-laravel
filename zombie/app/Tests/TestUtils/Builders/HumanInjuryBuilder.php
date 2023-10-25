<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\HumanInjury;

class HumanInjuryBuilder
{
    public function __construct(
        public int    $humanId,
        public int    $turn,
        public string $injuryCause,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            123,
            1,
            'Tripped',
        );
    }

    public function injuredHumanId(int $humanId): self
    {
        return new self(
            $humanId,
            $this->turn,
            $this->injuryCause,
        );
    }

    public function atTurn(int $turn): self
    {
        return new self(
            $this->humanId,
            $turn,
            $this->injuryCause,
        );
    }

    public function injuryCause(string $injuryCause): self
    {
        return new self(
            $this->humanId,
            $this->turn,
            $injuryCause,
        );
    }

    public function build(): HumanInjury
    {
        return new HumanInjury(
            $this->humanId,
            $this->turn,
            $this->injuryCause,
        );
    }
}
