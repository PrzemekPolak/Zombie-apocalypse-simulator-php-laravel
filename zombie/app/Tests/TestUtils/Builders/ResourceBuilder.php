<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\Resource;

class ResourceBuilder
{
    public function __construct(
        public string $type,
        public int    $quantity,
        public int    $productionMultiplier,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            'weapon',
            100,
            1
        );
    }

    public function withType(string $type): self
    {
        return new self(
            $type,
            $this->quantity,
            $this->productionMultiplier,
        );
    }

    public function withQuantity(int $quantity): self
    {
        return new self(
            $this->type,
            $quantity,
            $this->productionMultiplier,
        );
    }

    public function withProductionMultiplier(int $productionMultiplier): self
    {
        return new self(
            $this->type,
            $this->quantity,
            $productionMultiplier,
        );
    }

    public function build(): Resource
    {
        return new Resource(
            $this->type,
            $this->quantity,
            $this->productionMultiplier,
        );
    }
}
