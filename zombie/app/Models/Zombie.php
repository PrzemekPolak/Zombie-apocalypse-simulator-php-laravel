<?php

namespace App\Models;

use App\Services\SimulationTurnService;
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
        $currentTurn = (new SimulationTurnService())->currentTurn();
        if ($human->isImmuneToBite()) {
            // die if it's second bite
            if ($human->health === 'injured') {
                $human->update(['health' => 'dead', 'death_cause' => 'zombie_bite']);
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
