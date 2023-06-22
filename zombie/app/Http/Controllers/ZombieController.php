<?php

namespace App\Http\Controllers;

use App\Models\Zombie;
use Illuminate\Http\Request;

class ZombieController extends Controller
{
    public function getZombieRandomList(Request $request)
    {
        return Zombie::stillWalking()->inRandomOrder()->limit(3)->get();
    }
}
