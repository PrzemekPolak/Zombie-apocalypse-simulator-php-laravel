<?php

namespace App\Application\Command;

class PopulateDbWithInitialDataCommand
{
    public function __construct(
        public readonly int $humansCount,
        public readonly int $zombiesCount,
    )
    {
    }
}
