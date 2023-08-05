<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationTurn extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public static function currentTurn(): int
    {
        return self::all()->sortByDesc('id')->first()->id;
    }

    public static function createNewTurn(string $status = 'active'): void
    {
        $turn = new self;
        $turn->status = $status;
        $turn->save();
    }

    public static function simulationIsOngoing(): bool
    {
        return self::first() !== null;
    }
}
