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

    public function translatedValue(): string
    {
        return $this->translations()[$this->value];
    }

    private function translations(): array
    {
        return [
            'healthy' => 'Zdrowy',
            'injured' => 'Ranny',
            'infected' => 'Zarażony',
            'turned' => 'Stał się zombie',
            'dead' => 'Martwy',
        ];
    }
}
