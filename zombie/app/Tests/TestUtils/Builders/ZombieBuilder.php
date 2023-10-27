<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\Profession;
use App\Domain\Zombie;

class ZombieBuilder
{
    public function __construct(
        public readonly int $id,
        public string       $health,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            mt_rand(1, 999999),
            'turned',
        );
    }

    public function build(): Zombie
    {
        return new Zombie(
            $this->id,
            'Default name',
            28,
            Profession::create('plumber'),
            $this->health,
        );
    }
}
