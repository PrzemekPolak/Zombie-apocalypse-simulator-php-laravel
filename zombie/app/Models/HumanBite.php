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
}
