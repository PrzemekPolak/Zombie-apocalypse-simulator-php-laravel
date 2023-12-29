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
}
