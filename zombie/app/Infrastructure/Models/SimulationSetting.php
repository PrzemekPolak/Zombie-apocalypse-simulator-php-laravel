<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'chance',
        'description',
    ];
}
