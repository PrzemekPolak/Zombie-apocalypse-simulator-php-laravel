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

    public static function add(int $humanId, int $zombieId, int $turnId): void
    {
        $humanBite = new self;
        $humanBite->human_id = $humanId;
        $humanBite->zombie_id = $zombieId;
        $humanBite->turn_id = $turnId;
        $humanBite->save();
    }

}
