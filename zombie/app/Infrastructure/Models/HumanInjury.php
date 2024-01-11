<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanInjury extends Model
{
    use HasFactory;

    protected $fillable = [
        'injured_at',
        'injury_cause',
        'human_id',
    ];
}
