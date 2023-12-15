<?php

namespace App\Domain;

use App\Domain\Enum\ResourceType;

class Resource
{
    private function __construct(
        public readonly ResourceType $type,
        private int                  $quantity,
        public readonly int          $productionMultiplier,
    )
    {
    }

    public static function create(
        ResourceType $type,
        int          $quantity,
    ): self
    {
        return new self(
            $type,
            $quantity,
            $type->equals(ResourceType::Food) ? 2 : 1,
        );
    }

    public static function fromArray(array $resource): self
    {
        return new self(
            ResourceType::from($resource['type']),
            $resource['quantity'],
            ResourceType::from($resource['type'])->equals(ResourceType::Food) ? 2 : 1,
        );
    }

    public function consume(): void
    {
        --$this->quantity;
    }

    public function produce(int $amount): void
    {
        $this->quantity += $this->productionMultiplier * $amount;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }
}
