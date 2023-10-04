<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'quantity'
    ];

    public static function setResourceQuantity(string $type, int $quantity): void
    {
        self::updateOrCreate(
            ['type' => $type],
            [
                'type' => $type,
                'quantity' => $quantity,
            ]);
    }

    public static function getResourceQuantity(string $type): int
    {
        return self::where('type', $type)->first()->quantity;
    }
}
