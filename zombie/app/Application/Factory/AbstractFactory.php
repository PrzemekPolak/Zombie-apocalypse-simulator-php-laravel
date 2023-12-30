<?php

namespace App\Application\Factory;

use Faker\Generator;
use Illuminate\Container\Container;

abstract class AbstractFactory
{
    public static function create(int $id): mixed
    {
        throw new \RuntimeException("Unimplemented function create() in concrete factory");
    }

    public static function createMany(int $count): array
    {
        $result = [];

        for ($i = 1; $i <= $count; $i++) {
            $result[] = static::create($i);
        }

        return $result;
    }

    public static function faker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }
}
