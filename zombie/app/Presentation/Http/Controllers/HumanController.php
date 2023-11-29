<?php

namespace App\Presentation\Http\Controllers;

use App\Models\Human;
use App\Presentation\Http\Controller;
use Illuminate\Http\Request;

class HumanController extends Controller
{
    public function getHumanRandomList(Request $request)
    {
        return Human::alive()->inRandomOrder()->limit(3)->get();
    }
}
