<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanInjury extends Model
{
    use HasFactory;

    protected $fillable = [
        'injured_at',
        'injury_cause',
        'human_id',
    ];

    public static function add(int $humanId, string $injuryCause, int $turnId): void
    {
        $injury = new self();
        $injury->injury_cause = $injuryCause;
        $injury->human_id = $humanId;
        $injury->injured_at = $turnId;
        $injury->save();
    }

}
