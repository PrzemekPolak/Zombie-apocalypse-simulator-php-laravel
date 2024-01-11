<?php

namespace App\Models;

use App\Presentation\Requests\StartSimulationRequest;
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
