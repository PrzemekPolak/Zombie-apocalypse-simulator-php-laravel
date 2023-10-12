<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\HumanBite;

class HumanBiteBuilder
{
    public function __construct(
        public int $humanId,
        public int $zombieId,
        public int $turn,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            123,
            246,
            1,
        );
    }

    public function withHumanId(int $humanId): self
    {
        return new self(
            $humanId,
            $this->zombieId,
            $this->turn,
        );
    }

    public function withTurn(int $turn): self
    {
        return new self(
            $this->humanId,
            $this->zombieId,
            $turn,
        );
    }

    public function build(): HumanBite
    {
        return new HumanBite(
            $this->humanId,
            $this->zombieId,
            $this->turn,
        );
    }
}
