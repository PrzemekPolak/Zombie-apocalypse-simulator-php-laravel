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

    public function bite(Human $human): bool
    {
        if ($human->isImmuneToBite()) {
            $human->update(['health' => 'injured']);
            $injury = new HumanInjury();
            $injury->cause = 'bite';
            $injury->human_id = $this->id;
            $injury->save();
        } else {
            $human->update(['health' => 'infected']);
        }
        $humanBite = new HumanBite;
        $humanBite->human_id = $human->id;
        $humanBite->zombie_id = $this->id;
        $humanBite->save();
    }

    public function getInfectedBy(): HasMany
    {
        return $this->hasMany('HumanBite');
    }
}
