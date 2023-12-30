<?php

namespace App\Tests\TestUtils\Builders;

class ExampleRequest
{
    public static function executeTurn(): array
    {
        return [
            'method' => 'POST',
            'uri' => '/api/simulation_turn',
            'content' => [],
        ];
    }

    public static function setupSimulation(): array
    {
        return self::setupSimulationWithHumansAndZombies(10, 10);
    }

    public static function setupSimulationWithHumansAndZombies(int $humansCount, int $zombiesCount): array
    {
        return [
            'method' => 'POST',
            'uri' => '/api/send_settings',
            'content' => [
                'humanNumber' => $humansCount,
                'zombieNumber' => $zombiesCount,
                'encounterChance' => 60,
                'chanceForBite' => 60,
                'injuryChance' => 20,
                'immuneChance' => 20,
            ],
        ];
    }

    public static function clearSimulationTables(): array
    {
        return [
            'method' => 'POST',
            'uri' => '/api/clearSimulation',
            'content' => [],
        ];
    }
}
