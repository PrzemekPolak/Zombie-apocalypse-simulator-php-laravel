<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\Resource;

class ResourceBuilder
{
    public function __construct(
        public string $type,
        public int    $quantity,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            'weapon',
            100,
        );
    }

    public function withType(string $type): self
    {
        return new self(
            $type,
            $this->quantity,
        );
    }

    public function withQuantity(int $quantity): self
    {
        return new self(
            $this->type,
            $quantity,
        );
    }

    public function build(): Resource
    {
        return Resource::create(
            $this->type,
            $this->quantity,
        );
    }
}
