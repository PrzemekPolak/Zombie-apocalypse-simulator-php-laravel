<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationTurn extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];
}
