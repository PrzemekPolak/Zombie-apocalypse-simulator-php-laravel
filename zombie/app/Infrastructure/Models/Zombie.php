<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zombie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'profession',
        'health',
    ];

    public function scopeStillWalking($query)
    {
        return $query->whereNot('health', 'dead');
    }
}
