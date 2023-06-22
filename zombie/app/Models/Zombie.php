<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Zombie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'profession',
        'health',
    ];

    public function bite(Human $human): void
    {
        $currentTurn = SimulationTurn::latest()->first()->id;
        if ($human->isImmuneToBite()) {
            // die if it's second bite
            if ($human->health === 'injured') {
                $human->update(['health' => 'dead']);
                // gets injured if it's first bite
            } else {
                $human->update(['health' => 'injured']);
                $injury = new HumanInjury();
                $injury->injury_cause = 'bite';
                $injury->human_id = $human->id;
                $injury->injured_at = $currentTurn;
                $injury->save();
            }
        } else {
            $human->update(['health' => 'infected']);
            $humanBite = new HumanBite;
            $humanBite->human_id = $human->id;
            $humanBite->zombie_id = $this->id;
            $humanBite->turn_id = $currentTurn;
            $humanBite->save();
        }
    }

    public function scopeStillWalking($query)
    {
        return $query->whereNot('health', 'dead');
    }

    public function getInfectedBy(): HasMany
    {
        return $this->hasMany('HumanBite');
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
        $translation = ['doctor' => 'Lekarz', 'nurse' => 'Pielęgniarka', 'farmer' => 'Rolnik', 'hunter' => 'Myśliwy',
            'engineer' => 'Inżynier', 'mechanic' => 'Mechanik', 'student' => 'Student', 'programmer' => 'Programista'];
        return $translation[$value];
    }
}
