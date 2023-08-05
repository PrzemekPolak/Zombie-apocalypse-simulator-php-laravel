<?php

namespace App\Models;

use App\Http\Requests\StartSimulationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'event',
        'chance',
        'description',
    ];

    public static function getEventChance(string $event): int
    {
        return self::where('event', $event)->first()->chance;
    }

    public static function updateAllSettings(StartSimulationRequest $request): void
    {
        $events = self::all()->pluck('event')->toArray();
        foreach ($events as $event) {
            self::where('event', $event)->update(['chance' => $request->input($event)]);
        }
    }
}
