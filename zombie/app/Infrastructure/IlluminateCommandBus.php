<?php

namespace App\Infrastructure;

use App\Application\CommandBus;
use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    public function __construct(
        private readonly Dispatcher $bus
    )
    {
    }

    public function dispatch($command): void
    {
        $this->bus->dispatch($command);
    }

    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
