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

    public static function clearSimulationTables(): array
    {
        return [
            'method' => 'POST',
            'uri' => '/api/clearSimulation',
            'content' => [],
        ];
    }

    public static function setupSimulation(): array
    {
        return self::setupSimulationWithHumansAndZombies(10, 10);
    }

    public static function setupSimulationWithHumansAndZombies(int $humansCount, int $zombiesCount): array
    {
        return self::setupSimulationWithAllData($humansCount, $zombiesCount, 60, 50, 20, 10);
    }

    public static function setupSimulationWithEventChances(int $encounterChance, int $chanceForBite, int $injuryChance, int $immuneChance): array
    {
        return self::setupSimulationWithAllData(5, 10, $encounterChance, $chanceForBite, $injuryChance, $immuneChance);
    }

    private static function setupSimulationWithAllData(int $humansCount, int $zombiesCount, int $encounterChance, int $chanceForBite, int $injuryChance, int $immuneChance): array
    {
        return [
            'method' => 'POST',
            'uri' => '/api/send_settings',
            'content' => [
                'humanNumber' => $humansCount,
                'zombieNumber' => $zombiesCount,
                'encounterChance' => $encounterChance,
                'chanceForBite' => $chanceForBite,
                'injuryChance' => $injuryChance,
                'immuneChance' => $immuneChance,
            ],
        ];
    }
}
