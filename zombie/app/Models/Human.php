<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'profession',
        'health',
        'last_eat_at',
        'death_cause',
    ];

    public function scopeAlive(Builder $query)
    {
        $query->whereNotIn('health', ['dead', 'turned']);
    }

    public static function getNumberOfResourceProducers(string $type): int
    {
        return self::alive()
            ->when('health' === $type, function ($q) {
                return $q->whereIn('profession', ['doctor', 'nurse']);
            })
            ->when('food' === $type, function ($q) {
                return $q->whereIn('profession', ['farmer', 'hunter']);
            })
            ->when('weapon' === $type, function ($q) {
                return $q->whereIn('profession', ['engineer', 'mechanic']);
            })
            ->whereIn('health', ['healthy', 'infected'])->count();
    }
}
