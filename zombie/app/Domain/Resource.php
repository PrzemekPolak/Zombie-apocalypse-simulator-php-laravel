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
