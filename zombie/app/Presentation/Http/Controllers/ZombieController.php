<?php

namespace App\Presentation\Http\Controllers;

use App\Models\Zombie;
use App\Presentation\Http\Controller;
use Illuminate\Http\Request;

class ZombieController extends Controller
{
    public function getZombieRandomList(Request $request)
    {
        return Zombie::stillWalking()->inRandomOrder()->limit(3)->get();
    }
}
