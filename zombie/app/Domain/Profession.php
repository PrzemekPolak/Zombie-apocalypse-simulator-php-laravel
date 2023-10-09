<?php

namespace App\Domain;

class Profession
{
    private function __construct(
        public readonly string $name,
        public readonly string $type,
    )
    {
    }

    public static function create(
        string $name,
    ): self
    {
        $type = 'none';

        if (in_array($name, ['doctor', 'nurse'])) {
            $type = 'health';
        }
        if (in_array($name, ['farmer', 'hunter'])) {
            $type = 'food';
        }
        if (in_array($name, ['engineer', 'mechanic'])) {
            $type = 'weapon';
        }

        return new self(
            $name,
            $type,
        );
    }
}
