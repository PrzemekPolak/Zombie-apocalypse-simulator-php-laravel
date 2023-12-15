<?php

namespace App\Domain\Enum;

enum ResourceType: string
{
    case Food = 'food';
    case Health = 'health';
    case Weapon = 'weapon';

    public function equals(ResourceType $resourceType): bool
    {
        return $this->value === $resourceType->value;
    }
}
