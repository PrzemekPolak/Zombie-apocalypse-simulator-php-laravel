<?php

namespace App\Domain;

class Zombie
{
    public function __construct(
        public readonly int         $id,
        public readonly string      $name,
        public readonly int         $age,
        private readonly Profession $profession,
        public string               $health,
    )
    {
    }

    public static function fromHuman(Human $human): self
    {
        return new self(
            mt_rand(1000000, 9999999),
            $human->name,
            $human->age,
            Profession::create(
                $human->professionName(),
            ),
            'infected'
        );
    }

    public static function fromArray(array $zombie): self
    {
        return new self(
            $zombie['id'],
            $zombie['name'],
            $zombie['age'],
            Profession::create($zombie['profession']),
            $zombie['health'],
        );
    }

    public function professionName(): string
    {
        return $this->profession->name;
    }
}
