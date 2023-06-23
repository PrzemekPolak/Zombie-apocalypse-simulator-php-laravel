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
    ];

    public function isImmuneToBite(): bool
    {
        $immuneChance = SimulationSetting::where('event', 'immuneChance')->first()->chance;
        return rand(0, 99) < $immuneChance;
    }

    public function killZombie(Zombie $zombie): bool
    {
        return $zombie->update(['health' => 'dead']);
    }

    public function scopeAlive(Builder $query)
    {
        $query->whereNotIn('health', ['dead', 'turned']);
    }

    public function scopeHealthy(Builder $query)
    {
        $query->where('health', 'healthy');
    }

    public function getHealthAttribute($value): string
    {
        $translation = ['injured' => 'Ranny',
            'healthy' => 'Zdrowy',
            'infected' => 'Zarażony',
            'dead' => 'Martwy'];
        return $translation[$value];
    }

    public function getProfessionAttribute($value): string
    {
        $translation = [
            'doctor' => 'lekarz',
            'nurse' => 'pielęgniarka',
            'farmer' => 'rolnik',
            'hunter' => 'łowca',
            'engineer' => 'inżynier',
            'mechanic' => 'mechanik',
            'student' => 'student',
            'programmer' => 'programista',
            'teacher' => 'nauczyciel',
            'lawyer' => 'prawnik',
            'accountant' => 'księgowy',
            'architect' => 'architekt',
            'chef' => 'szef kuchni',
            'writer' => 'pisarz',
            'artist' => 'artysta',
            'musician' => 'muzyk',
            'photographer' => 'fotograf',
            'dentist' => 'dentysta',
            'pilot' => 'pilot',
            'scientist' => 'naukowiec',
            'firefighter' => 'strażak',
            'marketing manager' => 'kierownik marketingu',
            'graphic designer' => 'grafik',
            'athlete' => 'sportowiec',
            'veterinarian' => 'weterynarz',
            'journalist' => 'dziennikarz',
            'electrician' => 'elektryk',
            'psychologist' => 'psycholog'
        ];
        return $translation[$value];
    }
}
