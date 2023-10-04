<?php

namespace App\Domain;

class Resource
{
    public function __construct(
        public readonly string $type,
        private int            $quantity,
    )
    {
    }

    public function consume(): void
    {
        --$this->quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
