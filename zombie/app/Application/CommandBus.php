<?php

namespace App\Application;

interface CommandBus
{
    public function dispatch($command): void;

    public function map(array $map): void;
}
