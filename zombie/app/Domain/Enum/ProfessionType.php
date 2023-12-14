<?php

namespace App\Domain\Enum;

enum ProfessionType: string
{
    case None = 'none';
    case Health = 'health';
    case Food = 'food';
    case Weapon = 'weapon';
    case Fighting = 'fighting';
}
