<?php

namespace App\Domain\Enum;

enum HealthStatus: string
{
    case Healthy = 'healthy';
    case Injured = 'injured';
    case Infected = 'infected';
    case Turned = 'turned';
    case Dead = 'dead';

    public function equals(HealthStatus $healthStatus): bool
    {
        return $this->value === $healthStatus->value;
    }
}
