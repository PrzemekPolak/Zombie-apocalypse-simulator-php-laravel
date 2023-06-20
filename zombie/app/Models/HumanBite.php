<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanBite extends Model
{
    use HasFactory;

    protected $fillable = [
        'human_id',
        'zombie_id',
        'turn_id'
    ];

    protected static function booted(): void
    {
        static::saved(function (HumanBite $humanBite) {
            $humanBite->update(['turn_id' => SimulationTurn::latest()->first()->id]);
        });
    }
}
