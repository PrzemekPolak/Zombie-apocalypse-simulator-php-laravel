<?php

namespace App\Domain;

class Resource
{
    public function __construct(
        public readonly string $type,
        private int            $quantity,
        public readonly int    $productionMultiplier,
    )
    {
    }

    public static function create(
        string $type,
        int    $quantity,
    ): self
    {
        return new self(
            $type,
            $quantity,
            $type === 'food' ? 2 : 1,
        );
    }

    public static function fromArray(array $resource): self
    {
        return new self(
            $resource['type'],
            $resource['quantity'],
            $resource['type'] === 'food' ? 2 : 1,
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
}
