<?php

namespace App\Models;

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

    public function bite(Human $human): void
    {
        $currentTurn = SimulationTurn::currentTurn();
        if ($human->isImmuneToBite()) {
            // die if it's second bite
            if ($human->health === 'injured') {
                $human->die('zombie_bite');
                // gets injured if it's first bite
            } else {
                $human->setHealth('injured');
                HumanInjury::add($human->id, 'bite', $currentTurn);
            }
        } else {
            $human->setHealth('infected');
            HumanBite::add($human->id, $this->id, $currentTurn);
        }
    }

    public function scopeStillWalking($query)
    {
        return $query->whereNot('health', 'dead');
    }

//    public function getHealthAttribute($value): string
//    {
//        $translation = ['injured' => 'Ranny',
//            'healthy' => 'Zdrowy',
//            'infected' => 'Zarażony',
//            'dead' => 'Martwy'];
//        return $translation[$value];
//    }

    public function die(): void
    {
        $this->update(['health' => 'dead']);
    }
}
