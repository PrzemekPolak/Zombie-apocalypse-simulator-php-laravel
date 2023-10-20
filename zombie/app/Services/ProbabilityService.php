<?php

namespace App\Services;

class ProbabilityService
{
    public function willItHappen(int $chanceInPercentages): bool
    {
        return random_int(0, 99) < $chanceInPercentages;
    }
}
