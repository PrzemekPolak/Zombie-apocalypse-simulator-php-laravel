<?php

namespace App\Models;

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

    public function scopeAlive($query)
    {
        return $query->whereNot('health', 'dead');

    }

    public function useHealingResource(): void
    {
        $health = Resource::where('type', 'health')->first();
        $health->quantity = --$health->quantity;
        $health->save();

        if ($this->health === 'injured') {
            $this->health = 'healthy';
            $this->save();
        }
    }
}
